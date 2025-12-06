<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Bundle;
use App\Models\School;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BundleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $bundles = Bundle::with(['school', 'books'])
            ->withCount('books')
            ->join('schools', 'bundles.school_id', '=', 'schools.id')
            ->orderBy('schools.name', 'asc')
            ->select('bundles.*') // important to avoid column collision
            ->latest('bundles.created_at')
            ->paginate(10);

        return view('bundles.index', compact('bundles'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $initialBooks = Book::latest()->take(10)->get();
        return view('bundles.create', compact('initialBooks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'bundle_name' => ['nullable', 'string', 'max:255'],
            'school_id' => ['required', 'exists:schools,id'],
            'class_name' => ['required', 'string', 'max:255'],
            'school_percentage' => ['required', 'numeric', 'min:0', 'max:100'],
            'customer_discount' => ['required', 'numeric', 'min:0', 'max:100'],
            'books' => ['required', 'array', 'min:1'],
            'books.*' => ['exists:books,id'],
        ]);


        try {
            DB::transaction(function () use ($validated): Bundle {

                // Calculate total selling price of selected books
                $totalPrice = Book::whereIn('id', $validated['books'])->sum('selling_price');


                // get school for genrating bundle name
                $school = School::findOrFail($validated['school_id']);

                // Create bundle
                $bundle = Bundle::create([
                    'school_id' => $validated['school_id'],
                    'bundle_name' => "{$school->name} {$validated['class_name']}",
                    'class_name' => $validated['class_name'],
                    'school_percentage' => $validated['school_percentage'],
                    'customer_discount' => $validated['customer_discount'],
                    'qr_code' => '',
                ]);

                // Attach selected books
                $bundle->books()->sync($validated['books']);

                // Generate QR
                $qrRoute = route('checkout.bundle.show', $bundle->id);
                $fileName = "bundle-{$bundle->bundle_name}-{$bundle->id}.svg";
                $storagePath = "qrcodes/{$fileName}";

                $qrImage = QrCode::format('svg')
                    ->size(500)
                    ->margin(2)
                    ->errorCorrection('H')
                    ->generate($qrRoute);

                Storage::disk('public')->put($storagePath, $qrImage);

                // Save QR path
                $bundle->update([
                    'qr_code' => asset("storage/{$storagePath}"),
                ]);

                return $bundle;
            });

            return Redirect::route('bundles.index')
                ->with('success', 'Bundle created successfully with QR code!');

        } catch (Exception $e) {

            Log::error('Bundle creation failed', [
                'error' => $e->getMessage(),
                'data' => $validated,
            ]);

            return Redirect::back()
                ->withErrors(['error' => 'Failed to create bundle. Please try again.'])
                ->withInput();
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Bundle $bundle): View
    {
        $bundle->load(['school', 'books']); // eager load relationships
        return view('bundles.show', compact('bundle'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bundle $bundle): View
    {
        $bundle->load('books');
        $initialBooks = Book::latest()->take(10)->get();
        return view('bundles.edit', compact('bundle', 'initialBooks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bundle $bundle): RedirectResponse
    {
        // Validate input
        $validated = $request->validate([
            'school_id' => ['required', 'exists:schools,id'],
            'class_name' => ['required', 'string', 'max:255'],
            'school_percentage' => ['required', 'numeric', 'min:0', 'max:100'],
            'customer_discount' => ['required', 'numeric', 'min:0', 'max:100'],
            'books' => ['required', 'array', 'min:1'],
            'books.*' => ['exists:books,id'],
        ]);

        try {
            DB::transaction(function () use ($validated, $bundle) {

                // Update bundle fields
                $bundle->update([
                    'school_id' => $validated['school_id'],
                    'class_name' => $validated['class_name'],
                    'school_percentage' => $validated['school_percentage'],
                    'customer_discount' => $validated['customer_discount'],
                ]);

                // Sync selected books
                $bundle->books()->sync($validated['books']);

                // Regenerate QR code
                $qrRoute = route('checkout.bundle.show', $bundle->id);
                $fileName = "bundle-{$bundle->id}.svg";
                $storagePath = "qrcodes/{$fileName}";

                // Generate QR
                $qrImage = QrCode::format('svg')
                    ->size(500)
                    ->margin(2)
                    ->errorCorrection('H')
                    ->generate($qrRoute);

                // Save QR
                Storage::disk('public')->put($storagePath, $qrImage);

                // Update QR path
                $bundle->update([
                    'qr_code' => asset("storage/{$storagePath}"),
                ]);
            });

            return Redirect::route('bundles.index')
                ->with('success', 'Bundle updated successfully!');

        } catch (Exception $e) {
            Log::error('Bundle update failed', [
                'error' => $e->getMessage(),
                'bundle_id' => $bundle->id,
                'data' => $validated,
            ]);

            return Redirect::back()
                ->withErrors(['error' => 'Failed to update bundle. Please try again.'])
                ->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bundle $bundle): RedirectResponse
    {
        // Delete QR code file if exists
        if ($bundle->qr_code && Storage::disk('public')->exists($bundle->qr_code)) {
            Storage::disk('public')->delete($bundle->qr_code);
        }

        // Delete bundle record
        $bundle->delete();

        return Redirect::route('bundles.index')
            ->with('success', 'Bundle deleted successfully!');
    }

    /**
     * Show printing page for QR Code.
     */
    public function print(string $bundleId): View
    {
        $bundle = Bundle::with('school')->findOrFail($bundleId);

        // Load Blade view directly (for inline print)
        return view('bundles.print', compact('bundle'));
    }


}

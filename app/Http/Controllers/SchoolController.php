<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Withdraw;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $schools = School::filter($request, [
            'name' => 'string',
        ])->orderBy('name', 'asc')->paginate(20);
        return view('schools.index', compact('schools'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('schools.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'principal_name' => 'required|string|max:255',
            'email' => 'required|email|unique:schools,email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Upload logo if provided
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('schools/logo', 'public');
            $validated['logo'] = $path;
        }

        // Save school to database
        School::create($validated);

        // Redirect back with success message
        return Redirect::route('schools.index')
            ->with('success', 'School added successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(School $school): View
    {
        $school->load('bundles'); // eager load related bundles
        $withdraws = Withdraw::where('school_id', $school->id)->paginate(20);
        return view('schools.show', compact('school', 'withdraws'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(School $school): View
    {
        $withdraws = Withdraw::where('school_id', $school->id)->paginate(20);
        return view('schools.edit', compact('school', 'withdraws'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, School $school): RedirectResponse
    {
        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'principal_name' => 'required|string|max:255',
            'email' => 'required|email|unique:schools,email,'.$school->id,
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Handle new logo upload
        if ($request->hasFile('logo')) {

            // Delete old logo if exists
            if ($school->logo && Storage::disk('public')->exists($school->logo)) {
                Storage::disk('public')->delete($school->logo);
            }

            // Upload new logo
            $path = $request->file('logo')->store('schools/logo', 'public');
            $validated['logo'] = $path;
        }

        // Update school record
        $school->update($validated);

        // Redirect with success message
        return Redirect::route('schools.index')
            ->with('success', 'School updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(School $school): RedirectResponse
    {
        // Delete logo from storage if exists
        if ($school->logo && Storage::disk('public')->exists($school->logo)) {
            Storage::disk('public')->delete($school->logo);
        }

        // Delete the school
        $school->delete();

        return Redirect::route('schools.index')
            ->with('success', 'School deleted successfully!');
    }

    /**
     * Show Scool Details To School Heads.
     */
    public function mySchool(): View
    {
        $user = Auth::user();
        $school = School::with('bundles')->findOrFail($user->school_id);
        $withdraws = Withdraw::where('school_id', $school->id)->paginate(20);
        return view('schools.show', compact('school', 'withdraws'));
    }

}

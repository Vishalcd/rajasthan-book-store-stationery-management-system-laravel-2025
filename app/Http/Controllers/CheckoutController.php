<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

namespace App\Http\Controllers;

use App\Models\Bundle;
use App\Models\ExtraItem;
use App\Models\Invoice;
use App\Models\Sale;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CheckoutController extends Controller
{

    /**
     * Show Checkout page for bundle.
     */
    public function show(Bundle $bundle): View
    {
        $bundle->load(['books', 'school']);

        // bundle price
        $bundlePrice = $bundle->books->sum('selling_price');

        // Calculate revenues & discount
        $totalDiscount = $bundlePrice * ($bundle->customer_discount / 100);

        $ourRevenue = $bundlePrice - $totalDiscount;

        return view('checkout.bundle', compact('bundle', 'bundlePrice', 'totalDiscount', 'ourRevenue'));
    }

    /**
     * Confirm customer payment and create sale & invoice.
     */
    public function process(Request $request, Bundle $bundle): RedirectResponse
    {
        $validated = $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'customer_number' => 'nullable|string|max:15',
            'note' => 'nullable|string|max:500',

            'extra_items' => 'array',
            'extra_items.*.name' => 'nullable|string|max:255',
            'extra_items.*.price' => 'nullable|numeric|min:0',
            'extra_items.*.quantity' => 'nullable|integer|min:1',

            'confirm_payment' => 'required',
        ]);


        try {
            $invoice = DB::transaction(function () use ($validated, $bundle) {

                // -------------------------------------
                // 1) Calculate Bundle Price
                // -------------------------------------

                $bundlePrice = $bundle->books->sum('selling_price');

                $totalDiscount = $bundlePrice * ($bundle->customer_discount / 100);
                $updatedBundlePrice = $bundlePrice - $totalDiscount;

                // -------------------------------------
                // 2) Extra Items (with quantity)
                // -------------------------------------

                $extraItems = $validated['extra_items'] ?? [];

                $extraTotal = collect($extraItems)->sum(function ($item) {
                    $qty = isset($item['quantity']) ? intval($item['quantity']) : 1;
                    $price = floatval($item['price'] ?? 0);
                    return $qty * $price;
                });

                // Final Amount
                $finalAmount = $updatedBundlePrice + $extraTotal;

                // -------------------------------------
                // 3) Create Invoice
                // -------------------------------------

                $invoice = Invoice::create([
                    'bundle_id' => $bundle->id,
                    'invoice_number' => '',
                    'amount' => $finalAmount,
                    'customer_name' => $validated['customer_name'],
                    'customer_number' => $validated['customer_number'],
                    'note' => $validated['note'] ?? null,
                ]);

                // Generate Invoice Number
                $invoice->invoice_number = 'INV-'.str_pad($invoice->id, 6, '0', STR_PAD_LEFT);
                $invoice->save();

                // -------------------------------------
                // 4) Save Extra Items
                // -------------------------------------

                foreach ($extraItems as $item) {
                    if (! empty($item['name']) && $item['price'] >= 0) {

                        $quantity = isset($item['quantity']) ? intval($item['quantity']) : 1;
                        $totalPrice = $quantity * floatval($item['price']);

                        ExtraItem::create([
                            'invoice_id' => $invoice->id,
                            'name' => $item['name'],
                            'price' => $item['price'],
                            'quantity' => $quantity,
                            'total_price' => $totalPrice,
                        ]);
                    }
                }

                // -------------------------------------
                // 5) Sale Record
                // -------------------------------------

                Sale::create([
                    'invoice_id' => $invoice->id,
                    'bundle_id' => $bundle->id,
                    'amount' => $finalAmount,
                ]);

                // -------------------------------------
                // 6) Add School Revenue
                // -------------------------------------

                $school = School::findOrFail($bundle->school_id);

                $schoolRevenue = $updatedBundlePrice * ($bundle->school_percentage / 100);

                $school->update([
                    'total_revenue' => ($school->total_revenue ?? 0) + $schoolRevenue
                ]);

                return $invoice;
            });

            return Redirect::route('sales.index')
                ->with('success', 'Payment successful! Invoice & Sale recorded successfully.');

        } catch (Exception $e) {

            Log::error('Invoice/Sale processing failed', [
                'error' => $e->getMessage(),
                'bundle_id' => $bundle->id,
            ]);

            return back()->withErrors([
                'error' => 'Failed to complete the transaction. Please try again.'
            ]);
        }
    }


}

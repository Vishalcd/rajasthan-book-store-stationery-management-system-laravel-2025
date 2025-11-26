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
use Razorpay\Api\Api;

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
    public function process(Request $request, Bundle $bundle)
    {
        $validated = $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'customer_number' => 'nullable|string|max:15',
            'note' => 'nullable|string|max:500',

            'extra_items' => 'array',
            'extra_items.*.name' => 'nullable|string|max:255',
            'extra_items.*.price' => 'nullable|numeric|min:0',
            'extra_items.*.quantity' => 'nullable|integer|min:1',

            'payment_type' => 'required|in:cash,online',
            'confirm_payment' => 'required',
        ]);

        // ------------------------------
        // Calculate totals
        // ------------------------------
        $bundlePrice = $bundle->books->sum('selling_price');
        $totalDiscount = $bundlePrice * ($bundle->customer_discount / 100);
        $updatedBundlePrice = $bundlePrice - $totalDiscount;

        $extraItems = $validated['extra_items'] ?? [];
        $extraTotal = collect($extraItems)->sum(function ($item) {
            $qty = $item['quantity'] ?? 1;
            return $qty * floatval($item['price']);
        });

        $finalAmount = $updatedBundlePrice + $extraTotal;

        // ------------------------------
        // CASH PAYMENT
        // ------------------------------
        if ($validated['payment_type'] === 'cash') {
            try {
                $invoice = DB::transaction(function () use ($validated, $bundle, $extraItems, $finalAmount, $updatedBundlePrice) {

                    // Create Invoice
                    $invoice = Invoice::create([
                        'bundle_id' => $bundle->id,
                        'amount' => $finalAmount,
                        'customer_name' => $validated['customer_name'],
                        'customer_number' => $validated['customer_number'],
                        'note' => $validated['note'] ?? '',
                        'payment_type' => 'cash',
                    ]);

                    $invoice->invoice_number = 'INV-'.str_pad($invoice->id, 6, '0', STR_PAD_LEFT);
                    $invoice->save();

                    // Extra Items
                    foreach ($extraItems as $item) {
                        if (! empty($item['name'])) {
                            $qty = $item['quantity'] ?? 1;

                            ExtraItem::create([
                                'invoice_id' => $invoice->id,
                                'name' => $item['name'],
                                'price' => $item['price'],
                                'quantity' => $qty,
                                'total_price' => $qty * $item['price'],
                            ]);
                        }
                    }

                    // Sale
                    Sale::create([
                        'invoice_id' => $invoice->id,
                        'bundle_id' => $bundle->id,
                        'amount' => $finalAmount,
                        'payment_type' => 'cash',
                    ]);

                    // Update revenue
                    $bundle->school->increment(
                        'total_revenue',
                        $updatedBundlePrice * ($bundle->school_percentage / 100)
                    );

                    return $invoice;
                });

                return redirect()->route('sales.index')
                    ->with('success', 'Cash payment recorded successfully!');
            } catch (Exception $e) {
                Log::error('Cash Payment Failed: '.$e->getMessage());
                return back()->with('error', 'Cash payment failed. Try again.');
            }
        }

        // ------------------------------
        // ONLINE PAYMENT (Razorpay)
        // ------------------------------
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $orderData = [
            'amount' => intval($finalAmount * 100),
            'currency' => 'INR',
            'receipt' => 'bundle_'.$bundle->id.'_'.time(),
            'notes' => [
                'bundle_id' => $bundle->id,
                'customer_name' => $validated['customer_name'] ?? '',
                'customer_number' => $validated['customer_number'] ?? '',
                'amount' => $finalAmount,
                'note' => $validated['note'] ?? '',
                'extra_items' => json_encode($extraItems),
            ],
        ];

        $razorpayOrder = $api->order->create($orderData);

        return view('checkout.razorpay', [
            'bundle' => $bundle,
            'order' => $razorpayOrder,
            'amount' => $finalAmount,
            'customer_name' => $validated['customer_name'],
            'customer_number' => $validated['customer_number'],
            'note' => $validated['note'],
        ]);
    }


    public function verifyPayment(Request $request)
    {
        $payment_id = $request->razorpay_payment_id;
        $order_id = $request->razorpay_order_id;
        $signature = $request->razorpay_signature;

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        try {
            // Verify Signature
            $api->utility->verifyPaymentSignature([
                'razorpay_order_id' => $order_id,
                'razorpay_payment_id' => $payment_id,
                'razorpay_signature' => $signature
            ]);

            // Fetch Order
            $razorpayOrder = $api->order->fetch($order_id);
            $notes = $razorpayOrder['notes'] ?? [];

            // Read notes safely
            $bundle_id = $notes['bundle_id'] ?? null;
            $customer_name = $notes['customer_name'] ?? '';
            $customer_number = $notes['customer_number'] ?? '';
            $final_amount = $notes['amount'] ?? 0;
            $note = $notes['note'] ?? '';
            $extra_items = json_decode($notes['extra_items'] ?? '[]', true);

            // Load bundle
            $bundle = Bundle::with('books', 'school')->findOrFail($bundle_id);

            DB::beginTransaction();

            // Invoice
            $invoice = Invoice::create([
                'bundle_id' => $bundle->id,
                'amount' => $final_amount,
                'customer_name' => $customer_name,
                'customer_number' => $customer_number,
                'note' => $note,
                'payment_type' => 'online',
            ]);

            $invoice->invoice_number = 'INV-'.str_pad($invoice->id, 6, '0', STR_PAD_LEFT);
            $invoice->save();

            // Extra Items
            foreach ($extra_items as $item) {
                ExtraItem::create([
                    'invoice_id' => $invoice->id,
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'total_price' => $item['price'] * $item['quantity'],
                ]);
            }

            // Sale
            Sale::create([
                'invoice_id' => $invoice->id,
                'bundle_id' => $bundle->id,
                'amount' => $final_amount,
                'payment_type' => 'online',
                'payment_id' => $payment_id,
            ]);

            // Revenue
            $updatedPrice = $bundle->books->sum('selling_price')
                - ($bundle->books->sum('selling_price') * ($bundle->customer_discount / 100));

            $schoolRevenue = $updatedPrice * ($bundle->school_percentage / 100);
            $bundle->school->increment('total_revenue', $schoolRevenue);

            DB::commit();

            return redirect()->route('sales.index')
                ->with('success', 'Payment successful! Invoice created.');

        } catch (Exception $e) {

            DB::rollBack();

            Log::error("Razorpay verify error: ".$e->getMessage());

            return redirect()->route('bundles.index')
                ->with('error', 'Payment verification failed.');
        }
    }


}

<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Sale;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $sales = Sale::with(['invoice', 'bundle'])->latest()->paginate(20);
        return view('sales.index', compact('sales'));
    }

    /**
     * Show PDF of Invoice.
     */
    public function print(string $invoiceId): Response
    {
        $invoice = Invoice::with([
            'bundle.books.publisher',
            'extraItems'
        ])->findOrFail($invoiceId);

        $pdf = Pdf::loadView('sales.pdf', [
            'invoice' => $invoice,
            'bundle' => $invoice->bundle,
            'extra_items' => $invoice->extraItems,
        ])
            ->setOption('page-width', 80)
            ->setOption('disable-smart-shrinking', true)
            ->setOption('no-stop-slow-scripts', true)
            ->setOption('javascript-delay', 300)
            ->setOption('enable-local-file-access', true);


        return $pdf->stream("invoice-{$invoice->id}.pdf");
    }

}

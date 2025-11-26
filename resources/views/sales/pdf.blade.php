<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $invoice->id }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 0;
            color: #1f2937;
            font-size: 13px;
        }

        .container {
            width: 90%;
            margin: 20px auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }

        .header h1 {
            font-size: 24px;
            color: #111827;
            margin: 0;
        }

        .info {
            text-align: right;
            font-size: 12px;
            color: #6b7280;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #4f46e5;
            margin-bottom: 8px;
        }

        .details,
        .summary {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .details th,
        .details td,
        .summary th,
        .summary td {
            border: 1px solid #d1d5db;
            padding: 8px;
            text-align: left;
        }

        .details th {
            background-color: #f3f4f6;
        }

        .summary th {
            background-color: #eef2ff;
        }

        .text-right {
            text-align: right;
        }

        .total {
            font-weight: bold;
            font-size: 14px;
        }

        .footer {
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
            padding-top: 10px;
        }

        .brand {
            color: #4f46e5;
            font-weight: 600;
        }

        /* Prevent breaking tables across pages */
        table {
            page-break-inside: avoid;
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        td,
        th {
            page-break-inside: avoid;
        }
    </style>
</head>

<body>
    <div class="container" style="page-break-inside: avoid; page-break-before: auto; page-break-after: auto;">

        <!-- Header -->
        <div class="header">
            <div>
                <h1>{{ config('app.name') }}</h1>
                <p class="text-gray-500">
                    {{ config('app.description', 'Thank you for your purchase!') }}
                </p>
            </div>

            <div class="info">
                <p><strong>Invoice #:</strong> {{ $invoice->invoice_number }}</p>
                <p><strong>Date:</strong> {{ $invoice->created_at->format('d M, Y') }}</p>
                <p><strong>Status:</strong> Paid</p>
            </div>
        </div>

        <!-- Customer Info -->
        <div style="margin-bottom: 20px;">
            <p><strong>Customer Name:</strong> {{ $invoice->customer_name ?? html_entity_decode('&mdash;') }}</p>
            <p><strong>Mobile Number:</strong> {{ $invoice->customer_mobile ?? html_entity_decode('&mdash;') }}</p>
        </div>

        @php
        $bundleTotal = 0;
        $extraTotal = 0;
        @endphp

        <!-- Bundle Details -->
        <h3 class="section-title">Bundle Details</h3>

        <table class="details">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Book Title</th>
                    <th>Publisher</th>
                    <th class="text-right">MRP</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bundle->books as $index => $book)
                @php $bundleTotal += $book->selling_price; @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->publisher->name ?? 'N/A' }}</td>
                    <td class="text-right">{{ formatPrice($book->selling_price) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Extra Items -->
        @if($invoice->extraItems && count($invoice->extraItems) > 0)
        <h3 class="section-title">Extra Items</h3>

        <table class="details">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total MRP</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->extraItems as $i => $item)
                @php
                $itemTotal = $item->price * $item->quantity;
                $extraTotal += $itemTotal;
                @endphp

                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ formatPrice($item->price) }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td class="text-right">{{ formatPrice($itemTotal) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        @php
        $subTotal = $bundleTotal + $extraTotal;
        @endphp

        <!-- Summary -->
        <h3 class="section-title">Payment Summary</h3>

        <table class="summary">
            <tr>
                <th>Subtotal (Books + Extra Items)</th>
                <td class="text-right">{{ formatPrice($subTotal) }}</td>
            </tr>

            <tr>
                <th>Bundle Total</th>
                <td class="text-right">{{ formatPrice($bundleTotal) }}</td>
            </tr>

            @if($extraTotal > 0)
            <tr>
                <th>Extra Items Total</th>
                <td class="text-right">{{ formatPrice($extraTotal) }}</td>
            </tr>
            @endif

            <tr class="total">
                <th><strong>Total Payable</strong></th>
                <td class="text-right"><strong>{{ formatPrice($invoice->amount) }}</strong></td>
            </tr>
        </table>

        <div class="footer">
            <p class="brand">{{ config('app.name') }}</p>
            <p>65, Kotwali Rd, gandhi chowk, Sri Ganganagar, Rajasthan 335001</p>
        </div>

    </div>
</body>

</html>
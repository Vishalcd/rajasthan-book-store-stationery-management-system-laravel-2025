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
            width: 58mm;
            font-size: 11px;
            color: #000;
        }

        .container {
            width: 100%;
            padding: 8px 5px;
        }

        h3,
        p,
        small {
            margin: 0;
            padding: 0;
        }

        .center {
            text-align: center;
        }

        .header {
            margin-bottom: 8px;
            border-bottom: 1px dashed #000;
            padding-bottom: 6px;
        }

        .section-title {
            margin: 8px 0 3px 0;
            font-weight: bold;
            font-size: 11px;
            border-bottom: 1px dashed #000;
            padding-bottom: 2px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
            margin-top: 3px;
        }

        th,
        td {
            padding: 3px 0;
        }

        th {
            border-bottom: 1px dashed #000;
        }

        .right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        .total {
            font-weight: bold;
            font-size: 11px;
            border-top: 1px dashed #000;
            padding-top: 4px;
        }

        .footer {
            margin-top: 10px;
            border-top: 1px dashed #000;
            padding-top: 5px;
            font-size: 9px;
            text-align: center;
        }

        /* Avoid page breaks for thermal printers */
        table,
        tr,
        td,
        th {
            page-break-inside: avoid;
        }
    </style>
</head>

<body>

    <div class="container">

        <!-- Header -->
        <div class="header center">
            <h3>{{ config('app.name') }}</h3>
            <small>{{ config('app.description', 'Thank you for your purchase!') }}</small><br>
            <small>Invoice #{{ $invoice->invoice_number }}</small><br>
            <small>{{ $invoice->created_at->format('d M Y') }}</small>
        </div>

        <!-- Customer Info -->
        <p><strong>Customer:</strong> {{ $invoice->customer_name ?? '—' }}</p>
        <p><strong>Mobile:</strong> {{ $invoice->customer_mobile ?? '—' }}</p>

        @php
        $bundleTotal = 0;
        $extraTotal = 0;
        @endphp

        <!-- Bundle Items -->
        <div class="section-title">Bundle Items</div>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Book</th>
                    <th class="right">MRP</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($bundle->books as $i => $book)
                @php $bundleTotal += $book->selling_price; @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $book->title }}</td>
                    <td class="right">{{ formatPrice($book->selling_price) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Extra Items -->
        @if($invoice->extraItems && count($invoice->extraItems) > 0)
        <div class="section-title">Extra Items</div>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item</th>
                    <th class="right">Total</th>
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
                    <td>{{ $item->name }} x{{ $item->quantity }}</td>
                    <td class="right">{{ formatPrice($itemTotal) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        <!-- Summary -->
        @php
        $discountPercentage = $invoice->bundle->customer_discount ?? 0;
        $discountAmount = ($bundleTotal * $discountPercentage) / 100;

        // final total
        $finalTotal = ($bundleTotal - $discountAmount) + $extraTotal;
        @endphp

        <div class="section-title">Summary</div>

        <table>
            <tr>
                <td>Bundle Total</td>
                <td class="right">{{ formatPrice($bundleTotal) }}</td>
            </tr>

            @if($discountPercentage > 0)
            <tr>
                <td class="bold">Discount ({{ $discountPercentage }}%)</td>
                <td class="right bold">- {{ formatPrice($discountAmount) }}</td>
            </tr>
            @endif

            @if($extraTotal > 0)
            <tr>
                <td>Extra Items</td>
                <td class="right">{{ formatPrice($extraTotal) }}</td>
            </tr>
            @endif

            <tr class="total">
                <td class="bold">Total Payable</td>
                <td class="right bold">{{ formatPrice($finalTotal) }}</td>
            </tr>
        </table>

        <!-- Footer -->
        <div class="footer">
            <p>{{ config('app.name') }}</p>
            <p>65, Kotwali Rd, Gandhi Chowk, Sri Ganganagar</p>
        </div>

    </div>

</body>

</html>
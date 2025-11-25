<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Print QR Code</title>
    @vite('resources/css/app.css')

    <style>
        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .print-area {
                width: 100%;
                text-align: center;
                margin-top: 40px;
            }

            .qr-box {
                page-break-after: avoid;
            }
        }
    </style>
</head>

<body class="bg-white">

    <div class="print-area flex flex-col justify-center items-center">

        <!-- School Name -->
        <h1 class="text-2xl font-bold text-gray-900 mb-2">
            {{ $bundle->school->name }}
        </h1>

        <!-- Class Name -->
        <h2 class="text-lg font-medium text-gray-600 mb-6">
            {{ $bundle->class_name }}
        </h2>

        <!-- QR Code Box -->
        <div class="qr-box border border-gray-300 p-4 rounded-lg shadow-sm">
            <img src="{{ asset($bundle->qr_code) }}" alt="{{ $bundle->name }} QR Code" class="w-64 h-64 mx-auto">
        </div>

    </div>

    <script>
        window.onload = function () {
        window.print();
        };
        
        window.onafterprint = function () {
        window.history.back();
        };
    </script>
    </script>

</body>

</html>
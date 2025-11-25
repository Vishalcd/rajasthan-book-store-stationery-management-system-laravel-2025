<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) && $title ? $title . ' // ' . config('app.name', 'Stationary ERP') : config('app.name',
        'Stationary ERP') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased relative">
    {{-- Disaply alert message --}}
    @if (session('success'))
    <x-alert type="success" message="{{session('success')}}" />
    @else
    <x-alert type="error" message="{{session('error')}}" />
    @endif

    <div class="min-h-screen bg-gray-100 flex flex-col">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
        <header class="bg-white shadow">
            <div
                class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 sm:flex sm:items-center sm:justify-between grid gap-6">
                {{ $header }}
            </div>
        </header>
        @endisset

        <!-- Page Content -->
        <main class="px-4 md:px-0">
            {{ $slot }}
        </main>

        <footer class="bg-white border-t border-stone-200 mt-auto py-4 px-4">
            <div class="text-center text-sm text-gray-600">
                <p class="flex items-center justify-center gap-1 flex-wrap">
                    <span>&copy; {{ date('Y') }}</span>
                    <span>{{ config('app.name', 'Stationary ERP') }}</span>
                    <span>. All rights reserved.</span>
                </p>

                <p class="mt-1">
                    Developed by
                    <a href="#" target="_blank" class="text-indigo-600 underline font-medium hover:underline">
                        L2CL PVT LTD.
                    </a>
                </p>
            </div>
        </footer>
    </div>
</body>

</html>
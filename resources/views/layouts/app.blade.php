<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Dashboard - {{ config('app.name', 'WorkNest EMS') }}</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-slate-900 bg-slate-50">
        <div class="flex min-h-screen w-full">
            <!-- Sidebar -->
            @include('layouts.sidebar')

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col min-h-screen relative">
                <!-- Decorative Background Elements (Optional, to match landing theme) -->
                <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-brand-50/50 to-transparent pointer-events-none -z-10"></div>

                <!-- Header -->
                @include('layouts.header')

                <!-- Page Content -->
                <main class="flex-1 p-6 md:p-8">
                    <div class="max-w-7xl mx-auto">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>

        @stack('scripts')
    </body>
</html>

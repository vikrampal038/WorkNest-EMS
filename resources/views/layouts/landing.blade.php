<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>WorkNest EMS - The Modern Employee & Workforce Management SaaS</title>
        <meta name="description" content="Streamline your HR, payroll, attendance, and employee management with WorkNest EMS. A modern, all-in-one cloud platform designed for growing businesses and modern HR teams.">
        <meta name="keywords" content="HR software, employee management system, payroll management, attendance tracking, workforce management SaaS, HRIS, WorkNest EMS">
        <meta name="author" content="WorkNest EMS">
        <meta name="robots" content="index, follow">
        <link rel="canonical" href="{{ url('/') }}">

        <!-- Favicons -->
        <link rel="icon" type="image/png" href="{{ asset('Assets/WorkNest-EMS_Icon.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('Assets/WorkNest-EMS_Icon.png') }}">

        <!-- Open Graph / Facebook / LinkedIn -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url('/') }}">
        <meta property="og:title" content="WorkNest EMS - The Modern Employee & Workforce Management Platform">
        <meta property="og:description" content="Streamline your HR, payroll, attendance, and employee management with WorkNest EMS. A modern, all-in-one cloud platform designed for growing businesses.">
        <meta property="og:image" content="{{ asset('Assets/WorkNest-EMS_Logo.png') }}">
        <meta property="og:site_name" content="WorkNest EMS">

        <!-- Twitter -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:url" content="{{ url('/') }}">
        <meta name="twitter:title" content="WorkNest EMS - The Modern Employee & Workforce Management Platform">
        <meta name="twitter:description" content="Streamline your HR, payroll, attendance, and employee management with WorkNest EMS. A modern, all-in-one cloud platform.">
        <meta name="twitter:image" content="{{ asset('Assets/WorkNest-EMS_Logo.png') }}">

        <!-- Structured Data (JSON-LD) for SoftwareApplication -->
        <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@@type": "SoftwareApplication",
            "name": "WorkNest EMS",
            "operatingSystem": "Web",
            "applicationCategory": "BusinessApplication",
            "offers": {
                "@@type": "Offer",
                "price": "0",
                "priceCurrency": "USD"
            },
            "description": "Streamline your HR, payroll, attendance, and employee management with WorkNest EMS.",
            "url": "{{ url('/') }}",
            "publisher": {
                "@@type": "Organization",
                "name": "WorkNest",
                "logo": {
                    "@@type": "ImageObject",
                    "url": "{{ asset('Assets/WorkNest-EMS_Logo.png') }}"
                }
            }
        }
        </script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-site-bg text-slate-900 selection:bg-brand-600 selection:text-white overflow-x-hidden">
        @yield('content')
    </body>
</html>

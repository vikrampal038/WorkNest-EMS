<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'WorkNest-EMS') }} - Employee & Workforce Management SaaS</title>
        <meta name="description" content="A cloud-based employee and workforce management platform for startups and HR teams. Track attendance, manage leaves, run payroll, and view live analytics.">

        <!-- SEO Meta Tags -->
        <meta property="og:title" content="WorkNest-EMS - Employee & Workforce Management SaaS">
        <meta property="og:description" content="Modern, clean, minimal, professional SaaS platform for small businesses and HR teams.">
        <meta property="og:type" content="website">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-site-bg text-slate-900 selection:bg-brand-600 selection:text-white overflow-x-hidden">
        @yield('content')
    </body>
</html>

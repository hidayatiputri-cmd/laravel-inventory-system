<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'GoShopping') }} - Smart Retail & Online Store</title>

        <!-- Favicon SVG Tas Belanja Ceria -->
        <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23f43f5e' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><path d='M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z'/><line x1='3' y1='6' x2='21' y2='6'/><path d='M16 10a4 4 0 0 1-8 0'/></svg>">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 min-h-screen relative overflow-x-hidden selection:bg-rose-500 selection:text-white">
        <!-- Background Glow Accent Orbs -->
        <div class="fixed top-0 -left-20 w-96 h-96 bg-rose-500/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="fixed bottom-0 -right-20 w-96 h-96 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="min-h-screen flex flex-col justify-center items-center p-6 relative z-10">
            <!-- Brand Header -->
            <div class="mb-6 transform hover:scale-105 transition-transform duration-200">
                <a href="/" class="flex flex-col items-center group">
                    <x-application-logo />
                </a>
            </div>

            <!-- Card Box with Glassmorphism -->
            <div class="w-full sm:max-w-md p-8 bg-white/95 backdrop-blur-xl shadow-2xl rounded-3xl border border-white/20">
                {{ $slot }}
            </div>

            <!-- Footer Badge -->
            <div class="mt-8 text-center text-xs text-gray-400">
                &copy; {{ date('Y') }} <span class="font-bold text-gray-300">GoShopping</span> &bull; Platform Retail & Inventaris Cerdas
            </div>
        </div>
    </body>
</html>

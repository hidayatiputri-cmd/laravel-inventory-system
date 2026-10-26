<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>GoShopping - Smart Retail & Online Store</title>

        <!-- Favicon SVG Tas Belanja Ceria -->
        <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23f43f5e' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><path d='M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z'/><line x1='3' y1='6' x2='21' y2='6'/><path d='M16 10a4 4 0 0 1-8 0'/></svg>">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-900 text-white min-h-screen relative overflow-x-hidden selection:bg-rose-500 selection:text-white">
        <!-- Background Lighting Orbs -->
        <div class="fixed top-0 -left-20 w-[500px] h-[500px] bg-rose-500/15 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="fixed bottom-0 -right-20 w-[500px] h-[500px] bg-indigo-500/20 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="fixed top-1/2 left-1/3 -translate-y-1/2 w-[400px] h-[400px] bg-amber-500/10 rounded-full blur-[100px] pointer-events-none"></div>

        <!-- Navbar -->
        <nav class="relative z-20 border-b border-white/10 bg-slate-900/60 backdrop-blur-xl">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
                <a href="/" class="flex items-center group">
                    <x-application-logo />
                </a>

                <div class="flex items-center gap-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 rounded-xl text-xs font-black bg-gradient-to-r from-rose-500 to-indigo-600 hover:from-rose-600 hover:to-indigo-700 text-white shadow-lg shadow-rose-500/25 transition">
                                Buka Dashboard &rarr;
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-300 hover:text-white transition">
                                Masuk (Log in)
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-xl text-xs font-black bg-gradient-to-r from-rose-500 to-indigo-600 hover:from-rose-600 hover:to-indigo-700 text-white shadow-lg shadow-rose-500/25 transition">
                                    Daftar Akun
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <main class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-24 text-center flex flex-col items-center">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/10 text-xs font-bold text-amber-300 mb-8 animate-bounce">
                <span>🛍️</span> Next-Gen Smart Retail & Inventory Platform
            </div>

            <h1 class="text-4xl sm:text-6xl font-black tracking-tight max-w-4xl leading-tight">
                Kelola Inventaris & Belanja Online Lebih Cepat Bersama 
                <span class="bg-gradient-to-r from-rose-500 via-pink-500 to-amber-400 bg-clip-text text-transparent">GoShopping</span>
            </h1>

            <p class="mt-6 text-base sm:text-lg text-slate-400 max-w-2xl leading-relaxed">
                Platform retail cerdas multi-peran dengan transaksi atomik terproteksi, pemantauan stok real-time, dan tampilan antarmuka yang dirancang khusus untuk Admin, Staff, dan Customer.
            </p>

            <!-- CTA Buttons -->
            <div class="mt-10 flex flex-wrap gap-4 justify-center">
                <a href="{{ route('login') }}" class="px-8 py-3.5 rounded-2xl bg-gradient-to-r from-rose-500 via-pink-600 to-indigo-600 hover:from-rose-600 hover:to-indigo-700 font-extrabold text-sm text-white shadow-xl shadow-rose-500/30 transform hover:-translate-y-0.5 transition-all">
                    Mulai Belanja & Kelola Toko &rarr;
                </a>
            </div>

            <!-- Role Showcase Cards -->
            <div class="mt-20 grid grid-cols-1 md:grid-cols-3 gap-6 w-full text-left">
                <!-- Admin Card -->
                <div class="p-8 rounded-3xl bg-white/5 border border-white/10 backdrop-blur-md hover:border-violet-500/50 transition">
                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-violet-500/20 text-violet-400 border border-violet-500/30">
                        Admin (Blue/Violet)
                    </span>
                    <h3 class="text-xl font-bold mt-4">Eksekutif & Analitik</h3>
                    <p class="text-xs text-slate-400 mt-2 leading-relaxed">
                        Statistik finansial omzet penjualan, pengeluaran PO supplier, alert stok menipis, dan kontrol penuh seluruh master data.
                    </p>
                </div>

                <!-- Staff Card -->
                <div class="p-8 rounded-3xl bg-white/5 border border-white/10 backdrop-blur-md hover:border-emerald-500/50 transition">
                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                        Staff (Emerald/Teal)
                    </span>
                    <h3 class="text-xl font-bold mt-4">Kasir & Gudang</h3>
                    <p class="text-xs text-slate-400 mt-2 leading-relaxed">
                        Pencatatan kasir instan, input barang masuk supplier, pemantauan stok fisik dengan indikator warna status otomatis.
                    </p>
                </div>

                <!-- Customer Card -->
                <div class="p-8 rounded-3xl bg-white/5 border border-white/10 backdrop-blur-md hover:border-rose-500/50 transition">
                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-rose-500/20 text-rose-400 border border-rose-500/30">
                        Customer (Amber/Rose)
                    </span>
                    <h3 class="text-xl font-bold mt-4">E-Commerce Storefront</h3>
                    <p class="text-xs text-slate-400 mt-2 leading-relaxed">
                        Etalase toko modern, penjelajahan katalog produk, harga transparan rupiah, dan histori faktur belanja pribadi.
                    </p>
                </div>
            </div>
        </main>
    </body>
</html>

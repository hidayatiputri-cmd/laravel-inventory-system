<x-app-layout>
    <x-slot name="header">
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-600 via-indigo-700 to-blue-700 p-6 sm:p-7 text-white shadow-lg shadow-indigo-500/20">
            <div class="relative z-10 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-0.5 text-[10px] font-black uppercase rounded-full bg-white/20 backdrop-blur-md text-white tracking-wider border border-white/20">
                            Admin Control Center
                        </span>
                        <span class="text-xs text-indigo-200">&bull;</span>
                        <span class="text-xs text-indigo-100 font-medium">{{ now()->format('l, d F Y') }}</span>
                    </div>
                    <h2 class="font-black text-2xl sm:text-3xl text-white leading-tight mt-1 tracking-tight">
                        Ringkasan Eksekutif GoShopping
                    </h2>
                    <p class="text-xs sm:text-sm text-indigo-100 mt-1 max-w-xl">
                        Selamat datang kembali, <strong>{{ $user->name }}</strong>. Pantau metrik finansial, perputaran stok barang, dan kontrol master data toko.
                    </p>
                </div>
                <div class="flex flex-wrap gap-2.5 shrink-0">
                    <a href="{{ route('sales.create') }}" class="inline-flex items-center px-4 py-2.5 bg-white text-indigo-700 hover:bg-indigo-50 active:scale-95 rounded-xl text-xs font-bold shadow-md transition-all">
                        <svg class="w-4 h-4 me-1.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Transaksi Kasir
                    </a>
                    <a href="{{ route('purchases.create') }}" class="inline-flex items-center px-4 py-2.5 bg-indigo-900/60 hover:bg-indigo-900 text-white border border-white/20 active:scale-95 rounded-xl text-xs font-bold shadow-md transition-all">
                        <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Restock PO
                    </a>
                </div>
            </div>
            <!-- Glow background orb -->
            <div class="absolute -right-6 -bottom-6 w-48 h-48 bg-white/10 rounded-full blur-2xl"></div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <x-alert />

            <!-- 1. KPI Financial & Master Statistics (Tema Blue / Violet / Indigo) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <!-- Total Omzet Penjualan (Violet Vibrant Gradient) -->
                <div class="relative overflow-hidden bg-gradient-to-br from-violet-600 via-indigo-600 to-purple-800 rounded-3xl p-6 text-white shadow-xl shadow-indigo-600/15 group hover:-translate-y-1 transition-all duration-300">
                    <div class="absolute -right-4 -bottom-4 w-28 h-28 bg-white/10 rounded-full blur-xl group-hover:scale-125 transition-transform"></div>
                    <div class="flex justify-between items-center text-xs font-bold uppercase tracking-wider text-violet-200">
                        <span>Total Omzet Penjualan</span>
                        <span class="p-2 bg-white/10 backdrop-blur-md rounded-xl">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>
                    </div>
                    <div class="text-2xl font-black mt-3 font-mono tracking-tight">
                        Rp {{ number_format($totalSalesRevenue, 0, ',', '.') }}
                    </div>
                    <div class="mt-3 pt-3 border-t border-white/15 text-xs flex items-center justify-between text-violet-100">
                        <span>{{ $totalSalesCount }} transaksi terekam</span>
                        <a href="{{ route('sales.index') }}" class="font-bold underline hover:text-white">Lihat &rarr;</a>
                    </div>
                </div>

                <!-- Total Modal Pengadaan Stok (Blue Gradient) -->
                <div class="relative overflow-hidden bg-gradient-to-br from-blue-600 via-cyan-600 to-indigo-800 rounded-3xl p-6 text-white shadow-xl shadow-blue-600/15 group hover:-translate-y-1 transition-all duration-300">
                    <div class="absolute -right-4 -bottom-4 w-28 h-28 bg-white/10 rounded-full blur-xl group-hover:scale-125 transition-transform"></div>
                    <div class="flex justify-between items-center text-xs font-bold uppercase tracking-wider text-blue-200">
                        <span>Total Belanja Modal (PO)</span>
                        <span class="p-2 bg-white/10 backdrop-blur-md rounded-xl">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </span>
                    </div>
                    <div class="text-2xl font-black mt-3 font-mono tracking-tight">
                        Rp {{ number_format($totalPurchasesAmount, 0, ',', '.') }}
                    </div>
                    <div class="mt-3 pt-3 border-t border-white/15 text-xs flex items-center justify-between text-blue-100">
                        <span>{{ $totalPurchasesCount }} transaksi PO</span>
                        <a href="{{ route('purchases.index') }}" class="font-bold underline hover:text-white">Lihat &rarr;</a>
                    </div>
                </div>

                <!-- Total Pelanggan & Pengguna (Fuchsia / Violet Gradient) -->
                <div class="relative overflow-hidden bg-white rounded-3xl p-6 border border-slate-100 shadow-sm group hover:-translate-y-1 transition-all duration-300">
                    <div class="flex justify-between items-center text-xs font-bold uppercase tracking-wider text-slate-400">
                        <span>Total Akun Pengguna</span>
                        <span class="p-2.5 bg-violet-50 text-violet-600 rounded-2xl">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </span>
                    </div>
                    <div class="text-3xl font-black mt-2 text-slate-800 font-mono">
                        {{ $totalCustomers }} <span class="text-xs font-normal text-slate-400">Customer</span>
                    </div>
                    <div class="mt-3 text-xs text-slate-500 flex items-center justify-between">
                        <span>{{ $totalSuppliers }} Mitra Supplier Aktif</span>
                        <a href="{{ route('suppliers.index') }}" class="text-violet-600 font-bold hover:underline">Kelola &rarr;</a>
                    </div>
                </div>

                <!-- Alert Stok Rendah (Vibrant Warning Badge) -->
                <div class="relative overflow-hidden bg-white rounded-3xl p-6 border {{ $lowStockCount > 0 ? 'border-rose-300 ring-4 ring-rose-100 bg-rose-50/20' : 'border-slate-100' }} shadow-sm group hover:-translate-y-1 transition-all duration-300">
                    <div class="flex justify-between items-center text-xs font-bold uppercase tracking-wider {{ $lowStockCount > 0 ? 'text-rose-600' : 'text-slate-400' }}">
                        <span>Stok Rendah (Alert)</span>
                        <span class="p-2.5 {{ $lowStockCount > 0 ? 'bg-rose-100 text-rose-600' : 'bg-slate-100 text-slate-500' }} rounded-2xl">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </span>
                    </div>
                    <div class="text-3xl font-black mt-2 font-mono {{ $lowStockCount > 0 ? 'text-rose-600' : 'text-slate-800' }}">
                        {{ $lowStockCount }} <span class="text-xs font-semibold {{ $lowStockCount > 0 ? 'text-rose-500' : 'text-slate-400' }}">item kritis</span>
                    </div>
                    <div class="mt-3 text-xs flex items-center justify-between">
                        <span class="text-slate-400">Batas minimum stok</span>
                        @if ($lowStockCount > 0)
                            <a href="{{ route('purchases.create') }}" class="font-bold text-rose-600 underline">Restock &rarr;</a>
                        @else
                            <span class="text-emerald-600 font-bold">Stok Aman &check;</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- 2. Master Data Quick Management Grid (Admin Exclusive) -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 sm:p-8">
                <div class="flex items-center justify-between mb-5 border-b border-slate-100 pb-4">
                    <div>
                        <h3 class="text-base font-black text-slate-900">Kelola Master Data & Entitas Toko</h3>
                        <p class="text-xs text-slate-500">Akses penuh manipulasi produk, kategori, pemasok, transaksi, dan akun</p>
                    </div>
                    <span class="text-xs font-mono font-bold bg-violet-100 text-violet-700 px-3 py-1 rounded-full">
                        Admin Privileges
                    </span>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                    <a href="{{ route('products.index') }}" class="p-5 rounded-2xl border border-slate-100 hover:border-violet-300 hover:bg-violet-50/40 transition group flex flex-col justify-between">
                        <div>
                            <span class="text-[11px] uppercase font-bold text-slate-400">Total Produk</span>
                            <span class="block text-2xl font-black text-slate-900 mt-1 font-mono">{{ $totalProducts }}</span>
                        </div>
                        <span class="text-xs text-violet-600 font-bold group-hover:underline mt-4 flex items-center">
                            Kelola Produk &rarr;
                        </span>
                    </a>

                    <a href="{{ route('categories.index') }}" class="p-5 rounded-2xl border border-slate-100 hover:border-blue-300 hover:bg-blue-50/40 transition group flex flex-col justify-between">
                        <div>
                            <span class="text-[11px] uppercase font-bold text-slate-400">Kategori Barang</span>
                            <span class="block text-2xl font-black text-slate-900 mt-1 font-mono">{{ $totalCategories }}</span>
                        </div>
                        <span class="text-xs text-blue-600 font-bold group-hover:underline mt-4 flex items-center">
                            Kelola Kategori &rarr;
                        </span>
                    </a>

                    <a href="{{ route('suppliers.index') }}" class="p-5 rounded-2xl border border-slate-100 hover:border-cyan-300 hover:bg-cyan-50/40 transition group flex flex-col justify-between">
                        <div>
                            <span class="text-[11px] uppercase font-bold text-slate-400">Mitra Supplier</span>
                            <span class="block text-2xl font-black text-slate-900 mt-1 font-mono">{{ $totalSuppliers }}</span>
                        </div>
                        <span class="text-xs text-cyan-700 font-bold group-hover:underline mt-4 flex items-center">
                            Kelola Supplier &rarr;
                        </span>
                    </a>

                    <a href="{{ route('purchases.index') }}" class="p-5 rounded-2xl border border-slate-100 hover:border-indigo-300 hover:bg-indigo-50/40 transition group flex flex-col justify-between">
                        <div>
                            <span class="text-[11px] uppercase font-bold text-slate-400">Restock / Purchase</span>
                            <span class="block text-2xl font-black text-slate-900 mt-1 font-mono">{{ $totalPurchasesCount }}</span>
                        </div>
                        <span class="text-xs text-indigo-600 font-bold group-hover:underline mt-4 flex items-center">
                            Riwayat Pembelian &rarr;
                        </span>
                    </a>

                    <a href="{{ route('sales.index') }}" class="p-5 rounded-2xl border border-slate-100 hover:border-purple-300 hover:bg-purple-50/40 transition group flex flex-col justify-between">
                        <div>
                            <span class="text-[11px] uppercase font-bold text-slate-400">Kasir / Sales</span>
                            <span class="block text-2xl font-black text-purple-700 mt-1 font-mono">{{ $totalSalesCount }}</span>
                        </div>
                        <span class="text-xs text-purple-700 font-bold group-hover:underline mt-4 flex items-center">
                            Riwayat Penjualan &rarr;
                        </span>
                    </a>
                </div>
            </div>

            <!-- 3. Alert Stok Rendah Table -->
            @if ($lowStockCount > 0)
                <div class="bg-white rounded-3xl shadow-sm border border-rose-200 overflow-hidden">
                    <div class="p-5 border-b border-rose-100 bg-rose-50/60 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                        <div class="flex items-center gap-3">
                            <span class="w-3 h-3 rounded-full bg-rose-500 animate-ping"></span>
                            <div>
                                <h3 class="text-sm font-bold text-rose-900">Perhatian: {{ $lowStockCount }} Produk Membutuhkan Restock Cepat</h3>
                                <p class="text-xs text-rose-600">Stok berada di bawah atau sama dengan batas minimum persediaan</p>
                            </div>
                        </div>
                        <a href="{{ route('purchases.create') }}" class="text-xs font-bold bg-rose-600 hover:bg-rose-700 text-white px-3.5 py-2 rounded-xl transition shadow-sm">
                            + Buat Order Pembelian (PO)
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50 text-gray-600 text-xs uppercase font-semibold">
                                <tr>
                                    <th class="px-6 py-3 text-left">SKU</th>
                                    <th class="px-6 py-3 text-left">Nama Produk</th>
                                    <th class="px-6 py-3 text-left">Kategori</th>
                                    <th class="px-6 py-3 text-center">Stok</th>
                                    <th class="px-6 py-3 text-center">Batas Min</th>
                                    <th class="px-6 py-3 text-right">Harga Modal</th>
                                    <th class="px-6 py-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($lowStockProducts as $lowProd)
                                    <tr class="hover:bg-rose-50/20 transition">
                                        <td class="px-6 py-3 font-mono text-xs font-bold text-gray-700">
                                            <span class="bg-slate-100 px-2 py-0.5 rounded">{{ $lowProd->sku }}</span>
                                        </td>
                                        <td class="px-6 py-3 font-bold text-gray-900">{{ $lowProd->name }}</td>
                                        <td class="px-6 py-3 text-xs text-gray-500">{{ $lowProd->category->name ?? '-' }}</td>
                                        <td class="px-6 py-3 text-center">
                                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-100 text-rose-700 animate-pulse">
                                                {{ $lowProd->stock }} unit
                                            </span>
                                        </td>
                                        <td class="px-6 py-3 text-center text-xs text-gray-500 font-bold">{{ $lowProd->minimum_stock }} unit</td>
                                        <td class="px-6 py-3 text-right font-mono text-xs text-gray-700">Rp {{ number_format($lowProd->purchase_price, 0, ',', '.') }}</td>
                                        <td class="px-6 py-3 text-right">
                                            <a href="{{ route('products.edit', $lowProd) }}" class="text-xs text-violet-600 hover:text-violet-800 font-bold">Edit &rarr;</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <!-- 3.5. Analitik & Grafik Visual Penjualan Toko (Sales Analytics Bar Chart) -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 sm:p-8">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6">
                    <div>
                        <h3 class="text-base font-black text-slate-900">Grafik & Analitik Performa Penjualan</h3>
                        <p class="text-xs text-slate-500">Visualisasi omzet pendapatan vs beban modal belanja produk</p>
                    </div>
                    <div class="flex items-center gap-3 text-xs font-bold">
                        <span class="flex items-center gap-1.5 text-slate-600">
                            <span class="w-3 h-3 rounded-full bg-violet-600"></span> Omzet Penjualan
                        </span>
                        <span class="flex items-center gap-1.5 text-slate-600">
                            <span class="w-3 h-3 rounded-full bg-blue-500"></span> Modal PO Inbound
                        </span>
                    </div>
                </div>

                @php
                    $maxVal = max($totalSalesRevenue, $totalPurchasesAmount, 1);
                    $salesPct = min(100, round(($totalSalesRevenue / $maxVal) * 100));
                    $purchasePct = min(100, round(($totalPurchasesAmount / $maxVal) * 100));
                @endphp

                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-xs font-bold mb-1">
                            <span class="text-slate-700">Total Omzet Penjualan (Revenue)</span>
                            <span class="font-mono text-violet-700">Rp {{ number_format($totalSalesRevenue, 0, ',', '.') }} ({{ $salesPct }}%)</span>
                        </div>
                        <div class="w-full h-4 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-violet-600 to-indigo-600 rounded-full transition-all duration-700" style="width: {{ $salesPct }}%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-xs font-bold mb-1">
                            <span class="text-slate-700">Total Pengeluaran Restock (Modal PO)</span>
                            <span class="font-mono text-blue-700">Rp {{ number_format($totalPurchasesAmount, 0, ',', '.') }} ({{ $purchasePct }}%)</span>
                        </div>
                        <div class="w-full h-4 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-blue-500 to-cyan-500 rounded-full transition-all duration-700" style="width: {{ $purchasePct }}%"></div>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-500">Estimasi Laba Kotor:</span>
                        <span class="font-mono font-black text-sm {{ $grossProfit >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                            Rp {{ number_format($grossProfit, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- 4. Section: Pencarian Cepat Produk SKU (Pagination) -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-slate-50/60">
                    <div>
                        <h3 class="text-base font-black text-slate-900">Katalog Produk & Visual SKU</h3>
                        <p class="text-xs text-slate-500">Cari informasi ketersediaan barang, modal, dan harga jual</p>
                    </div>
                    <form method="GET" action="{{ route('dashboard') }}" class="w-full md:w-auto flex gap-2">
                        @if ($startDate)<input type="hidden" name="start_date" value="{{ $startDate }}">@endif
                        @if ($endDate)<input type="hidden" name="end_date" value="{{ $endDate }}">@endif
                        @if ($trxSearch)<input type="hidden" name="trx_search" value="{{ $trxSearch }}">@endif

                        <div class="relative w-full md:w-72">
                            <span class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </span>
                            <input type="text" name="product_search" value="{{ $productSearch }}" placeholder="Ketik SKU atau Nama Produk..." class="w-full ps-9 pe-3 py-2 text-xs rounded-xl border-slate-200 focus:border-violet-500 focus:ring-violet-500">
                        </div>
                        <button type="submit" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold rounded-xl transition">
                            Cari
                        </button>
                        @if ($productSearch)
                            <a href="{{ route('dashboard') }}" class="px-3 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-bold rounded-xl transition">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-gray-600 text-xs uppercase font-semibold">
                            <tr>
                                <th class="px-6 py-3.5 text-left">SKU</th>
                                <th class="px-6 py-3.5 text-left">Nama Produk</th>
                                <th class="px-6 py-3.5 text-left">Kategori</th>
                                <th class="px-6 py-3.5 text-right">Harga Beli</th>
                                <th class="px-6 py-3.5 text-right">Harga Jual</th>
                                <th class="px-6 py-3.5 text-center">Stok</th>
                                <th class="px-6 py-3.5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($products as $p)
                                <tr class="hover:bg-violet-50/30 transition">
                                    <td class="px-6 py-3.5 font-mono text-xs font-bold text-slate-700">
                                        <span class="bg-slate-100 px-2 py-0.5 rounded">{{ $p->sku }}</span>
                                    </td>
                                    <td class="px-6 py-3.5">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-10 h-10 rounded-xl overflow-hidden border border-slate-200 bg-slate-50 shrink-0 shadow-xs">
                                                <img src="{{ $p->image_url }}" alt="{{ $p->name }}" class="w-full h-full object-cover">
                                            </div>
                                            <div>
                                                <div class="font-bold text-slate-900 leading-tight">{{ $p->name }}</div>
                                                <div class="text-[11px] text-slate-400 font-mono">Min: {{ $p->minimum_stock }} unit</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3.5 text-xs text-slate-500">{{ $p->category->name ?? '-' }}</td>
                                    <td class="px-6 py-3.5 text-right font-mono text-xs text-slate-500">Rp {{ number_format($p->purchase_price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-3.5 text-right font-mono text-xs font-bold text-violet-700">Rp {{ number_format($p->selling_price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-3.5 text-center">
                                        @if ($p->stock <= $p->minimum_stock)
                                            <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-rose-100 text-rose-700">{{ $p->stock }} (Low)</span>
                                        @else
                                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700">{{ $p->stock }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-3.5 text-right whitespace-nowrap">
                                        <a href="{{ route('products.show', $p) }}" class="text-xs text-violet-600 hover:text-violet-800 font-bold">Detail &rarr;</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-slate-400 text-sm">Tidak ada produk ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($products->hasPages())
                    <div class="p-3 border-t border-slate-100 bg-slate-50">
                        {{ $products->appends(['product_search' => $productSearch, 'start_date' => $startDate, 'end_date' => $endDate, 'trx_search' => $trxSearch])->links() }}
                    </div>
                @endif
            </div>

            <!-- 5. Section: Tabel Transaksi Penjualan Lengkap dengan Filter Tanggal (Pagination) -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100 bg-slate-50/60">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-4">
                        <div>
                            <h3 class="text-base font-black text-slate-900">Audit & Log Transaksi Penjualan</h3>
                            <p class="text-xs text-slate-500">Filter transaksi berdasarkan rentang tanggal dan pencarian nomor faktur</p>
                        </div>
                        <a href="{{ route('sales.index') }}" class="text-xs text-violet-600 hover:text-violet-800 font-bold">
                            Lihat Modul Penjualan Penuh &rarr;
                        </a>
                    </div>

                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('dashboard') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
                        @if ($productSearch)<input type="hidden" name="product_search" value="{{ $productSearch }}">@endif

                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1">Dari Tanggal</label>
                            <input type="date" name="start_date" value="{{ $startDate }}" class="w-full text-xs rounded-xl border-slate-200 focus:border-violet-500 focus:ring-violet-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1">Sampai Tanggal</label>
                            <input type="date" name="end_date" value="{{ $endDate }}" class="w-full text-xs rounded-xl border-slate-200 focus:border-violet-500 focus:ring-violet-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1">Cari Invoice / Pelanggan</label>
                            <input type="text" name="trx_search" value="{{ $trxSearch }}" placeholder="No. Invoice atau Nama..." class="w-full text-xs rounded-xl border-slate-200 focus:border-violet-500 focus:ring-violet-500">
                        </div>

                        <div class="flex items-end gap-2">
                            <button type="submit" class="w-full py-2 bg-gradient-to-r from-violet-600 to-indigo-600 hover:from-violet-700 hover:to-indigo-700 text-white text-xs font-bold rounded-xl shadow-sm transition">
                                Terapkan Filter
                            </button>
                            @if ($startDate || $endDate || $trxSearch)
                                <a href="{{ route('dashboard') }}" class="px-3 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-bold rounded-xl transition" title="Reset Filter">
                                    Reset
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-gray-600 text-xs uppercase font-semibold">
                            <tr>
                                <th class="px-6 py-3.5 text-left">No. Invoice</th>
                                <th class="px-6 py-3.5 text-left">Tanggal</th>
                                <th class="px-6 py-3.5 text-left">Pelanggan</th>
                                <th class="px-6 py-3.5 text-center">Metode</th>
                                <th class="px-6 py-3.5 text-right">Total Tagihan</th>
                                <th class="px-6 py-3.5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($salesTransactions as $sale)
                                <tr class="hover:bg-violet-50/20 transition">
                                    <td class="px-6 py-3.5 font-mono text-xs font-bold text-slate-900">{{ $sale->invoice_number }}</td>
                                    <td class="px-6 py-3.5 text-slate-600 text-xs">{{ $sale->sale_date->format('d M Y') }}</td>
                                    <td class="px-6 py-3.5 text-slate-800 font-semibold">{{ $sale->user->name ?? 'Pelanggan Umum' }}</td>
                                    <td class="px-6 py-3.5 text-center">
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase {{ $sale->payment_method == 'cash' ? 'bg-emerald-50 text-emerald-700' : 'bg-blue-50 text-blue-700' }}">
                                            {{ $sale->payment_method }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3.5 text-right font-mono font-bold text-slate-900">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</td>
                                    <td class="px-6 py-3.5 text-center whitespace-nowrap">
                                        <a href="{{ route('sales.show', $sale) }}" class="inline-flex items-center px-3 py-1 bg-violet-50 hover:bg-violet-100 text-violet-700 rounded-lg text-xs font-bold transition">
                                            Lihat Struk
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-10 text-center text-slate-400">Tidak ada transaksi penjualan dalam periode ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($salesTransactions->hasPages())
                    <div class="p-3 border-t border-slate-100 bg-slate-50">
                        {{ $salesTransactions->appends(['start_date' => $startDate, 'end_date' => $endDate, 'trx_search' => $trxSearch, 'product_search' => $productSearch])->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

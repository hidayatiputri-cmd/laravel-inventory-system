<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-1 text-xs font-bold uppercase rounded-md bg-purple-100 text-purple-700 tracking-wider">
                        Super Admin Panel
                    </span>
                    <span class="text-xs text-gray-400">|</span>
                    <span class="text-xs text-gray-500">{{ now()->format('l, d F Y') }}</span>
                </div>
                <h2 class="font-extrabold text-2xl text-gray-900 leading-tight mt-1">
                    Executive Dashboard
                </h2>
                <p class="text-sm text-gray-500">Selamat datang kembali, <strong class="text-gray-800">{{ $user->name }}</strong>. Berikut rangkuman performa bisnis & inventaris toko.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('sales.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-semibold shadow-sm transition">
                    <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Transaksi Kasir
                </a>
                <a href="{{ route('purchases.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-semibold shadow-sm transition">
                    <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Restock Pembelian
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <x-alert />

            <!-- 1. KPI Financial & Master Statistics -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <!-- Total Pendapatan Penjualan -->
                <div class="bg-gradient-to-br from-emerald-500 to-teal-700 rounded-2xl p-6 text-white shadow-md">
                    <div class="flex justify-between items-center opacity-80 text-xs font-semibold uppercase tracking-wider">
                        <span>Total Pendapatan (Sales)</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="text-2xl font-extrabold mt-3 font-mono">
                        Rp {{ number_format($totalSalesRevenue, 0, ',', '.') }}
                    </div>
                    <div class="mt-2 text-xs opacity-90 flex items-center justify-between">
                        <span>{{ $totalSalesCount }} transaksi selesai</span>
                        <a href="{{ route('sales.index') }}" class="underline font-medium hover:text-emerald-100">Rincian &rarr;</a>
                    </div>
                </div>

                <!-- Total Belanja Stok (Purchases) -->
                <div class="bg-gradient-to-br from-indigo-600 to-blue-700 rounded-2xl p-6 text-white shadow-md">
                    <div class="flex justify-between items-center opacity-80 text-xs font-semibold uppercase tracking-wider">
                        <span>Total Modal Masuk (Inbound)</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    <div class="text-2xl font-extrabold mt-3 font-mono">
                        Rp {{ number_format($totalPurchasesAmount, 0, ',', '.') }}
                    </div>
                    <div class="mt-2 text-xs opacity-90 flex items-center justify-between">
                        <span>{{ $totalPurchasesCount }} transaksi PO</span>
                        <a href="{{ route('purchases.index') }}" class="underline font-medium hover:text-indigo-100">Rincian &rarr;</a>
                    </div>
                </div>

                <!-- Selisih Arus Kas / Estimasi Margin -->
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                    <div class="flex justify-between items-center text-xs font-bold uppercase tracking-wider text-gray-400">
                        <span>Selisih Arus Kas (Net)</span>
                        <span class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </span>
                    </div>
                    <div class="text-2xl font-extrabold mt-3 font-mono {{ $grossProfit >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                        Rp {{ number_format($grossProfit, 0, ',', '.') }}
                    </div>
                    <p class="text-xs text-gray-400 mt-2">Sales Revenue - Purchase Inbound</p>
                </div>

                <!-- Alert Stok Rendah -->
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm {{ $lowStockCount > 0 ? 'border-rose-300 ring-2 ring-rose-100' : '' }}">
                    <div class="flex justify-between items-center text-xs font-bold uppercase tracking-wider text-rose-500">
                        <span>Stok Rendah (Alert)</span>
                        <span class="w-8 h-8 rounded-lg bg-rose-50 flex items-center justify-center text-rose-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </span>
                    </div>
                    <div class="text-3xl font-extrabold mt-2 text-rose-600">
                        {{ $lowStockCount }}
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Produk berada di batas minimum</p>
                </div>
            </div>

            <!-- 2. Master Data Quick Management Grid (Admin Exclusive) -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8">
                <div class="flex items-center justify-between mb-5 border-b pb-3">
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Kelola Master Data & Entitas Toko</h3>
                        <p class="text-xs text-gray-500">Akses cepat manajemen produk, kategori, pemasok, transaksi, dan akun</p>
                    </div>
                    <span class="text-xs font-mono font-semibold bg-gray-100 text-gray-600 px-2.5 py-1 rounded">Admin Privileges</span>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                    <a href="{{ route('products.index') }}" class="p-4 rounded-xl border border-gray-100 hover:border-indigo-400 hover:bg-indigo-50/30 transition group flex flex-col justify-between">
                        <div>
                            <span class="text-xs uppercase font-bold text-gray-400">Katalog Produk</span>
                            <span class="block text-2xl font-extrabold text-gray-900 mt-1">{{ $totalProducts }}</span>
                        </div>
                        <span class="text-xs text-indigo-600 font-semibold group-hover:underline mt-3 flex items-center">
                            Kelola Produk &rarr;
                        </span>
                    </a>

                    <a href="{{ route('categories.index') }}" class="p-4 rounded-xl border border-gray-100 hover:border-indigo-400 hover:bg-indigo-50/30 transition group flex flex-col justify-between">
                        <div>
                            <span class="text-xs uppercase font-bold text-gray-400">Kategori Barang</span>
                            <span class="block text-2xl font-extrabold text-gray-900 mt-1">{{ $totalCategories }}</span>
                        </div>
                        <span class="text-xs text-indigo-600 font-semibold group-hover:underline mt-3 flex items-center">
                            Kelola Kategori &rarr;
                        </span>
                    </a>

                    <a href="{{ route('suppliers.index') }}" class="p-4 rounded-xl border border-gray-100 hover:border-indigo-400 hover:bg-indigo-50/30 transition group flex flex-col justify-between">
                        <div>
                            <span class="text-xs uppercase font-bold text-gray-400">Mitra Supplier</span>
                            <span class="block text-2xl font-extrabold text-gray-900 mt-1">{{ $totalSuppliers }}</span>
                        </div>
                        <span class="text-xs text-indigo-600 font-semibold group-hover:underline mt-3 flex items-center">
                            Kelola Supplier &rarr;
                        </span>
                    </a>

                    <a href="{{ route('purchases.index') }}" class="p-4 rounded-xl border border-gray-100 hover:border-indigo-400 hover:bg-indigo-50/30 transition group flex flex-col justify-between">
                        <div>
                            <span class="text-xs uppercase font-bold text-gray-400">Restock / Purchase</span>
                            <span class="block text-2xl font-extrabold text-gray-900 mt-1">{{ $totalPurchasesCount }}</span>
                        </div>
                        <span class="text-xs text-indigo-600 font-semibold group-hover:underline mt-3 flex items-center">
                            Riwayat Pembelian &rarr;
                        </span>
                    </a>

                    <a href="{{ route('sales.index') }}" class="p-4 rounded-xl border border-gray-100 hover:border-emerald-400 hover:bg-emerald-50/30 transition group flex flex-col justify-between">
                        <div>
                            <span class="text-xs uppercase font-bold text-gray-400">Kasir / Sales</span>
                            <span class="block text-2xl font-extrabold text-emerald-600 mt-1">{{ $totalSalesCount }}</span>
                        </div>
                        <span class="text-xs text-emerald-600 font-semibold group-hover:underline mt-3 flex items-center">
                            Riwayat Penjualan &rarr;
                        </span>
                    </a>
                </div>
            </div>

            <!-- 3. Alert Stok Rendah Table -->
            @if ($lowStockCount > 0)
                <div class="bg-white rounded-2xl shadow-sm border border-rose-200 overflow-hidden">
                    <div class="p-5 border-b border-rose-100 bg-rose-50/50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                        <div class="flex items-center gap-3">
                            <span class="w-3 h-3 rounded-full bg-rose-500 animate-ping"></span>
                            <div>
                                <h3 class="text-sm font-bold text-rose-900">Perhatian: {{ $lowStockCount }} Produk Membutuhkan Restock Cepat</h3>
                                <p class="text-xs text-rose-600">Stok berada di bawah atau sama dengan batas minimum persediaan</p>
                            </div>
                        </div>
                        <a href="{{ route('purchases.create') }}" class="text-xs font-semibold bg-rose-600 hover:bg-rose-700 text-white px-3 py-1.5 rounded-lg transition shadow-sm">
                            + Buat Order Pembelian
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
                                        <td class="px-6 py-3 font-mono text-xs font-bold text-gray-700">{{ $lowProd->sku }}</td>
                                        <td class="px-6 py-3 font-semibold text-gray-900">{{ $lowProd->name }}</td>
                                        <td class="px-6 py-3 text-xs text-gray-500">{{ $lowProd->category->name ?? '-' }}</td>
                                        <td class="px-6 py-3 text-center">
                                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-100 text-rose-700">
                                                {{ $lowProd->stock }} unit
                                            </span>
                                        </td>
                                        <td class="px-6 py-3 text-center text-xs text-gray-500">{{ $lowProd->minimum_stock }} unit</td>
                                        <td class="px-6 py-3 text-right font-mono text-xs text-gray-700">Rp {{ number_format($lowProd->purchase_price, 0, ',', '.') }}</td>
                                        <td class="px-6 py-3 text-right">
                                            <a href="{{ route('products.edit', $lowProd) }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-semibold">Edit &rarr;</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <!-- 4. Section: Pencarian Cepat Produk SKU (Pagination) -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-gray-50/50">
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Katalog Produk & Pencarian SKU</h3>
                        <p class="text-xs text-gray-500">Cari informasi ketersediaan barang, modal, dan harga jual</p>
                    </div>
                    <form method="GET" action="{{ route('dashboard') }}" class="w-full md:w-auto flex gap-2">
                        @if ($startDate)<input type="hidden" name="start_date" value="{{ $startDate }}">@endif
                        @if ($endDate)<input type="hidden" name="end_date" value="{{ $endDate }}">@endif
                        @if ($trxSearch)<input type="hidden" name="trx_search" value="{{ $trxSearch }}">@endif

                        <div class="relative w-full md:w-72">
                            <span class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </span>
                            <input type="text" name="product_search" value="{{ $productSearch }}" placeholder="Ketik SKU atau Nama Produk..." class="w-full ps-9 pe-3 py-1.5 text-xs rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <button type="submit" class="px-4 py-1.5 bg-gray-800 hover:bg-gray-900 text-white text-xs font-medium rounded-lg transition">
                            Cari
                        </button>
                        @if ($productSearch)
                            <a href="{{ route('dashboard') }}" class="px-3 py-1.5 bg-gray-200 hover:bg-gray-300 text-gray-700 text-xs font-medium rounded-lg transition">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-gray-600 text-xs uppercase font-semibold">
                            <tr>
                                <th class="px-6 py-3 text-left">SKU</th>
                                <th class="px-6 py-3 text-left">Nama Produk</th>
                                <th class="px-6 py-3 text-left">Kategori</th>
                                <th class="px-6 py-3 text-right">Harga Beli</th>
                                <th class="px-6 py-3 text-right">Harga Jual</th>
                                <th class="px-6 py-3 text-center">Stok</th>
                                <th class="px-6 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($products as $p)
                                <tr class="hover:bg-gray-50/70 transition">
                                    <td class="px-6 py-3.5 font-mono text-xs font-bold text-gray-700">
                                        <span class="bg-gray-100 px-2 py-0.5 rounded">{{ $p->sku }}</span>
                                    </td>
                                    <td class="px-6 py-3.5 font-medium text-gray-900">{{ $p->name }}</td>
                                    <td class="px-6 py-3.5 text-xs text-gray-500">{{ $p->category->name ?? '-' }}</td>
                                    <td class="px-6 py-3.5 text-right font-mono text-xs text-gray-500">Rp {{ number_format($p->purchase_price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-3.5 text-right font-mono text-xs font-bold text-gray-900">Rp {{ number_format($p->selling_price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-3.5 text-center">
                                        @if ($p->stock <= $p->minimum_stock)
                                            <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-rose-100 text-rose-700">{{ $p->stock }} (Low)</span>
                                        @else
                                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700">{{ $p->stock }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-3.5 text-right whitespace-nowrap">
                                        <a href="{{ route('products.show', $p) }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-semibold">Detail &rarr;</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-400 text-sm">Tidak ada produk ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($products->hasPages())
                    <div class="p-3 border-t border-gray-100 bg-gray-50">
                        {{ $products->appends(['product_search' => $productSearch, 'start_date' => $startDate, 'end_date' => $endDate, 'trx_search' => $trxSearch])->links() }}
                    </div>
                @endif
            </div>

            <!-- 5. Section: Tabel Transaksi Penjualan Lengkap dengan Filter Tanggal (Pagination) -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-4">
                        <div>
                            <h3 class="text-base font-bold text-gray-900">Audit & Log Transaksi Penjualan</h3>
                            <p class="text-xs text-gray-500">Filter transaksi berdasarkan rentang tanggal dan pencarian nomor faktur</p>
                        </div>
                        <a href="{{ route('sales.index') }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-semibold">
                            Lihat Modul Penjualan Penuh &rarr;
                        </a>
                    </div>

                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('dashboard') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
                        @if ($productSearch)<input type="hidden" name="product_search" value="{{ $productSearch }}">@endif

                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Dari Tanggal</label>
                            <input type="date" name="start_date" value="{{ $startDate }}" class="w-full text-xs rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Sampai Tanggal</label>
                            <input type="date" name="end_date" value="{{ $endDate }}" class="w-full text-xs rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Cari Invoice / Pelanggan</label>
                            <input type="text" name="trx_search" value="{{ $trxSearch }}" placeholder="No. Invoice atau Nama..." class="w-full text-xs rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="flex items-end gap-2">
                            <button type="submit" class="w-full py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-lg shadow-sm transition">
                                Terapkan Filter
                            </button>
                            @if ($startDate || $endDate || $trxSearch)
                                <a href="{{ route('dashboard') }}" class="px-3 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-xs font-medium rounded-lg transition">
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
                                <tr class="hover:bg-gray-50/70 transition">
                                    <td class="px-6 py-3.5 font-mono text-xs font-semibold text-gray-900">{{ $sale->invoice_number }}</td>
                                    <td class="px-6 py-3.5 text-gray-600 text-xs">{{ $sale->sale_date->format('d M Y') }}</td>
                                    <td class="px-6 py-3.5 text-gray-800 font-medium">{{ $sale->user->name ?? 'Pelanggan Umum' }}</td>
                                    <td class="px-6 py-3.5 text-center">
                                        <span class="px-2 py-0.5 rounded-full text-xs font-bold uppercase {{ $sale->payment_method == 'cash' ? 'bg-emerald-50 text-emerald-700' : 'bg-blue-50 text-blue-700' }}">
                                            {{ $sale->payment_method }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3.5 text-right font-mono font-bold text-gray-900">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</td>
                                    <td class="px-6 py-3.5 text-center whitespace-nowrap">
                                        <a href="{{ route('sales.show', $sale) }}" class="inline-flex items-center px-2.5 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded text-xs font-medium transition">
                                            Lihat Struk
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-10 text-center text-gray-400">Tidak ada transaksi penjualan dalam periode ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($salesTransactions->hasPages())
                    <div class="p-3 border-t border-gray-100 bg-gray-50">
                        {{ $salesTransactions->appends(['start_date' => $startDate, 'end_date' => $endDate, 'trx_search' => $trxSearch, 'product_search' => $productSearch])->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

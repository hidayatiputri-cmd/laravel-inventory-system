<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Ringkasan Inventaris & Dashboard') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Selamat datang, <span class="font-semibold text-indigo-600">{{ Auth::user()->name }}</span> 
                    (Hak Akses: <span class="uppercase font-mono text-xs bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded font-bold">{{ Auth::user()->role }}</span>)
                </p>
            </div>
            @if (in_array(Auth::user()->role, ['admin', 'staff']))
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('sales.create') }}" class="inline-flex items-center px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-semibold shadow-sm transition">
                        <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Kasir / Jual
                    </a>
                    <a href="{{ route('purchases.create') }}" class="inline-flex items-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-semibold shadow-sm transition">
                        <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Restock Barang
                    </a>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <x-alert />

            <!-- 1. KPI Metrics Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <!-- Total Produk -->
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs uppercase font-bold tracking-wider text-gray-400">Total Produk</span>
                        <div class="text-3xl font-extrabold text-gray-900 mt-1">{{ number_format($totalProducts) }}</div>
                        <span class="text-xs text-gray-400 mt-1 block">Item aktif dalam sistem</span>
                    </div>
                    <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                </div>

                <!-- Total Penjualan (Revenue & Transaksi) -->
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs uppercase font-bold tracking-wider text-emerald-600">Total Penjualan</span>
                        <div class="text-2xl font-extrabold text-emerald-600 mt-1 font-mono">
                            Rp {{ number_format($totalSalesRevenue, 0, ',', '.') }}
                        </div>
                        <span class="text-xs text-gray-400 mt-1 block">{{ $totalSalesCount }} kali transaksi</span>
                    </div>
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>

                <!-- Total Pembelian / Inbound -->
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs uppercase font-bold tracking-wider text-blue-600">Total Pembelian</span>
                        <div class="text-2xl font-extrabold text-gray-900 mt-1 font-mono">
                            Rp {{ number_format($totalPurchasesAmount, 0, ',', '.') }}
                        </div>
                        <span class="text-xs text-gray-400 mt-1 block">{{ $totalPurchasesCount }} kali transaksi PO</span>
                    </div>
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>

                <!-- Alert Stok Rendah -->
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between {{ $lowStockCount > 0 ? 'ring-1 ring-rose-200' : '' }}">
                    <div>
                        <span class="text-xs uppercase font-bold tracking-wider text-rose-500">Stok Rendah (Alert)</span>
                        <div class="text-3xl font-extrabold {{ $lowStockCount > 0 ? 'text-rose-600' : 'text-gray-900' }} mt-1">
                            {{ $lowStockCount }}
                        </div>
                        <span class="text-xs text-gray-400 mt-1 block">Barang di bawah batas minimum</span>
                    </div>
                    <div class="w-12 h-12 {{ $lowStockCount > 0 ? 'bg-rose-50 text-rose-600' : 'bg-gray-50 text-gray-400' }} rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- 2. Section: Alert Daftar Stok Rendah -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-rose-50/40 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-gray-900">Peringatan: Daftar Produk Stok Rendah</h3>
                            <p class="text-xs text-gray-500">Produk yang tersisa sama dengan atau kurang dari ambang batas minimum stok</p>
                        </div>
                    </div>
                    @if (in_array(Auth::user()->role, ['admin', 'staff']))
                        <a href="{{ route('purchases.create') }}" class="inline-flex items-center text-xs font-semibold text-rose-700 bg-rose-100 hover:bg-rose-200 px-3 py-1.5 rounded-lg transition">
                            + Restock Sekarang
                        </a>
                    @endif
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-gray-600 text-xs uppercase font-semibold">
                            <tr>
                                <th class="px-6 py-3 text-left">Kode SKU</th>
                                <th class="px-6 py-3 text-left">Nama Produk</th>
                                <th class="px-6 py-3 text-left">Kategori</th>
                                <th class="px-6 py-3 text-center">Stok Saat Ini</th>
                                <th class="px-6 py-3 text-center">Batas Minimum</th>
                                <th class="px-6 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($lowStockProducts as $lowProd)
                                <tr class="hover:bg-rose-50/20 transition">
                                    <td class="px-6 py-3.5 font-mono text-xs font-semibold text-gray-800">
                                        <span class="bg-gray-100 px-2 py-0.5 rounded">{{ $lowProd->sku }}</span>
                                    </td>
                                    <td class="px-6 py-3.5 font-semibold text-gray-900">
                                        {{ $lowProd->name }}
                                    </td>
                                    <td class="px-6 py-3.5 text-xs text-gray-600">
                                        {{ $lowProd->category ? $lowProd->category->name : 'Tanpa Kategori' }}
                                    </td>
                                    <td class="px-6 py-3.5 text-center">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700 animate-pulse">
                                            {{ $lowProd->stock }} unit
                                        </span>
                                    </td>
                                    <td class="px-6 py-3.5 text-center text-gray-500 font-semibold text-xs">
                                        {{ $lowProd->minimum_stock }} unit
                                    </td>
                                    <td class="px-6 py-3.5 text-right whitespace-nowrap">
                                        <a href="{{ route('products.show', $lowProd) }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium">
                                            Detail &rarr;
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                        <div class="flex items-center justify-center gap-2 text-emerald-600 text-sm font-medium">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Semua stok produk berada di atas batas minimum. Kondisi inventaris aman!
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 3. Section: Pencarian Cepat SKU & Nama Produk (Pagination) -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-gray-50/50">
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Katalog Produk & Pencarian SKU</h3>
                        <p class="text-xs text-gray-500">Cari informasi ketersediaan barang dan harga dengan cepat</p>
                    </div>
                    <form method="GET" action="{{ route('dashboard') }}" class="w-full md:w-auto flex gap-2">
                        <!-- Pertahankan parameter filter transaksi jika ada -->
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
                                <th class="px-6 py-3 text-right">Harga Jual</th>
                                <th class="px-6 py-3 text-center">Stok</th>
                                <th class="px-6 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($products as $p)
                                <tr class="hover:bg-gray-50/70 transition">
                                    <td class="px-6 py-3.5 font-mono text-xs font-semibold text-gray-700">
                                        <span class="bg-gray-100 px-2 py-0.5 rounded">{{ $p->sku }}</span>
                                    </td>
                                    <td class="px-6 py-3.5 font-medium text-gray-900">
                                        {{ $p->name }}
                                    </td>
                                    <td class="px-6 py-3.5 text-xs text-gray-500">
                                        {{ $p->category->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-3.5 text-right font-mono text-xs font-bold text-gray-900">
                                        Rp {{ number_format($p->selling_price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-3.5 text-center">
                                        @if ($p->stock <= $p->minimum_stock)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-rose-100 text-rose-700">
                                                {{ $p->stock }} (Low)
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700">
                                                {{ $p->stock }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-3.5 text-right">
                                        <a href="{{ route('products.show', $p) }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium">
                                            Lihat &rarr;
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-400 text-sm">
                                        Produk dengan kata kunci "{{ $productSearch }}" tidak ditemukan.
                                    </td>
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

            <!-- 4. Section: Tabel Transaksi Penjualan dengan Filter Tanggal & Pagination -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-4">
                        <div>
                            <h3 class="text-base font-bold text-gray-900">Tabel Transaksi Penjualan Terkini</h3>
                            <p class="text-xs text-gray-500">Filter transaksi berdasarkan rentang tanggal dan nomor invoice</p>
                        </div>
                        @if (in_array(Auth::user()->role, ['admin', 'staff']))
                            <a href="{{ route('sales.index') }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-semibold">
                                Buka Modul Penjualan Lengkap &rarr;
                            </a>
                        @endif
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
                                <a href="{{ route('dashboard') }}" class="px-3 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-xs font-medium rounded-lg transition" title="Reset Filter">
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
                                <th class="px-6 py-3.5 text-right">Total Transaksi</th>
                                <th class="px-6 py-3.5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($salesTransactions as $sale)
                                <tr class="hover:bg-gray-50/70 transition">
                                    <td class="px-6 py-3.5 font-mono text-xs font-semibold text-gray-900">
                                        {{ $sale->invoice_number }}
                                    </td>
                                    <td class="px-6 py-3.5 text-gray-600 text-xs">
                                        {{ $sale->sale_date->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-3.5 text-gray-800 font-medium">
                                        {{ $sale->user->name ?? 'Pelanggan Umum' }}
                                    </td>
                                    <td class="px-6 py-3.5 text-center">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold uppercase {{ $sale->payment_method == 'cash' ? 'bg-emerald-50 text-emerald-700' : 'bg-blue-50 text-blue-700' }}">
                                            {{ $sale->payment_method }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3.5 text-right font-mono font-bold text-gray-900">
                                        Rp {{ number_format($sale->total_amount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-3.5 text-center whitespace-nowrap">
                                        <a href="{{ route('sales.show', $sale) }}" class="inline-flex items-center px-2.5 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded text-xs font-medium transition">
                                            Lihat Struk
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-10 text-center text-gray-400">
                                        Tidak ada transaksi penjualan yang sesuai dengan rentang tanggal atau filter pencarian.
                                    </td>
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

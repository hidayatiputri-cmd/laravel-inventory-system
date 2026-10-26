<x-app-layout>
    <x-slot name="header">
        @php
            $role = Auth::user()->role;
            $headerGradient = match($role) {
                'admin' => 'from-indigo-600 via-indigo-700 to-blue-700 shadow-indigo-500/20',
                'staff' => 'from-teal-600 via-teal-700 to-emerald-600 shadow-teal-500/20',
                default => 'from-amber-500 via-rose-500 to-rose-600 shadow-rose-500/20',
            };
            $roleLabel = match($role) {
                'admin' => 'Admin Control Center',
                'staff' => 'Staff Operational Panel',
                default => 'Customer Storefront',
            };
            $roleIcon = match($role) {
                'admin' => 'fa-shield-halved',
                'staff' => 'fa-boxes-packing',
                default => 'fa-bag-shopping',
            };
        @endphp

        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r {{ $headerGradient }} p-6 sm:p-8 text-white shadow-xl">
            <div class="relative z-10 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="px-3 py-1 text-[10px] font-black uppercase rounded-full bg-white/20 backdrop-blur-md text-white tracking-wider border border-white/20 flex items-center gap-1.5">
                            <i class="fa-solid {{ $roleIcon }}"></i>
                            <span>{{ $roleLabel }}</span>
                        </span>
                        <span class="text-xs opacity-75">&bull;</span>
                        <span class="text-xs opacity-90 font-medium">{{ now()->format('l, d F Y') }}</span>
                    </div>
                    <h2 class="font-black text-2xl sm:text-3xl text-white leading-tight mt-1 tracking-tight">
                        @if ($role === 'customer')
                            Hai Customer! Selamat Datang di GoShopping
                        @else
                            Dashboard GoShopping
                        @endif
                    </h2>
                    <p class="text-xs sm:text-sm opacity-90 mt-1 max-w-xl">
                        @if ($role === 'customer')
                            Jelajahi berbagai pilihan produk berkualitas dengan jaminan ketersediaan stok fisik real-time langsung dari toko kami.
                        @else
                            Selamat datang, <strong>{{ Auth::user()->name }}</strong>. Kelola transaksi dan pantau inventaris secara real-time.
                        @endif
                    </p>
                </div>

                @if (in_array($role, ['admin', 'staff']))
                    <div class="flex flex-wrap gap-2.5 shrink-0">
                        <a href="{{ route('sales.create') }}" class="inline-flex items-center px-4 py-2.5 bg-white text-slate-900 hover:bg-slate-100 active:scale-95 rounded-xl text-xs font-bold shadow-md transition-all gap-2">
                            <i class="fa-solid fa-cash-register text-emerald-600"></i>
                            <span>+ Transaksi Kasir</span>
                        </a>
                        <a href="{{ route('purchases.create') }}" class="inline-flex items-center px-4 py-2.5 bg-black/30 hover:bg-black/50 text-white border border-white/20 active:scale-95 rounded-xl text-xs font-bold shadow-md transition-all gap-2">
                            <i class="fa-solid fa-cart-plus text-amber-300"></i>
                            <span>+ Restock PO</span>
                        </a>
                    </div>
                @endif
            </div>
            <!-- Glow background orb -->
            <div class="absolute -right-6 -bottom-6 w-48 h-48 bg-white/10 rounded-full blur-2xl"></div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <x-alert />

            <!-- 1. KPI Statistics Grid dengan Gradient Background & FontAwesome Icons -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <!-- Total Produk (Indigo Gradient) -->
                <div class="relative overflow-hidden bg-gradient-to-br from-indigo-500 to-indigo-700 rounded-2xl p-6 text-white shadow-md shadow-indigo-500/20 group hover:-translate-y-1 transition-all duration-300">
                    <div class="flex justify-between items-center text-xs font-bold uppercase tracking-wider text-indigo-100">
                        <span>Total Produk</span>
                        <span class="w-9 h-9 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center text-white">
                            <i class="fa-solid fa-boxes-stacked text-base"></i>
                        </span>
                    </div>
                    <div class="text-3xl font-black mt-3 font-mono">
                        {{ number_format($totalProducts) }}
                    </div>
                    <div class="mt-3 pt-3 border-t border-white/15 text-xs flex items-center justify-between text-indigo-100">
                        <span>Katalog Aktif</span>
                        <a href="{{ route('products.index') }}" class="font-bold underline hover:text-white">Kelola &rarr;</a>
                    </div>
                </div>

                <!-- Total Penjualan (Emerald Gradient) -->
                <div class="relative overflow-hidden bg-gradient-to-br from-emerald-500 to-teal-700 rounded-2xl p-6 text-white shadow-md shadow-emerald-500/20 group hover:-translate-y-1 transition-all duration-300">
                    <div class="flex justify-between items-center text-xs font-bold uppercase tracking-wider text-emerald-100">
                        <span>Total Penjualan</span>
                        <span class="w-9 h-9 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center text-white">
                            <i class="fa-solid fa-sack-dollar text-base"></i>
                        </span>
                    </div>
                    <div class="text-2xl font-black mt-3 font-mono">
                        Rp {{ number_format($totalSalesRevenue, 0, ',', '.') }}
                    </div>
                    <div class="mt-3 pt-3 border-t border-white/15 text-xs flex items-center justify-between text-emerald-100">
                        <span>{{ $totalSalesCount }} kali transaksi</span>
                        <a href="{{ route('sales.index') }}" class="font-bold underline hover:text-white">Lihat &rarr;</a>
                    </div>
                </div>

                <!-- Total Pembelian / Inbound (Blue/Cyan Gradient) -->
                <div class="relative overflow-hidden bg-gradient-to-br from-blue-600 to-cyan-700 rounded-2xl p-6 text-white shadow-md shadow-blue-500/20 group hover:-translate-y-1 transition-all duration-300">
                    <div class="flex justify-between items-center text-xs font-bold uppercase tracking-wider text-blue-100">
                        <span>Total Pembelian (PO)</span>
                        <span class="w-9 h-9 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center text-white">
                            <i class="fa-solid fa-truck-ramp-box text-base"></i>
                        </span>
                    </div>
                    <div class="text-2xl font-black mt-3 font-mono">
                        Rp {{ number_format($totalPurchasesAmount, 0, ',', '.') }}
                    </div>
                    <div class="mt-3 pt-3 border-t border-white/15 text-xs flex items-center justify-between text-blue-100">
                        <span>{{ $totalPurchasesCount }} transaksi inbound</span>
                        <a href="{{ route('purchases.index') }}" class="font-bold underline hover:text-white">Rincian &rarr;</a>
                    </div>
                </div>

                <!-- Alert Stok Rendah (Rose/Amber Gradient) -->
                <div class="relative overflow-hidden bg-gradient-to-br {{ $lowStockCount > 0 ? 'from-rose-500 to-amber-600' : 'from-slate-700 to-slate-800' }} rounded-2xl p-6 text-white shadow-md shadow-rose-500/20 group hover:-translate-y-1 transition-all duration-300">
                    <div class="flex justify-between items-center text-xs font-bold uppercase tracking-wider text-rose-100">
                        <span>Stok Menipis (Alert)</span>
                        <span class="w-9 h-9 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center text-white">
                            <i class="fa-solid fa-triangle-exclamation text-base"></i>
                        </span>
                    </div>
                    <div class="text-3xl font-black mt-3 font-mono">
                        {{ $lowStockCount }} <span class="text-xs font-semibold">item</span>
                    </div>
                    <div class="mt-3 pt-3 border-t border-white/15 text-xs flex items-center justify-between text-rose-100">
                        <span>Batas minimum stok</span>
                        @if ($lowStockCount > 0)
                            <a href="{{ route('purchases.create') }}" class="font-bold underline hover:text-white">Restock &rarr;</a>
                        @else
                            <span class="text-white font-bold">Aman &check;</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- 2. Section: Alert Daftar Stok Rendah -->
            <div class="bg-white rounded-2xl shadow-md border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100 bg-rose-50/50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-triangle-exclamation text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-black text-slate-900">Peringatan: Daftar Produk Stok Rendah</h3>
                            <p class="text-xs text-slate-500">Persediaan produk di bawah atau sama dengan batas minimum stok</p>
                        </div>
                    </div>
                    @if (in_array(Auth::user()->role, ['admin', 'staff']))
                        <a href="{{ route('purchases.create') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 px-4 py-2 rounded-xl transition shadow-sm">
                            <i class="fa-solid fa-plus text-xs"></i>
                            <span>Restock Sekarang</span>
                        </a>
                    @endif
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-sm">
                        <thead class="bg-slate-50 text-slate-600 text-xs uppercase font-bold">
                            <tr>
                                <th class="px-6 py-3.5 text-left">Kode SKU</th>
                                <th class="px-6 py-3.5 text-left">Nama Produk</th>
                                <th class="px-6 py-3.5 text-left">Kategori</th>
                                <th class="px-6 py-3.5 text-center">Stok Saat Ini</th>
                                <th class="px-6 py-3.5 text-center">Batas Minimum</th>
                                <th class="px-6 py-3.5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($lowStockProducts as $lowProd)
                                <tr class="hover:bg-rose-50/30 transition">
                                    <td class="px-6 py-4 font-mono text-xs font-bold text-slate-700">
                                        <span class="bg-slate-100 border border-slate-200 px-2 py-0.5 rounded-lg">{{ $lowProd->sku }}</span>
                                    </td>
                                    <td class="px-6 py-4 font-bold text-slate-900">
                                        {{ $lowProd->name }}
                                    </td>
                                    <td class="px-6 py-4 text-xs text-slate-500 font-medium">
                                        {{ $lowProd->category ? $lowProd->category->name : 'Tanpa Kategori' }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-black bg-rose-100 text-rose-700 border border-rose-200 animate-pulse">
                                            <i class="fa-solid fa-arrow-trend-down me-1.5 text-[10px]"></i>
                                            {{ $lowProd->stock }} unit
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center text-slate-500 font-bold text-xs">
                                        {{ $lowProd->minimum_stock }} unit
                                    </td>
                                    <td class="px-6 py-4 text-right whitespace-nowrap">
                                        <a href="{{ route('products.show', $lowProd) }}" class="inline-flex items-center gap-1 text-xs text-indigo-600 hover:text-indigo-800 font-bold">
                                            <span>Detail</span>
                                            <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                                        <div class="flex items-center justify-center gap-2 text-emerald-600 text-sm font-bold">
                                            <i class="fa-solid fa-circle-check text-base"></i>
                                            <span>Semua stok produk aman di atas batas minimum!</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 3. Section: Pencarian Cepat Produk SKU (Pagination) -->
            <div class="bg-white rounded-2xl shadow-md border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-slate-50/60">
                    <div>
                        <h3 class="text-base font-black text-slate-900">Katalog Produk & Pencarian SKU</h3>
                        <p class="text-xs text-slate-500">Cari informasi ketersediaan barang dan harga jual</p>
                    </div>
                    <form method="GET" action="{{ route('dashboard') }}" class="w-full md:w-auto flex gap-2">
                        @if ($startDate)<input type="hidden" name="start_date" value="{{ $startDate }}">@endif
                        @if ($endDate)<input type="hidden" name="end_date" value="{{ $endDate }}">@endif
                        @if ($trxSearch)<input type="hidden" name="trx_search" value="{{ $trxSearch }}">@endif

                        <div class="relative w-full md:w-72">
                            <span class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none text-slate-400">
                                <i class="fa-solid fa-magnifying-glass text-xs"></i>
                            </span>
                            <input type="text" name="product_search" value="{{ $productSearch }}" placeholder="Ketik SKU atau Nama Produk..." class="w-full ps-9 pe-3 py-2 text-xs rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <button type="submit" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold rounded-xl transition flex items-center gap-1.5">
                            <i class="fa-solid fa-filter text-xs"></i>
                            <span>Cari</span>
                        </button>
                        @if ($productSearch)
                            <a href="{{ route('dashboard') }}" class="px-3 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-bold rounded-xl transition">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-sm">
                        <thead class="bg-slate-50 text-slate-600 text-xs uppercase font-bold">
                            <tr>
                                <th class="px-6 py-3.5 text-left">SKU</th>
                                <th class="px-6 py-3.5 text-left">Nama Produk</th>
                                <th class="px-6 py-3.5 text-left">Kategori</th>
                                <th class="px-6 py-3.5 text-right">Harga Jual</th>
                                <th class="px-6 py-3.5 text-center">Stok</th>
                                <th class="px-6 py-3.5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($products as $p)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="px-6 py-4 font-mono text-xs font-bold text-slate-700">
                                        <span class="bg-slate-100 border border-slate-200 px-2.5 py-0.5 rounded-lg">{{ $p->sku }}</span>
                                    </td>
                                    <td class="px-6 py-4 font-bold text-slate-900">{{ $p->name }}</td>
                                    <td class="px-6 py-4 text-xs text-slate-500 font-medium">{{ $p->category->name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-right font-mono text-xs font-black text-slate-900">
                                        Rp {{ number_format($p->selling_price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if ($p->stock <= $p->minimum_stock)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-black bg-rose-100 text-rose-700 border border-rose-200">
                                                <i class="fa-solid fa-exclamation text-[10px] me-1"></i>
                                                {{ $p->stock }} (Low)
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                <i class="fa-solid fa-check text-[10px] me-1"></i>
                                                {{ $p->stock }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right whitespace-nowrap">
                                        <a href="{{ route('products.show', $p) }}" class="inline-flex items-center gap-1 text-xs text-indigo-600 hover:text-indigo-800 font-bold">
                                            <span>Lihat</span>
                                            <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-slate-400 text-sm">Produk tidak ditemukan.</td>
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

            <!-- 4. Section: Tabel Transaksi Penjualan Lengkap dengan Filter Tanggal (Pagination) -->
            <div class="bg-white rounded-2xl shadow-md border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100 bg-slate-50/60">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-4">
                        <div>
                            <h3 class="text-base font-black text-slate-900">Tabel Transaksi Penjualan Terkini</h3>
                            <p class="text-xs text-slate-500">Filter transaksi berdasarkan rentang tanggal dan nomor invoice</p>
                        </div>
                        @if (in_array(Auth::user()->role, ['admin', 'staff']))
                            <a href="{{ route('sales.index') }}" class="inline-flex items-center gap-1 text-xs text-indigo-600 hover:text-indigo-800 font-bold">
                                <span>Modul Penjualan Penuh</span>
                                <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                            </a>
                        @endif
                    </div>

                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('dashboard') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
                        @if ($productSearch)<input type="hidden" name="product_search" value="{{ $productSearch }}">@endif

                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1">Dari Tanggal</label>
                            <input type="date" name="start_date" value="{{ $startDate }}" class="w-full text-xs rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1">Sampai Tanggal</label>
                            <input type="date" name="end_date" value="{{ $endDate }}" class="w-full text-xs rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1">Cari Invoice / Pelanggan</label>
                            <input type="text" name="trx_search" value="{{ $trxSearch }}" placeholder="No. Invoice atau Nama..." class="w-full text-xs rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="flex items-end gap-2">
                            <button type="submit" class="w-full py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl shadow-sm transition flex items-center justify-center gap-1.5">
                                <i class="fa-solid fa-filter text-xs"></i>
                                <span>Terapkan Filter</span>
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
                    <table class="min-w-full divide-y divide-slate-100 text-sm">
                        <thead class="bg-slate-50 text-slate-600 text-xs uppercase font-bold">
                            <tr>
                                <th class="px-6 py-3.5 text-left">No. Invoice</th>
                                <th class="px-6 py-3.5 text-left">Tanggal</th>
                                <th class="px-6 py-3.5 text-left">Pelanggan</th>
                                <th class="px-6 py-3.5 text-center">Metode</th>
                                <th class="px-6 py-3.5 text-right">Total Tagihan</th>
                                <th class="px-6 py-3.5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($salesTransactions as $sale)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="px-6 py-4 font-mono text-xs font-bold text-slate-900">
                                        <span class="bg-slate-100 border border-slate-200 px-2.5 py-0.5 rounded-lg">{{ $sale->invoice_number }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-slate-600 text-xs font-medium">{{ $sale->sale_date->format('d M Y') }}</td>
                                    <td class="px-6 py-4 text-slate-800 font-bold">{{ $sale->user->name ?? 'Pelanggan Umum' }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-3 py-1 rounded-full text-xs font-black uppercase {{ $sale->payment_method == 'cash' ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : 'bg-blue-100 text-blue-800 border border-blue-200' }}">
                                            <i class="fa-solid {{ $sale->payment_method == 'cash' ? 'fa-money-bill-wave' : 'fa-credit-card' }} me-1 text-[10px]"></i>
                                            {{ $sale->payment_method }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right font-mono font-black text-slate-900 text-sm">
                                        Rp {{ number_format($sale->total_amount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        <a href="{{ route('sales.show', $sale) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-800 rounded-xl text-xs font-bold transition">
                                            <i class="fa-solid fa-receipt text-xs text-slate-500"></i>
                                            <span>Lihat Struk</span>
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

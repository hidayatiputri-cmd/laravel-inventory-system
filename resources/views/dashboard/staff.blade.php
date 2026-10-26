<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-1 text-xs font-bold uppercase rounded-md bg-blue-100 text-blue-700 tracking-wider">
                        Staff Operation Panel
                    </span>
                    <span class="text-xs text-gray-400">|</span>
                    <span class="text-xs text-gray-500">{{ now()->format('l, d F Y') }}</span>
                </div>
                <h2 class="font-extrabold text-2xl text-gray-900 leading-tight mt-1">
                    Operasional Kasir & Gudang
                </h2>
                <p class="text-sm text-gray-500">Petugas aktif: <strong class="text-gray-800">{{ $user->name }}</strong>. Fokus pada pencatatan kasir, restock barang masuk, dan pengecekan stok.</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('sales.create') }}" class="inline-flex items-center px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-bold shadow-sm transition">
                    <svg class="w-5 h-5 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Buka Kasir Penjualan
                </a>
                <a href="{{ route('purchases.create') }}" class="inline-flex items-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-bold shadow-sm transition">
                    <svg class="w-5 h-5 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Input Barang Masuk
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <x-alert />

            <!-- 1. Operasional Metrik Hari Ini -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs uppercase font-bold tracking-wider text-gray-400">Total Jenis Barang</span>
                        <div class="text-3xl font-extrabold text-gray-900 mt-1">{{ $totalProducts }}</div>
                        <span class="text-xs text-gray-500 mt-1 block">Total fisik: {{ number_format($availableStockSum) }} unit</span>
                    </div>
                    <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs uppercase font-bold tracking-wider text-emerald-600">Penjualan Hari Ini</span>
                        <div class="text-3xl font-extrabold text-emerald-600 mt-1">{{ $todaySalesCount }}</div>
                        <a href="{{ route('sales.create') }}" class="text-xs text-emerald-600 font-semibold hover:underline mt-1 inline-block">+ Tambah Transaksi</a>
                    </div>
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs uppercase font-bold tracking-wider text-blue-600">Restock Hari Ini</span>
                        <div class="text-3xl font-extrabold text-blue-600 mt-1">{{ $todayPurchasesCount }}</div>
                        <a href="{{ route('purchases.create') }}" class="text-xs text-blue-600 font-semibold hover:underline mt-1 inline-block">+ Penerimaan PO</a>
                    </div>
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between {{ $lowStockCount > 0 ? 'border-rose-300 ring-2 ring-rose-100' : '' }}">
                    <div>
                        <span class="text-xs uppercase font-bold tracking-wider text-rose-500">Stok Kritis</span>
                        <div class="text-3xl font-extrabold text-rose-600 mt-1">{{ $lowStockCount }}</div>
                        <span class="text-xs text-rose-500 font-medium mt-1 block">Wajib restock segera</span>
                    </div>
                    <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- 2. Cek Stok Cepat & Update Master Stok -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-gray-50/50">
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Pencarian & Pemantauan Stok Produk</h3>
                        <p class="text-xs text-gray-500">Cek persediaan real-time saat melayani pelanggan di kasir</p>
                    </div>
                    <div class="flex gap-2 w-full md:w-auto">
                        <form method="GET" action="{{ route('dashboard') }}" class="flex gap-2 w-full md:w-auto">
                            <div class="relative w-full md:w-80">
                                <span class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </span>
                                <input type="text" name="product_search" value="{{ $productSearch }}" placeholder="Ketik SKU atau Nama Barang..." class="w-full ps-9 pe-3 py-2 text-xs rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <button type="submit" class="px-4 py-2 bg-gray-800 hover:bg-gray-900 text-white text-xs font-semibold rounded-lg transition">
                                Cari
                            </button>
                            @if ($productSearch)
                                <a href="{{ route('dashboard') }}" class="px-3 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-xs font-medium rounded-lg transition">
                                    Reset
                                </a>
                            @endif
                        </form>
                        <a href="{{ route('products.create') }}" class="px-3.5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-lg transition whitespace-nowrap">
                            + Produk Baru
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-gray-600 text-xs uppercase font-semibold">
                            <tr>
                                <th class="px-6 py-3 text-left">SKU</th>
                                <th class="px-6 py-3 text-left">Nama Produk</th>
                                <th class="px-6 py-3 text-left">Kategori</th>
                                <th class="px-6 py-3 text-right">Harga Jual</th>
                                <th class="px-6 py-3 text-center">Stok Fisik</th>
                                <th class="px-6 py-3 text-right">Aksi Cepat</th>
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
                                    <td class="px-6 py-3.5 text-right font-mono text-xs font-bold text-gray-900">Rp {{ number_format($p->selling_price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-3.5 text-center">
                                        @if ($p->stock <= $p->minimum_stock)
                                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-100 text-rose-700 animate-pulse">
                                                {{ $p->stock }} unit (Kritis)
                                            </span>
                                        @else
                                            <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700">
                                                {{ $p->stock }} unit
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-3.5 text-right whitespace-nowrap">
                                        <div class="inline-flex items-center gap-2">
                                            <a href="{{ route('products.edit', $p) }}" class="text-xs text-amber-600 hover:text-amber-800 font-semibold bg-amber-50 px-2.5 py-1 rounded">
                                                Edit Stok
                                            </a>
                                            <a href="{{ route('products.show', $p) }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-semibold">
                                                Detail
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-400 text-sm">Tidak ada produk yang cocok dengan pencarian.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($products->hasPages())
                    <div class="p-3 border-t border-gray-100 bg-gray-50">
                        {{ $products->appends(['product_search' => $productSearch])->links() }}
                    </div>
                @endif
            </div>

            <!-- 3. Dua Kolom: Penjualan Kasir Terakhir vs Penerimaan Gudang Terakhir -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Penjualan Terakhir -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                            <h3 class="text-sm font-bold text-gray-900">Transaksi Kasir Terakhir</h3>
                        </div>
                        <a href="{{ route('sales.index') }}" class="text-xs text-emerald-600 font-semibold hover:underline">Semua &rarr;</a>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @forelse ($recentSales as $sale)
                            <div class="p-4 flex items-center justify-between hover:bg-gray-50 transition text-sm">
                                <div>
                                    <span class="font-mono text-xs font-bold text-gray-800">{{ $sale->invoice_number }}</span>
                                    <div class="text-xs text-gray-500 mt-0.5">
                                        {{ $sale->user->name ?? 'Pelanggan Umum' }} &bull; {{ $sale->sale_date->format('d M') }}
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-mono font-bold text-gray-900 text-xs">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</div>
                                    <a href="{{ route('sales.show', $sale) }}" class="text-[11px] text-indigo-600 hover:underline">Struk</a>
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center text-xs text-gray-400">Belum ada transaksi kasir hari ini.</div>
                        @endforelse
                    </div>
                </div>

                <!-- Pembelian / Inbound Terakhir -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-indigo-500"></span>
                            <h3 class="text-sm font-bold text-gray-900">Restock Masuk Terakhir</h3>
                        </div>
                        <a href="{{ route('purchases.index') }}" class="text-xs text-indigo-600 font-semibold hover:underline">Semua &rarr;</a>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @forelse ($recentPurchases as $purchase)
                            <div class="p-4 flex items-center justify-between hover:bg-gray-50 transition text-sm">
                                <div>
                                    <span class="font-mono text-xs font-bold text-gray-800">{{ $purchase->reference_number }}</span>
                                    <div class="text-xs text-gray-500 mt-0.5">
                                        {{ $purchase->supplier->name ?? 'Supplier' }} &bull; {{ $purchase->purchase_date->format('d M') }}
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-mono font-bold text-gray-900 text-xs">Rp {{ number_format($purchase->total_amount, 0, ',', '.') }}</div>
                                    <a href="{{ route('purchases.show', $purchase) }}" class="text-[11px] text-indigo-600 hover:underline">Faktur PO</a>
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center text-xs text-gray-400">Belum ada barang masuk tercatat.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

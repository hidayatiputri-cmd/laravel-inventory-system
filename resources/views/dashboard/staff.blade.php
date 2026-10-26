<x-app-layout>
    <x-slot name="header">
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-teal-600 via-teal-700 to-emerald-600 p-6 sm:p-7 text-white shadow-lg shadow-teal-500/20">
            <div class="relative z-10 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-0.5 text-[10px] font-black uppercase rounded-full bg-white/20 backdrop-blur-md text-white tracking-wider border border-white/20">
                            Staff Operational Panel
                        </span>
                        <span class="text-xs text-teal-200">&bull;</span>
                        <span class="text-xs text-teal-100 font-medium">{{ now()->format('l, d F Y') }}</span>
                    </div>
                    <h2 class="font-black text-2xl sm:text-3xl text-white leading-tight mt-1 tracking-tight">
                        Operasional Kasir & Gudang GoShopping
                    </h2>
                    <p class="text-xs sm:text-sm text-teal-100 mt-1 max-w-xl">
                        Petugas: <strong>{{ $user->name }}</strong>. Layani transaksi penjualan kasir dan pantau persediaan stok fisik barang.
                    </p>
                </div>
                <div class="flex flex-wrap gap-2.5 shrink-0">
                    <a href="{{ route('sales.create') }}" class="inline-flex items-center px-4 py-2.5 bg-white text-teal-700 hover:bg-teal-50 active:scale-95 rounded-xl text-xs font-bold shadow-md transition-all">
                        <svg class="w-4 h-4 me-1.5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Buka Kasir Penjualan
                    </a>
                    <a href="{{ route('purchases.create') }}" class="inline-flex items-center px-4 py-2.5 bg-teal-900/60 hover:bg-teal-900 text-white border border-white/20 active:scale-95 rounded-xl text-xs font-bold shadow-md transition-all">
                        <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Input Barang Masuk
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

            <!-- 1. Operasional Metrik Hari Ini (Tema Emerald & Teal) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <!-- Penjualan Kasir Hari Ini (Emerald Gradient) -->
                <div class="relative overflow-hidden bg-gradient-to-br from-emerald-500 via-teal-600 to-emerald-800 rounded-3xl p-6 text-white shadow-xl shadow-emerald-600/15 group hover:-translate-y-1 transition-all duration-300">
                    <div class="absolute -right-4 -bottom-4 w-28 h-28 bg-white/10 rounded-full blur-xl group-hover:scale-125 transition-transform"></div>
                    <div class="flex justify-between items-center text-xs font-bold uppercase tracking-wider text-emerald-100">
                        <span>Penjualan Hari Ini</span>
                        <span class="p-2 bg-white/10 backdrop-blur-md rounded-xl">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </span>
                    </div>
                    <div class="text-3xl font-black mt-2 font-mono">
                        {{ $todaySalesCount }} <span class="text-xs font-semibold text-emerald-100">transaksi kasir</span>
                    </div>
                    <div class="mt-3 pt-3 border-t border-white/15 text-xs flex items-center justify-between">
                        <span class="text-emerald-100">Siap cetak struk</span>
                        <a href="{{ route('sales.create') }}" class="font-bold underline hover:text-white">+ Transaksi Baru &rarr;</a>
                    </div>
                </div>

                <!-- Restock Inbound Hari Ini (Teal/Cyan Gradient) -->
                <div class="relative overflow-hidden bg-gradient-to-br from-teal-600 via-cyan-600 to-blue-800 rounded-3xl p-6 text-white shadow-xl shadow-teal-600/15 group hover:-translate-y-1 transition-all duration-300">
                    <div class="absolute -right-4 -bottom-4 w-28 h-28 bg-white/10 rounded-full blur-xl group-hover:scale-125 transition-transform"></div>
                    <div class="flex justify-between items-center text-xs font-bold uppercase tracking-wider text-teal-100">
                        <span>Barang Masuk Hari Ini</span>
                        <span class="p-2 bg-white/10 backdrop-blur-md rounded-xl">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </span>
                    </div>
                    <div class="text-3xl font-black mt-2 font-mono">
                        {{ $todayPurchasesCount }} <span class="text-xs font-semibold text-teal-100">pengiriman PO</span>
                    </div>
                    <div class="mt-3 pt-3 border-t border-white/15 text-xs flex items-center justify-between">
                        <span class="text-teal-100">Penerimaan gudang</span>
                        <a href="{{ route('purchases.create') }}" class="font-bold underline hover:text-white">+ Input PO &rarr;</a>
                    </div>
                </div>

                <!-- Total Fisik Unit Stok -->
                <div class="relative overflow-hidden bg-white rounded-3xl p-6 border border-slate-100 shadow-sm group hover:-translate-y-1 transition-all duration-300">
                    <div class="flex justify-between items-center text-xs font-bold uppercase tracking-wider text-slate-400">
                        <span>Kapasitas Stok Fisik</span>
                        <span class="p-2.5 bg-emerald-50 text-emerald-600 rounded-2xl">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </span>
                    </div>
                    <div class="text-3xl font-black mt-2 text-slate-800 font-mono">
                        {{ number_format($availableStockSum) }} <span class="text-xs font-normal text-slate-400">unit</span>
                    </div>
                    <div class="mt-3 text-xs text-slate-500">
                        Tersebar di {{ $totalProducts }} variasi SKU barang
                    </div>
                </div>

                <!-- Indikator Warna Stok Kritis -->
                <div class="relative overflow-hidden bg-white rounded-3xl p-6 border {{ $lowStockCount > 0 ? 'border-amber-300 ring-4 ring-amber-100 bg-amber-50/20' : 'border-slate-100' }} shadow-sm group hover:-translate-y-1 transition-all duration-300">
                    <div class="flex justify-between items-center text-xs font-bold uppercase tracking-wider {{ $lowStockCount > 0 ? 'text-amber-600' : 'text-slate-400' }}">
                        <span>Stok Menipis / Kritis</span>
                        <span class="p-2.5 {{ $lowStockCount > 0 ? 'bg-amber-100 text-amber-700' : 'bg-slate-100 text-slate-400' }} rounded-2xl">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </span>
                    </div>
                    <div class="text-3xl font-black mt-2 font-mono {{ $lowStockCount > 0 ? 'text-amber-600' : 'text-slate-800' }}">
                        {{ $lowStockCount }} <span class="text-xs font-bold {{ $lowStockCount > 0 ? 'text-amber-600' : 'text-slate-400' }}">item perlu dipantau</span>
                    </div>
                    <div class="mt-3 text-xs flex items-center justify-between">
                        <span class="text-slate-500">Indikator Kuning/Merah</span>
                        @if ($lowStockCount > 0)
                            <span class="text-amber-700 font-bold bg-amber-100 px-2 py-0.5 rounded">Perlu Restock</span>
                        @else
                            <span class="text-emerald-600 font-bold">Stok Normal</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- 2. Cek Stok Cepat & Update Master Stok (Tabel Interaktif dengan Indikator Warna Stok) -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-slate-50/60">
                    <div>
                        <h3 class="text-base font-black text-slate-900">Pencarian Cepat & Monitoring Fisik Barang</h3>
                        <p class="text-xs text-slate-500">Cek persediaan real-time saat melayani kasir dengan indikator status warna</p>
                    </div>
                    <div class="flex gap-2 w-full md:w-auto">
                        <form method="GET" action="{{ route('dashboard') }}" class="flex gap-2 w-full md:w-auto">
                            <div class="relative w-full md:w-80">
                                <span class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </span>
                                <input type="text" name="product_search" value="{{ $productSearch }}" placeholder="Ketik SKU atau Nama Barang..." class="w-full ps-9 pe-3 py-2 text-xs rounded-xl border-slate-200 focus:border-teal-500 focus:ring-teal-500">
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
                        <a href="{{ route('products.create') }}" class="px-4 py-2 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white text-xs font-bold rounded-xl shadow-sm transition whitespace-nowrap">
                            + Produk Baru
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-gray-600 text-xs uppercase font-semibold">
                            <tr>
                                <th class="px-6 py-3.5 text-left">SKU</th>
                                <th class="px-6 py-3.5 text-left">Nama Produk</th>
                                <th class="px-6 py-3.5 text-left">Kategori</th>
                                <th class="px-6 py-3.5 text-right">Harga Jual</th>
                                <th class="px-6 py-3.5 text-center">Status Stok Fisik</th>
                                <th class="px-6 py-3.5 text-right">Aksi Cepat</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($products as $p)
                                <tr class="hover:bg-emerald-50/20 transition">
                                    <td class="px-6 py-3.5 font-mono text-xs font-bold text-slate-700">
                                        <span class="bg-slate-100 px-2 py-0.5 rounded">{{ $p->sku }}</span>
                                    </td>
                                    <td class="px-6 py-3.5">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-10 h-10 rounded-xl overflow-hidden border border-slate-200 bg-slate-50 shrink-0">
                                                <img src="{{ $p->image_url }}" alt="{{ $p->name }}" class="w-full h-full object-cover">
                                            </div>
                                            <div>
                                                <div class="font-bold text-slate-900 leading-tight">{{ $p->name }}</div>
                                                <div class="text-[11px] text-slate-400 font-mono">Min: {{ $p->minimum_stock }} unit</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3.5 text-xs text-slate-500">{{ $p->category->name ?? '-' }}</td>
                                    <td class="px-6 py-3.5 text-right font-mono text-xs font-bold text-teal-800">
                                        Rp {{ number_format($p->selling_price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-3.5 text-center">
                                        <!-- Indikator Warna Stok: Merah (Habis), Kuning (Menipis <= min_stock), Hijau (Aman) -->
                                        @if ($p->stock <= 0)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-black bg-rose-100 text-rose-700 border border-rose-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-600 me-1.5"></span>
                                                Habis (0 unit)
                                            </span>
                                        @elseif ($p->stock <= $p->minimum_stock)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-black bg-amber-100 text-amber-800 border border-amber-200 animate-pulse">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-600 me-1.5"></span>
                                                Menipis ({{ $p->stock }} unit)
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 me-1.5"></span>
                                                Stok Aman ({{ $p->stock }} unit)
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-3.5 text-right whitespace-nowrap">
                                        <div class="inline-flex items-center gap-2">
                                            <a href="{{ route('products.edit', $p) }}" class="text-xs text-amber-700 hover:text-amber-900 font-bold bg-amber-100 hover:bg-amber-200 px-3 py-1 rounded-lg transition">
                                                Edit Stok
                                            </a>
                                            <a href="{{ route('products.show', $p) }}" class="text-xs text-teal-700 hover:text-teal-900 font-bold bg-teal-50 hover:bg-teal-100 px-3 py-1 rounded-lg transition">
                                                Detail
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-slate-400 text-sm">Tidak ada produk yang cocok dengan pencarian.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($products->hasPages())
                    <div class="p-3 border-t border-slate-100 bg-slate-50">
                        {{ $products->appends(['product_search' => $productSearch])->links() }}
                    </div>
                @endif
            </div>

            <!-- 3. Dua Kolom: Penjualan Kasir Terakhir vs Penerimaan Gudang Terakhir -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Penjualan Terakhir & Ubah Status Pesanan -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/60">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-ping"></span>
                            <h3 class="text-sm font-bold text-slate-900">Transaksi Kasir & Status Pesanan</h3>
                        </div>
                        <a href="{{ route('sales.index') }}" class="text-xs text-emerald-600 font-bold hover:underline">Semua &rarr;</a>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @forelse ($recentSales as $sale)
                            <div class="p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:bg-emerald-50/20 transition text-sm">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-mono text-xs font-bold text-slate-800">{{ $sale->invoice_number }}</span>
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $sale->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : ($sale->status === 'cancelled' ? 'bg-rose-100 text-rose-800' : 'bg-amber-100 text-amber-800') }}">
                                            {{ $sale->status }}
                                        </span>
                                    </div>
                                    <div class="text-xs text-slate-500 mt-0.5">
                                        {{ $sale->user->name ?? 'Pelanggan Umum' }} &bull; {{ $sale->sale_date->format('d M') }} ({{ $sale->payment_method }})
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 self-end sm:self-center">
                                    <div class="text-right">
                                        <div class="font-mono font-bold text-emerald-700 text-xs">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</div>
                                        <a href="{{ route('sales.show', $sale) }}" class="text-[11px] text-teal-600 font-bold hover:underline">Struk</a>
                                    </div>

                                    <!-- Form Cepat Pengubahan Status Pesanan oleh Staff -->
                                    <form action="{{ route('sales.status', $sale) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" class="text-[11px] font-bold rounded-lg border-slate-200 py-1 ps-2 pe-6 bg-slate-50 focus:ring-1 focus:ring-teal-500">
                                            <option value="completed" {{ $sale->status === 'completed' ? 'selected' : '' }}>Selesai</option>
                                            <option value="pending" {{ $sale->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="cancelled" {{ $sale->status === 'cancelled' ? 'selected' : '' }}>Batal</option>
                                        </select>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center text-xs text-slate-400">Belum ada transaksi kasir hari ini.</div>
                        @endforelse
                    </div>
                </div>

                <!-- Pembelian / Inbound Terakhir -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/60">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-teal-500"></span>
                            <h3 class="text-sm font-bold text-slate-900">Restock Masuk Terakhir</h3>
                        </div>
                        <a href="{{ route('purchases.index') }}" class="text-xs text-teal-600 font-bold hover:underline">Semua &rarr;</a>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @forelse ($recentPurchases as $purchase)
                            <div class="p-4 flex items-center justify-between hover:bg-teal-50/20 transition text-sm">
                                <div>
                                    <span class="font-mono text-xs font-bold text-slate-800">{{ $purchase->reference_number }}</span>
                                    <div class="text-xs text-slate-500 mt-0.5">
                                        {{ $purchase->supplier->name ?? 'Supplier' }} &bull; {{ $purchase->purchase_date->format('d M') }}
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-mono font-bold text-slate-900 text-xs">Rp {{ number_format($purchase->total_amount, 0, ',', '.') }}</div>
                                    <a href="{{ route('purchases.show', $purchase) }}" class="text-[11px] text-teal-600 font-bold hover:underline">Faktur PO</a>
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center text-xs text-slate-400">Belum ada barang masuk tercatat.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-1 text-xs font-bold uppercase rounded-full bg-emerald-100 text-emerald-800 tracking-wide">
                        Online Storefront
                    </span>
                    <span class="text-xs text-gray-400">&bull;</span>
                    <span class="text-xs text-gray-500">Katalog Belanja Resmi</span>
                </div>
                <h2 class="font-extrabold text-2xl text-gray-900 leading-tight mt-1">
                    Halo, {{ $user->name }}! Selamat Datang di Toko Kami.
                </h2>
                <p class="text-sm text-gray-500">Temukan barang kebutuhan Anda dengan stok terverifikasi dan harga transparan.</p>
            </div>
            <!-- Total Belanja Badge -->
            <div class="bg-white border border-gray-100 rounded-xl px-4 py-2.5 shadow-sm flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <div>
                    <span class="text-[11px] text-gray-400 block uppercase font-bold tracking-wider">Total Belanjaan Anda</span>
                    <span class="text-sm font-extrabold font-mono text-gray-900">Rp {{ number_format($totalSpent, 0, ',', '.') }}</span>
                    <span class="text-[11px] text-gray-500">({{ $orderCount }} pesanan)</span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <x-alert />

            <!-- 1. Banner Promo Toko Online -->
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-600 via-teal-600 to-indigo-700 p-8 text-white shadow-lg">
                <div class="relative z-10 max-w-2xl">
                    <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-semibold uppercase tracking-wider mb-3">
                        ⚡ Jaminan Kualitas & Stok Akurat
                    </span>
                    <h1 class="text-3xl font-extrabold tracking-tight sm:text-4xl">
                        Katalog Produk Terlengkap Langsung dari Distributor
                    </h1>
                    <p class="mt-2 text-sm text-emerald-100 leading-relaxed">
                        Semua produk di bawah ini siap kirim dengan garansi stok nyata terintegrasi langsung dengan inventaris gudang pusat.
                    </p>
                </div>
                <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white/10 rounded-full blur-2xl"></div>
            </div>

            <!-- 2. Pencarian & Filter Kategori (E-Commerce Style Filter Bar) -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex flex-col md:flex-row justify-between items-stretch md:items-center gap-4">
                    <!-- Kategori Pills -->
                    <div class="flex items-center gap-2 overflow-x-auto pb-2 md:pb-0 text-xs font-semibold">
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-xl transition whitespace-nowrap {{ empty($categorySlug) ? 'bg-gray-900 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                            Semua Produk
                        </a>
                        @foreach ($categories as $cat)
                            <a href="{{ route('dashboard', ['category' => $cat->slug, 'search' => $search]) }}" class="px-4 py-2 rounded-xl transition whitespace-nowrap {{ $categorySlug === $cat->slug ? 'bg-emerald-600 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                                {{ $cat->name }} ({{ $cat->products_count }})
                            </a>
                        @endforeach
                    </div>

                    <!-- Search Input -->
                    <form method="GET" action="{{ route('dashboard') }}" class="flex gap-2 shrink-0">
                        @if ($categorySlug)<input type="hidden" name="category" value="{{ $categorySlug }}">@endif
                        <div class="relative w-full sm:w-64">
                            <span class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </span>
                            <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama barang..." class="w-full ps-9 pe-3 py-2 text-xs rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                        <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl transition">
                            Cari
                        </button>
                        @if ($search || $categorySlug)
                            <a href="{{ route('dashboard') }}" class="px-3 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-xs font-semibold rounded-xl transition" title="Bersihkan Filter">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            <!-- 3. Grid Katalog Produk (E-Commerce Product Cards) -->
            <div>
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-extrabold text-gray-900">
                        {{ $categorySlug ? 'Koleksi ' . ucwords(str_replace('-', ' ', $categorySlug)) : 'Daftar Produk Pilihan' }}
                    </h3>
                    <span class="text-xs text-gray-500">Menampilkan {{ $catalogProducts->count() }} produk</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @forelse ($catalogProducts as $prod)
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition duration-200 overflow-hidden flex flex-col justify-between group">
                            <!-- Card Header & Badge -->
                            <div class="p-5 flex-1 flex flex-col">
                                <div class="flex justify-between items-start gap-2 mb-2">
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-gray-100 text-gray-600">
                                        {{ $prod->category->name ?? 'Umum' }}
                                    </span>
                                    <span class="text-[11px] font-mono font-medium text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded">
                                        Tersedia: {{ $prod->stock }} unit
                                    </span>
                                </div>

                                <h4 class="font-bold text-gray-900 text-base group-hover:text-emerald-600 transition">
                                    {{ $prod->name }}
                                </h4>
                                <span class="text-[11px] font-mono text-gray-400 mt-0.5 block">SKU: {{ $prod->sku }}</span>

                                <p class="text-xs text-gray-500 mt-2 line-clamp-2 leading-relaxed flex-1">
                                    {{ $prod->description ?: 'Barang berkualitas dan bergaransi resmi dari toko kami.' }}
                                </p>

                                <div class="mt-4 pt-3 border-t border-gray-50 flex items-baseline justify-between">
                                    <div>
                                        <span class="text-[10px] uppercase font-bold text-gray-400 block">Harga</span>
                                        <span class="text-lg font-black font-mono text-gray-900">
                                            Rp {{ number_format($prod->selling_price, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Footer -->
                            <div class="p-4 bg-gray-50/50 border-t border-gray-100 flex items-center justify-between">
                                <span class="text-xs text-gray-400 flex items-center">
                                    <svg class="w-3.5 h-3.5 text-emerald-500 me-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    Stok Siap Kirim
                                </span>
                                <span class="text-xs font-semibold text-emerald-700 bg-emerald-100/70 px-3 py-1 rounded-lg">
                                    Tersedia
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full bg-white rounded-2xl p-12 text-center border border-gray-100">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                            <h4 class="text-base font-bold text-gray-800">Tidak ada produk ditemukan</h4>
                            <p class="text-xs text-gray-400 mt-1">Coba cari dengan kata kunci lain atau pilih kategori yang berbeda.</p>
                        </div>
                    @endforelse
                </div>

                @if ($catalogProducts->hasPages())
                    <div class="mt-6">
                        {{ $catalogProducts->appends(['category' => $categorySlug, 'search' => $search])->links() }}
                    </div>
                @endif
            </div>

            <!-- 4. Section: Riwayat Transaksi Belanja Pribadi (Customer Order History) -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Riwayat Belanja & Struk Pembelian Anda</h3>
                        <p class="text-xs text-gray-500">Daftar transaksi faktur belanja yang terhubung ke akun Anda</p>
                    </div>
                    <span class="text-xs font-semibold bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full">
                        {{ $orderCount }} Transaksi Tercatat
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-gray-600 text-xs uppercase font-semibold">
                            <tr>
                                <th class="px-6 py-3.5 text-left">No. Faktur Invoice</th>
                                <th class="px-6 py-3.5 text-left">Tanggal Belanja</th>
                                <th class="px-6 py-3.5 text-left">Barang yang Dibeli</th>
                                <th class="px-6 py-3.5 text-center">Metode Bayar</th>
                                <th class="px-6 py-3.5 text-right">Total Tagihan</th>
                                <th class="px-6 py-3.5 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($myOrders as $order)
                                <tr class="hover:bg-gray-50/70 transition">
                                    <td class="px-6 py-4 font-mono font-bold text-xs text-gray-800">
                                        {{ $order->invoice_number }}
                                    </td>
                                    <td class="px-6 py-4 text-xs text-gray-600">
                                        {{ $order->sale_date->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-xs text-gray-700">
                                        <ul class="list-disc list-inside space-y-0.5">
                                            @foreach ($order->items as $item)
                                                <li>
                                                    <span class="font-medium text-gray-900">{{ $item->product->name ?? 'Produk' }}</span> 
                                                    <span class="text-gray-500 font-mono">({{ $item->quantity }}x @ Rp {{ number_format($item->unit_price, 0, ',', '.') }})</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase {{ $order->payment_method == 'cash' ? 'bg-emerald-50 text-emerald-700' : 'bg-blue-50 text-blue-700' }}">
                                            {{ $order->payment_method }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right font-mono font-bold text-emerald-600 text-sm">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                            Lunas
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-10 text-center text-gray-400 text-sm">
                                        <svg class="w-10 h-10 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                        Anda belum memiliki riwayat pembelian. Silakan jelajahi katalog produk di atas!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($myOrders->hasPages())
                    <div class="p-3 border-t border-gray-100 bg-gray-50">
                        {{ $myOrders->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

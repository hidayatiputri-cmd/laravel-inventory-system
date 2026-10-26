<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Inventory Dashboard') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Selamat datang kembali, <span class="font-semibold text-indigo-600">{{ Auth::user()->name }}</span> (Role: <span class="uppercase font-mono text-xs bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded">{{ Auth::user()->role }}</span>)</p>
            </div>
            @if (in_array(Auth::user()->role, ['admin', 'staff']))
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('sales.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-semibold shadow-sm transition">
                        <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Kasir / Jual
                    </a>
                    <a href="{{ route('purchases.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-semibold shadow-sm transition">
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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-alert />

            @php
                $totalProducts = \App\Models\Product::count();
                $lowStockCount = \App\Models\Product::whereColumn('stock', '<=', 'minimum_stock')->count();
                $totalPurchases = \App\Models\Purchase::count();
                $totalSales = \App\Models\Sale::count();
            @endphp

            <!-- Summary KPI Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs uppercase font-bold tracking-wider text-gray-400">Total Produk</span>
                        <div class="text-3xl font-extrabold text-gray-900 mt-1">{{ $totalProducts }}</div>
                        <a href="{{ route('products.index') }}" class="text-xs text-indigo-600 font-medium hover:underline mt-2 inline-block">Lihat Katalog &rarr;</a>
                    </div>
                    <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs uppercase font-bold tracking-wider text-rose-500">Stok Menipis (Alert)</span>
                        <div class="text-3xl font-extrabold {{ $lowStockCount > 0 ? 'text-rose-600' : 'text-gray-900' }} mt-1">
                            {{ $lowStockCount }}
                        </div>
                        <a href="{{ route('products.index') }}" class="text-xs text-rose-600 font-medium hover:underline mt-2 inline-block">Periksa Stok &rarr;</a>
                    </div>
                    <div class="w-12 h-12 {{ $lowStockCount > 0 ? 'bg-rose-50 text-rose-600' : 'bg-gray-50 text-gray-400' }} rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs uppercase font-bold tracking-wider text-gray-400">Total Pembelian</span>
                        <div class="text-3xl font-extrabold text-gray-900 mt-1">{{ $totalPurchases }}</div>
                        <a href="{{ route('purchases.index') }}" class="text-xs text-indigo-600 font-medium hover:underline mt-2 inline-block">Riwayat Inbound &rarr;</a>
                    </div>
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs uppercase font-bold tracking-wider text-gray-400">Total Penjualan</span>
                        <div class="text-3xl font-extrabold text-emerald-600 mt-1">{{ $totalSales }}</div>
                        <a href="{{ route('sales.index') }}" class="text-xs text-emerald-600 font-medium hover:underline mt-2 inline-block">Riwayat Kasir &rarr;</a>
                    </div>
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Quick Links Menu Card -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8">
                <h3 class="text-base font-bold text-gray-900 mb-4">Navigasi Cepat Modul Sistem</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                    <a href="{{ route('products.index') }}" class="p-4 rounded-xl border border-gray-100 hover:border-indigo-300 hover:bg-indigo-50/40 transition group">
                        <span class="block text-sm font-bold text-gray-800 group-hover:text-indigo-600">Produk Barang</span>
                        <span class="text-xs text-gray-400 mt-1 block">SKU, Stok & Harga</span>
                    </a>
                    <a href="{{ route('categories.index') }}" class="p-4 rounded-xl border border-gray-100 hover:border-indigo-300 hover:bg-indigo-50/40 transition group">
                        <span class="block text-sm font-bold text-gray-800 group-hover:text-indigo-600">Kategori</span>
                        <span class="text-xs text-gray-400 mt-1 block">Klasifikasi Barang</span>
                    </a>
                    <a href="{{ route('suppliers.index') }}" class="p-4 rounded-xl border border-gray-100 hover:border-indigo-300 hover:bg-indigo-50/40 transition group">
                        <span class="block text-sm font-bold text-gray-800 group-hover:text-indigo-600">Supplier</span>
                        <span class="text-xs text-gray-400 mt-1 block">Vendor Pengadaan</span>
                    </a>
                    <a href="{{ route('purchases.index') }}" class="p-4 rounded-xl border border-gray-100 hover:border-indigo-300 hover:bg-indigo-50/40 transition group">
                        <span class="block text-sm font-bold text-gray-800 group-hover:text-indigo-600">Pembelian (In)</span>
                        <span class="text-xs text-gray-400 mt-1 block">Barang Masuk Gudang</span>
                    </a>
                    <a href="{{ route('sales.index') }}" class="p-4 rounded-xl border border-gray-100 hover:border-emerald-300 hover:bg-emerald-50/40 transition group">
                        <span class="block text-sm font-bold text-gray-800 group-hover:text-emerald-600">Penjualan (Out)</span>
                        <span class="text-xs text-gray-400 mt-1 block">Kasir & Struk Belanja</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

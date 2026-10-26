<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Detail Produk') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">{{ $product->name }} ({{ $product->sku }})</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium rounded-lg transition">
                    &larr; Kembali
                </a>
                <a href="{{ route('products.edit', $product) }}" class="inline-flex items-center px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-lg transition">
                    Edit Produk
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-alert />

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 sm:p-8">
                    <!-- Status Header -->
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center pb-6 border-b border-gray-100 gap-4">
                        <div>
                            <span class="text-xs font-mono bg-gray-100 text-gray-700 px-2.5 py-1 rounded">SKU: {{ $product->sku }}</span>
                            <h3 class="text-2xl font-bold text-gray-900 mt-2">{{ $product->name }}</h3>
                            <p class="text-sm text-gray-500 mt-1">
                                Kategori: <span class="font-semibold text-indigo-600">{{ $product->category ? $product->category->name : 'Tanpa Kategori' }}</span>
                            </p>
                        </div>
                        <div>
                            @if ($product->stock <= $product->minimum_stock)
                                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold bg-rose-100 text-rose-700">
                                    Stok Menipis ({{ $product->stock }} tersisa)
                                </span>
                            @else
                                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-semibold bg-emerald-100 text-emerald-700">
                                    Stok Tersedia ({{ $product->stock }} unit)
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Metrics Grid -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 py-6 border-b border-gray-100">
                        <div class="bg-gray-50 p-4 rounded-xl">
                            <span class="text-xs text-gray-500 block">Harga Modal / Beli</span>
                            <span class="text-lg font-bold text-gray-800">Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</span>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-xl">
                            <span class="text-xs text-gray-500 block">Harga Jual</span>
                            <span class="text-lg font-bold text-gray-900">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</span>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-xl">
                            <span class="text-xs text-gray-500 block">Potensi Margin / Unit</span>
                            @php
                                $margin = $product->selling_price - $product->purchase_price;
                            @endphp
                            <span class="text-lg font-bold {{ $margin >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                                Rp {{ number_format($margin, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-xl">
                            <span class="text-xs text-gray-500 block">Batas Minimum Stok</span>
                            <span class="text-lg font-bold text-amber-600">{{ $product->minimum_stock }} unit</span>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="pt-6">
                        <h4 class="text-sm font-semibold text-gray-700 mb-2">Deskripsi Produk</h4>
                        <div class="bg-gray-50 p-4 rounded-lg text-sm text-gray-600 whitespace-pre-line">
                            {{ $product->description ?: 'Tidak ada deskripsi yang ditambahkan untuk produk ini.' }}
                        </div>
                    </div>

                    <div class="pt-6 text-xs text-gray-400 flex justify-between border-t border-gray-100 mt-6">
                        <span>Dibuat: {{ $product->created_at->format('d M Y H:i') }}</span>
                        <span>Terakhir Diperbarui: {{ $product->updated_at->format('d M Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

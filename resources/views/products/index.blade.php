<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Daftar Produk') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Kelola stok, SKU, harga beli, harga jual, dan kategori produk</p>
            </div>
            <a href="{{ route('products.create') }}" class="inline-flex items-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white font-medium text-sm rounded-lg shadow-sm transition duration-150">
                <svg class="w-5 h-5 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Produk
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-alert />

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <!-- Search & Filter Bar -->
                <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                    <form method="GET" action="{{ route('products.index') }}" class="flex flex-col md:flex-row gap-3">
                        <div class="relative flex-1">
                            <span class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </span>
                            <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama produk, SKU, atau deskripsi..." class="w-full ps-10 pe-4 py-2 text-sm rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="w-full md:w-64">
                            <select name="category_id" class="w-full py-2 text-sm rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- Semua Kategori --</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex gap-2">
                            <button type="submit" class="px-5 py-2 bg-gray-800 hover:bg-gray-900 text-white text-sm font-medium rounded-lg transition">
                                Filter
                            </button>
                            @if ($search || $categoryId)
                                <a href="{{ route('products.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium rounded-lg transition">
                                    Reset
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold">
                            <tr>
                                <th class="px-5 py-3.5 text-left">No</th>
                                <th class="px-5 py-3.5 text-left">Produk</th>
                                <th class="px-5 py-3.5 text-left">Kategori</th>
                                <th class="px-5 py-3.5 text-left">SKU</th>
                                <th class="px-5 py-3.5 text-right">Harga Beli</th>
                                <th class="px-5 py-3.5 text-right">Harga Jual</th>
                                <th class="px-5 py-3.5 text-center">Stok</th>
                                <th class="px-5 py-3.5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse ($products as $index => $product)
                                <tr class="hover:bg-gray-50/70 transition">
                                    <td class="px-5 py-4 text-gray-500">
                                        {{ $products->firstItem() + $index }}
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 rounded-xl overflow-hidden border border-slate-200 bg-slate-50 shrink-0 shadow-xs">
                                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                            </div>
                                            <div>
                                                <div class="font-bold text-gray-900 leading-tight">
                                                    <a href="{{ route('products.show', $product) }}" class="hover:text-indigo-600 transition">
                                                        {{ $product->name }}
                                                    </a>
                                                </div>
                                                <div class="text-xs text-gray-400 truncate max-w-xs mt-0.5">
                                                    {{ $product->description ?? 'Tidak ada deskripsi' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4">
                                        @if ($product->category)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700">
                                                {{ $product->category->name }}
                                            </span>
                                        @else
                                            <span class="text-xs text-gray-400">Tanpa Kategori</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 font-mono text-xs text-gray-700">
                                        <span class="bg-gray-100 px-2 py-1 rounded">{{ $product->sku }}</span>
                                    </td>
                                    <td class="px-5 py-4 text-right text-gray-600 font-mono text-xs">
                                        Rp {{ number_format($product->purchase_price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-5 py-4 text-right font-semibold text-gray-900 font-mono text-xs">
                                        Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        @if ($product->stock <= $product->minimum_stock)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700 animate-pulse" title="Stok berada pada atau di bawah batas minimum (Min: {{ $product->minimum_stock }})">
                                                {{ $product->stock }} (Low)
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700">
                                                {{ $product->stock }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 text-right whitespace-nowrap">
                                        <div class="inline-flex items-center gap-1.5">
                                            <a href="{{ route('products.show', $product) }}" class="p-1.5 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-md transition" title="Detail Produk">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('products.edit', $product) }}" class="p-1.5 text-amber-600 hover:text-amber-800 hover:bg-amber-50 rounded-md transition" title="Edit Produk">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk {{ $product->name }}?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 text-rose-600 hover:text-rose-800 hover:bg-rose-50 rounded-md transition" title="Hapus Produk">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                            <p class="text-base font-medium text-gray-700">Tidak ada produk ditemukan</p>
                                            <p class="text-sm text-gray-400 mt-1">Coba gunakan filter pencarian lain atau tambahkan produk baru.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($products->hasPages())
                    <div class="p-4 border-t border-gray-100 bg-gray-50">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

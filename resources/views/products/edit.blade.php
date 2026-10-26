<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Edit Produk') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Perbarui informasi barang: {{ $product->name }}</p>
            </div>
            <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium rounded-lg transition">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <x-alert />

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sm:p-8">
                <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="sm:col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                Nama Produk <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-rose-500 @enderror">
                            @error('name')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="sku" class="block text-sm font-medium text-gray-700 mb-1">
                                Kode SKU (Stock Keeping Unit) <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="sku" id="sku" value="{{ old('sku', $product->sku) }}" required class="w-full uppercase font-mono rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('sku') border-rose-500 @enderror">
                            @error('sku')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">
                                Kategori
                            </label>
                            <select name="category_id" id="category_id" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('category_id') border-rose-500 @enderror">
                                <option value="">-- Tanpa Kategori --</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="purchase_price" class="block text-sm font-medium text-gray-700 mb-1">
                                Harga Beli / Modal (Rp) <span class="text-rose-500">*</span>
                            </label>
                            <input type="number" step="0.01" name="purchase_price" id="purchase_price" value="{{ old('purchase_price', $product->purchase_price) }}" required min="0" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('purchase_price') border-rose-500 @enderror">
                            @error('purchase_price')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="selling_price" class="block text-sm font-medium text-gray-700 mb-1">
                                Harga Jual (Rp) <span class="text-rose-500">*</span>
                            </label>
                            <input type="number" step="0.01" name="selling_price" id="selling_price" value="{{ old('selling_price', $product->selling_price) }}" required min="0" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('selling_price') border-rose-500 @enderror">
                            @error('selling_price')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">
                                Stok Sekarang <span class="text-rose-500">*</span>
                            </label>
                            <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" required min="0" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('stock') border-rose-500 @enderror">
                            @error('stock')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="minimum_stock" class="block text-sm font-medium text-gray-700 mb-1">
                                Batas Minimum Stok <span class="text-rose-500">*</span>
                            </label>
                            <input type="number" name="minimum_stock" id="minimum_stock" value="{{ old('minimum_stock', $product->minimum_stock) }}" required min="0" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('minimum_stock') border-rose-500 @enderror">
                            @error('minimum_stock')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Foto Produk Preview & Update -->
                        <div class="sm:col-span-2 bg-indigo-50/50 p-4 rounded-xl border border-indigo-100 space-y-4">
                            <div class="flex items-center gap-2 text-indigo-900 font-bold text-sm">
                                <i class="fa-solid fa-image text-indigo-600"></i>
                                <span>Foto & Visualisasi Produk</span>
                            </div>

                            <div class="flex flex-col sm:flex-row items-center gap-4">
                                <div class="shrink-0 w-24 h-24 rounded-2xl overflow-hidden border border-slate-200 shadow-sm bg-white">
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 w-full space-y-3">
                                    <div>
                                        <label for="image_file" class="block text-xs font-semibold text-gray-700 mb-1">
                                            Ganti dengan File Baru (Max 2MB)
                                        </label>
                                        <input type="file" name="image_file" id="image_file" accept="image/*" class="w-full text-xs text-gray-700 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 bg-white rounded-lg border border-gray-300 p-1 @error('image_file') border-rose-500 @enderror">
                                    </div>
                                    <div>
                                        <label for="image_url" class="block text-xs font-semibold text-gray-700 mb-1">
                                            Atau Ganti URL Gambar (Unsplash / Eksternal)
                                        </label>
                                        <input type="url" name="image_url" id="image_url" value="{{ old('image_url', str_starts_with($product->image ?? '', 'http') ? $product->image : '') }}" placeholder="https://..." class="w-full text-sm rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 bg-white @error('image_url') border-rose-500 @enderror">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                                Deskripsi Produk
                            </label>
                            <textarea name="description" id="description" rows="3" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('description') border-rose-500 @enderror">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('products.index') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition">
                            Batal
                        </a>
                        <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white rounded-lg text-sm font-medium shadow-sm transition">
                            Perbarui Produk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

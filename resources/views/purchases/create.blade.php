<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Catat Pembelian Baru (Restock)') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Pembelian stok dari supplier akan otomatis menambahkan stok barang</p>
            </div>
            <a href="{{ route('purchases.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium rounded-lg transition">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <x-alert />

            <form action="{{ route('purchases.store') }}" method="POST" id="purchaseForm" class="space-y-6">
                @csrf

                <!-- Master Information Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sm:p-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Informasi Pembelian</h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="supplier_id" class="block text-sm font-medium text-gray-700 mb-1">
                                Supplier <span class="text-rose-500">*</span>
                            </label>
                            <select name="supplier_id" id="supplier_id" required class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('supplier_id') border-rose-500 @enderror">
                                <option value="">-- Pilih Supplier Pemasok --</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('supplier_id')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="purchase_date" class="block text-sm font-medium text-gray-700 mb-1">
                                Tanggal Pembelian <span class="text-rose-500">*</span>
                            </label>
                            <input type="date" name="purchase_date" id="purchase_date" value="{{ old('purchase_date', date('Y-m-d')) }}" required class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('purchase_date') border-rose-500 @enderror">
                            @error('purchase_date')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                                Catatan / Keterangan Pembelian
                            </label>
                            <textarea name="notes" id="notes" rows="2" placeholder="Nomor faktur supplier, nomor ekspedisi, dll (opsional)..." class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Items Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sm:p-8">
                    <div class="flex items-center justify-between mb-4 border-b pb-2">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Daftar Barang Masuk</h3>
                            <p class="text-xs text-gray-500">Pilih produk dan tentukan kuantitas serta harga beli per unit</p>
                        </div>
                        <button type="button" id="addItemBtn" class="inline-flex items-center px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-semibold shadow-sm transition">
                            <svg class="w-4 h-4 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Baris Barang
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm" id="itemsTable">
                            <thead class="bg-gray-50 text-gray-600 text-xs uppercase font-semibold">
                                <tr>
                                    <th class="px-3 py-3 text-left" style="width: 45%;">Produk</th>
                                    <th class="px-3 py-3 text-center" style="width: 15%;">Jumlah (Qty)</th>
                                    <th class="px-3 py-3 text-right" style="width: 20%;">Harga Beli Satuan (Rp)</th>
                                    <th class="px-3 py-3 text-right" style="width: 15%;">Subtotal</th>
                                    <th class="px-3 py-3 text-center" style="width: 5%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="itemsTableBody" class="divide-y divide-gray-100">
                                <!-- Baris item dibuat via script / loop old data -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Grand Total Preview -->
                    <div class="mt-6 flex justify-end border-t border-gray-100 pt-4">
                        <div class="text-right">
                            <span class="text-sm text-gray-500 block">Perkiraan Total Pembelian:</span>
                            <span id="grandTotalText" class="text-2xl font-bold font-mono text-gray-900">Rp 0</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('purchases.index') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white rounded-lg text-sm font-semibold shadow-sm transition">
                        Simpan Transaksi Pembelian
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Produk JSON untuk Autocomplete Harga -->
    <script>
        const productsCatalog = @json($products);
        let itemIndex = 0;

        function createItemRow(selectedId = '', qty = 1, price = 0) {
            const tr = document.createElement('tr');
            tr.className = 'hover:bg-gray-50 transition item-row';
            tr.dataset.index = itemIndex;

            let optionsHtml = '<option value="">-- Pilih Produk --</option>';
            productsCatalog.forEach(p => {
                const selected = p.id == selectedId ? 'selected' : '';
                optionsHtml += `<option value="${p.id}" data-price="${p.purchase_price}" ${selected}>${p.name} (SKU: ${p.sku}) [Stok: ${p.stock}]</option>`;
            });

            tr.innerHTML = `
                <td class="px-3 py-3">
                    <select name="items[${itemIndex}][product_id]" required class="product-select w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        ${optionsHtml}
                    </select>
                </td>
                <td class="px-3 py-3 text-center">
                    <input type="number" name="items[${itemIndex}][quantity]" value="${qty}" min="1" required class="qty-input w-24 text-center rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                </td>
                <td class="px-3 py-3 text-right">
                    <input type="number" step="0.01" name="items[${itemIndex}][unit_price]" value="${price}" min="0" required class="price-input w-36 text-right rounded-lg border-gray-300 text-sm font-mono focus:border-indigo-500 focus:ring-indigo-500">
                </td>
                <td class="px-3 py-3 text-right font-mono font-semibold text-gray-800 subtotal-text">
                    Rp 0
                </td>
                <td class="px-3 py-3 text-center">
                    <button type="button" class="remove-btn p-1.5 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-md transition" title="Hapus Baris">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </td>
            `;

            document.getElementById('itemsTableBody').appendChild(tr);

            const select = tr.querySelector('.product-select');
            const qtyInput = tr.querySelector('.qty-input');
            const priceInput = tr.querySelector('.price-input');
            const removeBtn = tr.querySelector('.remove-btn');

            select.addEventListener('change', function() {
                const opt = select.options[select.selectedIndex];
                if (opt && opt.dataset.price) {
                    priceInput.value = parseFloat(opt.dataset.price);
                }
                calculateRow(tr);
            });

            qtyInput.addEventListener('input', () => calculateRow(tr));
            priceInput.addEventListener('input', () => calculateRow(tr));
            removeBtn.addEventListener('click', function() {
                if (document.querySelectorAll('.item-row').length > 1) {
                    tr.remove();
                    calculateGrandTotal();
                } else {
                    alert('Minimal harus menyertakan 1 produk dalam transaksi.');
                }
            });

            calculateRow(tr);
            itemIndex++;
        }

        function calculateRow(tr) {
            const qty = parseFloat(tr.querySelector('.qty-input').value) || 0;
            const price = parseFloat(tr.querySelector('.price-input').value) || 0;
            const subtotal = qty * price;
            tr.querySelector('.subtotal-text').innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
            calculateGrandTotal();
        }

        function calculateGrandTotal() {
            let total = 0;
            document.querySelectorAll('.item-row').forEach(row => {
                const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
                const price = parseFloat(row.querySelector('.price-input').value) || 0;
                total += (qty * price);
            });
            document.getElementById('grandTotalText').innerText = 'Rp ' + total.toLocaleString('id-ID');
        }

        document.getElementById('addItemBtn').addEventListener('click', () => createItemRow());

        // Inisialisasi baris pertama saat form dibuka
        document.addEventListener('DOMContentLoaded', () => {
            createItemRow();
        });
    </script>
</x-app-layout>

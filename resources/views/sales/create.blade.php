<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Transaksi Kasir / Penjualan Baru') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Stok produk otomatis berkurang secara aman dan divalidasi langsung di server</p>
            </div>
            <a href="{{ route('sales.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium rounded-lg transition">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <x-alert />

            <form action="{{ route('sales.store') }}" method="POST" id="salesForm" class="space-y-6">
                @csrf

                <!-- Master Information Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sm:p-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Informasi Pembeli & Transaksi</h3>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div>
                            <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">
                                Pelanggan (Customer)
                            </label>
                            <select name="user_id" id="user_id" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('user_id') border-rose-500 @enderror">
                                <option value="">-- Pelanggan Umum / Non-Member --</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('user_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }} ({{ $customer->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="sale_date" class="block text-sm font-medium text-gray-700 mb-1">
                                Tanggal Transaksi <span class="text-rose-500">*</span>
                            </label>
                            <input type="date" name="sale_date" id="sale_date" value="{{ old('sale_date', date('Y-m-d')) }}" required class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('sale_date') border-rose-500 @enderror">
                            @error('sale_date')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">
                                Metode Pembayaran <span class="text-rose-500">*</span>
                            </label>
                            <select name="payment_method" id="payment_method" required class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('payment_method') border-rose-500 @enderror">
                                <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash / Tunai</option>
                                <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                                <option value="qris" {{ old('payment_method') == 'qris' ? 'selected' : '' }}>QRIS</option>
                                <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Kartu Kredit / Debit</option>
                            </select>
                            @error('payment_method')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="sm:col-span-3">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                                Catatan Transaksi
                            </label>
                            <input type="text" name="notes" id="notes" value="{{ old('notes') }}" placeholder="Catatan tambahan (opsional)..." class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>
                </div>

                <!-- Items Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sm:p-8">
                    <div class="flex items-center justify-between mb-4 border-b pb-2">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Barang yang Dibeli</h3>
                            <p class="text-xs text-gray-500">Pilih barang dan jumlah pesanan (harga terverifikasi otomatis dari sistem server)</p>
                        </div>
                        <button type="button" id="addItemBtn" class="inline-flex items-center px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-semibold shadow-sm transition">
                            <svg class="w-4 h-4 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Baris Barang
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm" id="salesTable">
                            <thead class="bg-gray-50 text-gray-600 text-xs uppercase font-semibold">
                                <tr>
                                    <th class="px-3 py-3 text-left" style="width: 50%;">Produk</th>
                                    <th class="px-3 py-3 text-center" style="width: 15%;">Jumlah Beli</th>
                                    <th class="px-3 py-3 text-right" style="width: 15%;">Harga Satuan</th>
                                    <th class="px-3 py-3 text-right" style="width: 15%;">Subtotal</th>
                                    <th class="px-3 py-3 text-center" style="width: 5%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="salesTableBody" class="divide-y divide-gray-100">
                                <!-- Baris item dibuat via JavaScript -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Grand Total Preview -->
                    <div class="mt-6 flex justify-end border-t border-gray-100 pt-4">
                        <div class="text-right">
                            <span class="text-sm text-gray-500 block">Total Tagihan:</span>
                            <span id="grandTotalText" class="text-3xl font-extrabold font-mono text-emerald-600">Rp 0</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('sales.index') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white rounded-lg text-sm font-semibold shadow-sm transition">
                        Proses & Cetak Transaksi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Produk JSON untuk Dropdown & Kalkulasi Real-time -->
    <script>
        const productsCatalog = @json($products);
        let itemIndex = 0;

        function createSaleRow(selectedId = '', qty = 1) {
            const tr = document.createElement('tr');
            tr.className = 'hover:bg-gray-50 transition item-row';
            tr.dataset.index = itemIndex;

            let optionsHtml = '<option value="">-- Pilih Produk --</option>';
            productsCatalog.forEach(p => {
                const selected = p.id == selectedId ? 'selected' : '';
                optionsHtml += `<option value="${p.id}" data-price="${p.selling_price}" data-stock="${p.stock}" ${selected}>${p.name} (Stok: ${p.stock}) - Rp ${Number(p.selling_price).toLocaleString('id-ID')}</option>`;
            });

            tr.innerHTML = `
                <td class="px-3 py-3">
                    <select name="items[${itemIndex}][product_id]" required class="product-select w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        ${optionsHtml}
                    </select>
                    <div class="stock-warning text-xs text-rose-500 mt-1 hidden font-medium"></div>
                </td>
                <td class="px-3 py-3 text-center">
                    <input type="number" name="items[${itemIndex}][quantity]" value="${qty}" min="1" required class="qty-input w-24 text-center rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                </td>
                <td class="px-3 py-3 text-right font-mono text-xs text-gray-700 unit-price-text">
                    Rp 0
                </td>
                <td class="px-3 py-3 text-right font-mono font-bold text-gray-900 subtotal-text">
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

            document.getElementById('salesTableBody').appendChild(tr);

            const select = tr.querySelector('.product-select');
            const qtyInput = tr.querySelector('.qty-input');
            const removeBtn = tr.querySelector('.remove-btn');

            select.addEventListener('change', () => calculateRow(tr));
            qtyInput.addEventListener('input', () => calculateRow(tr));
            removeBtn.addEventListener('click', function() {
                if (document.querySelectorAll('.item-row').length > 1) {
                    tr.remove();
                    calculateGrandTotal();
                } else {
                    alert('Minimal harus menyertakan 1 produk dalam transaksi penjualan.');
                }
            });

            calculateRow(tr);
            itemIndex++;
        }

        function calculateRow(tr) {
            const select = tr.querySelector('.product-select');
            const qtyInput = tr.querySelector('.qty-input');
            const stockWarning = tr.querySelector('.stock-warning');
            const opt = select.options[select.selectedIndex];

            let price = 0;
            let maxStock = 0;

            if (opt && opt.dataset.price) {
                price = parseFloat(opt.dataset.price);
                maxStock = parseInt(opt.dataset.stock) || 0;
            }

            const qty = parseInt(qtyInput.value) || 0;

            // Validasi visual stok client-side
            if (opt && opt.value && qty > maxStock) {
                stockWarning.innerText = `Jumlah melebihi stok yang tersedia (${maxStock} unit)!`;
                stockWarning.classList.remove('hidden');
                qtyInput.classList.add('border-rose-500');
            } else {
                stockWarning.classList.add('hidden');
                qtyInput.classList.remove('border-rose-500');
            }

            const subtotal = qty * price;
            tr.querySelector('.unit-price-text').innerText = 'Rp ' + price.toLocaleString('id-ID');
            tr.querySelector('.subtotal-text').innerText = 'Rp ' + subtotal.toLocaleString('id-ID');

            calculateGrandTotal();
        }

        function calculateGrandTotal() {
            let total = 0;
            document.querySelectorAll('.item-row').forEach(row => {
                const select = row.querySelector('.product-select');
                const opt = select.options[select.selectedIndex];
                const price = opt && opt.dataset.price ? parseFloat(opt.dataset.price) : 0;
                const qty = parseInt(row.querySelector('.qty-input').value) || 0;
                total += (qty * price);
            });
            document.getElementById('grandTotalText').innerText = 'Rp ' + total.toLocaleString('id-ID');
        }

        document.getElementById('addItemBtn').addEventListener('click', () => createSaleRow());

        document.addEventListener('DOMContentLoaded', () => {
            createSaleRow();
        });
    </script>
</x-app-layout>

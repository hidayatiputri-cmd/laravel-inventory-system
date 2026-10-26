<x-app-layout>
    <!-- CDN Tailwind CSS & FontAwesome Instan -->
    @push('styles')
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @endpush

    <!-- Fallback direct CDN check -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 text-[11px] font-black uppercase rounded-full bg-indigo-100 text-indigo-700 tracking-wider">
                        <i class="fa-solid fa-cash-register mr-1"></i> Point of Sale (POS)
                    </span>
                    <span class="text-xs text-slate-400">&bull;</span>
                    <span class="text-xs text-slate-500 font-medium">{{ now()->format('d M Y') }}</span>
                </div>
                <h2 class="font-black text-2xl text-slate-900 leading-tight mt-1">
                    Transaksi Kasir / Penjualan Baru
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">
                    Stok produk otomatis terverifikasi dan berkurang secara atomik & real-time
                </p>
            </div>
            <a href="{{ route('sales.index') }}" class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl px-4 py-2 font-medium text-xs transition active:scale-95 shadow-sm">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                <span>Kembali ke Riwayat</span>
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-alert />

            <form action="{{ route('sales.store') }}" method="POST" id="salesForm">
                @csrf

                <!-- Layout Grid 2 Kolom POS Modern -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                    
                    <!-- Kolom Kiri (Card 1): Informasi Pembeli & Transaksi (5 Kolom di Layar Lebar) -->
                    <div class="lg:col-span-5 bg-white rounded-2xl p-6 shadow-sm border border-slate-100 space-y-5">
                        <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-base">
                                <i class="fa-solid fa-user-tag"></i>
                            </div>
                            <div>
                                <h3 class="text-base font-black text-slate-900">Informasi Pembeli & Transaksi</h3>
                                <p class="text-xs text-slate-500">Rincian data pelanggan dan metode pembayaran</p>
                            </div>
                        </div>

                        <!-- 1. Pelanggan (User) -->
                        <div>
                            <label for="user_id" class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center gap-1.5">
                                <i class="fa-solid fa-user text-indigo-500 text-xs"></i>
                                <span>Pelanggan (Customer)</span>
                            </label>
                            <div class="relative">
                                <select name="user_id" id="user_id" class="w-full text-xs text-slate-800 bg-white border border-slate-200 rounded-xl py-2.5 px-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition @error('user_id') border-rose-500 @enderror">
                                    <option value="">-- Pelanggan Umum / Non-Member --</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ old('user_id') == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->name }} ({{ $customer->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('user_id')
                                <p class="mt-1 text-xs text-rose-500 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- 2. Tanggal Transaksi (Kalender) -->
                        <div>
                            <label for="sale_date" class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center gap-1.5">
                                <i class="fa-solid fa-calendar-days text-indigo-500 text-xs"></i>
                                <span>Tanggal Transaksi <span class="text-rose-500">*</span></span>
                            </label>
                            <div class="relative">
                                <input type="date" name="sale_date" id="sale_date" value="{{ old('sale_date', date('Y-m-d')) }}" required
                                    class="w-full text-xs text-slate-800 bg-white border border-slate-200 rounded-xl py-2.5 px-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition @error('sale_date') border-rose-500 @enderror">
                            </div>
                            @error('sale_date')
                                <p class="mt-1 text-xs text-rose-500 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- 3. Metode Pembayaran (Dompet) -->
                        <div>
                            <label for="payment_method" class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center gap-1.5">
                                <i class="fa-solid fa-wallet text-indigo-500 text-xs"></i>
                                <span>Metode Pembayaran <span class="text-rose-500">*</span></span>
                            </label>
                            <div class="relative">
                                <select name="payment_method" id="payment_method" required
                                    class="w-full text-xs text-slate-800 bg-white border border-slate-200 rounded-xl py-2.5 px-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition @error('payment_method') border-rose-500 @enderror">
                                    <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Tunai / Cash</option>
                                    <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                                    <option value="qris" {{ old('payment_method') == 'qris' ? 'selected' : '' }}>QRIS Statis / Dinamis</option>
                                    <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Kartu Debit / Kredit</option>
                                </select>
                            </div>
                            @error('payment_method')
                                <p class="mt-1 text-xs text-rose-500 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- 4. Catatan Transaksi (Catatan) -->
                        <div>
                            <label for="notes" class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center gap-1.5">
                                <i class="fa-solid fa-clipboard-list text-indigo-500 text-xs"></i>
                                <span>Catatan Transaksi</span>
                            </label>
                            <textarea name="notes" id="notes" rows="3" placeholder="Catatan opsional (nomor meja, kurir, atau keterangan khusus)..."
                                class="w-full text-xs text-slate-800 bg-white border border-slate-200 rounded-xl py-2 px-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">{{ old('notes') }}</textarea>
                        </div>

                        <!-- Info Petunjuk Kasir Ringkas -->
                        <div class="bg-indigo-50/70 rounded-xl p-3.5 border border-indigo-100 flex items-start gap-2.5 text-xs text-indigo-900">
                            <i class="fa-solid fa-shield-halved text-indigo-600 mt-0.5"></i>
                            <div>
                                <span class="font-bold">Keamanan Stok Terjamin:</span>
                                <p class="text-[11px] text-indigo-700 mt-0.5">Sistem mengunci baris produk saat transaksi dieksekusi agar stok tidak minus meski banyak kasir melayani bersamaan.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan (Card 2): Pilih Produk & Ringkasan Pembayaran (7 Kolom di Layar Lebar) -->
                    <div class="lg:col-span-7 bg-gradient-to-br from-indigo-50 to-slate-50 rounded-2xl p-6 shadow-sm border border-indigo-100 space-y-6">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-indigo-100">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-white text-indigo-600 shadow-sm flex items-center justify-center font-bold text-base">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                </div>
                                <div>
                                    <h3 class="text-base font-black text-slate-900">Pilih Produk & Keranjang POS</h3>
                                    <p class="text-xs text-slate-500">Pilih barang dan sesuaikan kuantitas beli</p>
                                </div>
                            </div>
                            <button type="button" id="addItemBtn" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-sm transition active:scale-95 shrink-0">
                                <i class="fa-solid fa-plus text-xs"></i>
                                <span>Tambah Item</span>
                            </button>
                        </div>

                        <!-- Daftar Item Belanja (Dinamis via JS) -->
                        <div id="itemsContainer" class="space-y-3">
                            <!-- Template Baris Produk JS Render Disini -->
                        </div>

                        <!-- Ringkasan Total Tagihan Berukuran Besar Mencolok -->
                        <div class="bg-white rounded-2xl p-5 border border-indigo-200 shadow-sm space-y-4">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 pb-3">
                                <span class="text-xs font-bold uppercase tracking-wider text-slate-500 flex items-center gap-1.5">
                                    <i class="fa-solid fa-receipt text-indigo-500"></i>
                                    <span>Total Pembayaran Kasir</span>
                                </span>
                                <span class="text-xs text-slate-400 font-medium">Termasuk PPN & update stok langsung</span>
                            </div>

                            <div class="flex items-center justify-between">
                                <span class="text-sm font-bold text-slate-700">Total Harga:</span>
                                <span id="grandTotalText" class="text-3xl sm:text-4xl font-black font-mono text-indigo-600 tracking-tight">
                                    Rp 0
                                </span>
                            </div>

                            <!-- Tombol Aksi Modern Sesuai Permintaan -->
                            <div class="pt-2 flex flex-col sm:flex-row items-center gap-3">
                                <a href="{{ route('sales.index') }}" class="w-full sm:w-auto text-center bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl px-4 py-2 font-medium text-xs transition">
                                    Batal Transaksi
                                </a>
                                <button type="submit" class="flex-1 w-full bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white rounded-xl py-3 font-semibold text-sm shadow-md shadow-indigo-200 transition-all active:scale-[0.99] flex items-center justify-center gap-2">
                                    <i class="fa-solid fa-circle-check text-base"></i>
                                    <span>Proses Transaksi Kasir</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Produk JSON untuk Dropdown & Kalkulasi Real-time -->
    <script>
        const productsCatalog = @json($products);
        let itemIndex = 0;

        function createSaleItem(selectedId = '', qty = 1) {
            const container = document.getElementById('itemsContainer');
            const itemCard = document.createElement('div');
            itemCard.className = 'item-row bg-white rounded-xl p-4 border border-slate-200 shadow-sm transition-all hover:border-indigo-300 relative';
            itemCard.dataset.index = itemIndex;

            let optionsHtml = '<option value="">-- Pilih Produk yang Dijual --</option>';
            productsCatalog.forEach(p => {
                const selected = p.id == selectedId ? 'selected' : '';
                optionsHtml += `<option value="${p.id}" data-price="${p.selling_price}" data-stock="${p.stock}" ${selected}>
                    ${p.name} (Stok: ${p.stock}) - Rp ${Number(p.selling_price).toLocaleString('id-ID')}
                </option>`;
            });

            itemCard.innerHTML = `
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                    <!-- Thumbnail Foto Produk Visual -->
                    <div class="w-14 h-14 rounded-xl overflow-hidden border border-slate-200 bg-slate-50 shrink-0 shadow-xs">
                        <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=200&auto=format&fit=crop&q=80" alt="Produk" class="product-thumb w-full h-full object-cover">
                    </div>

                    <div class="flex-1 w-full">
                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">
                            Pilih Produk & Stok Tersedia
                        </label>
                        <select name="items[${itemIndex}][product_id]" required
                            class="product-select w-full text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl py-2 px-3 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                            ${optionsHtml}
                        </select>
                        <div class="stock-warning text-[11px] text-rose-600 font-bold mt-1.5 hidden flex items-center gap-1">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                            <span class="warning-text"></span>
                        </div>
                    </div>

                    <div class="w-full sm:w-28">
                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">
                            Jumlah (Qty)
                        </label>
                        <input type="number" name="items[${itemIndex}][quantity]" value="${qty}" min="1" required
                            class="qty-input w-full text-xs text-center font-bold text-slate-900 bg-slate-50 border border-slate-200 rounded-xl py-2 px-2 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                    </div>

                    <div class="w-full sm:w-36 text-left sm:text-right">
                        <span class="block text-[11px] font-bold text-slate-600 uppercase mb-1">
                            Subtotal
                        </span>
                        <div class="subtotal-text font-mono text-sm font-black text-indigo-700 py-1">
                            Rp 0
                        </div>
                        <div class="unit-price-text text-[10px] text-slate-400 font-mono">
                            @ Rp 0
                        </div>
                    </div>

                    <div class="shrink-0 self-end sm:self-center pt-1 sm:pt-4">
                        <button type="button" class="remove-btn p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition" title="Hapus Produk">
                            <i class="fa-solid fa-trash-can text-sm"></i>
                        </button>
                    </div>
                </div>
            `;

            container.appendChild(itemCard);

            const select = itemCard.querySelector('.product-select');
            const qtyInput = itemCard.querySelector('.qty-input');
            const removeBtn = itemCard.querySelector('.remove-btn');

            select.addEventListener('change', () => calculateRow(itemCard));
            qtyInput.addEventListener('input', () => calculateRow(itemCard));
            removeBtn.addEventListener('click', function() {
                if (document.querySelectorAll('.item-row').length > 1) {
                    itemCard.remove();
                    calculateGrandTotal();
                } else {
                    alert('Transaksi minimal membutuhkan 1 produk.');
                }
            });

            calculateRow(itemCard);
            itemIndex++;
        }

        function calculateRow(card) {
            const select = card.querySelector('.product-select');
            const qtyInput = card.querySelector('.qty-input');
            const stockWarning = card.querySelector('.stock-warning');
            const warningText = card.querySelector('.warning-text');
            const opt = select.options[select.selectedIndex];

            let price = 0;
            let maxStock = 0;

            if (opt && opt.dataset.price) {
                price = parseFloat(opt.dataset.price);
                maxStock = parseInt(opt.dataset.stock) || 0;
            }

            // Update foto thumbnail produk
            const foundProduct = productsCatalog.find(p => p.id == select.value);
            const thumbImg = card.querySelector('.product-thumb');
            if (foundProduct && thumbImg) {
                thumbImg.src = foundProduct.image_url || 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=200&auto=format&fit=crop&q=80';
            }

            const qty = parseInt(qtyInput.value) || 0;

            if (opt && opt.value && qty > maxStock) {
                warningText.innerText = `Melebihi stok gudang (${maxStock} unit)!`;
                stockWarning.classList.remove('hidden');
                qtyInput.classList.add('border-rose-500', 'bg-rose-50');
            } else {
                stockWarning.classList.add('hidden');
                qtyInput.classList.remove('border-rose-500', 'bg-rose-50');
            }

            const subtotal = qty * price;
            card.querySelector('.unit-price-text').innerText = '@ Rp ' + price.toLocaleString('id-ID');
            card.querySelector('.subtotal-text').innerText = 'Rp ' + subtotal.toLocaleString('id-ID');

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

        document.getElementById('addItemBtn').addEventListener('click', () => createSaleItem());

        document.addEventListener('DOMContentLoaded', () => {
            createSaleItem();
        });
    </script>
</x-app-layout>

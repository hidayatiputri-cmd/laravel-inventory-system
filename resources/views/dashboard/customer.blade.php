<x-app-layout>
    <x-slot name="header">
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-amber-500 via-rose-500 to-rose-600 p-6 sm:p-7 text-white shadow-lg shadow-rose-500/20">
            <div class="relative z-10 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-0.5 text-[10px] font-black uppercase rounded-full bg-white/20 backdrop-blur-md text-white tracking-wider border border-white/20">
                            Customer Storefront
                        </span>
                        <span class="text-xs text-amber-100">&bull;</span>
                        <span class="text-xs text-amber-100 font-medium">Official Retail Store</span>
                    </div>
                    <h2 class="font-black text-2xl sm:text-3xl text-white leading-tight mt-1 tracking-tight">
                        Hai Customer! Selamat Datang di GoShopping
                    </h2>
                    <p class="text-xs sm:text-sm text-amber-100 mt-1 max-w-xl">
                        Jelajahi berbagai pilihan produk berkualitas dengan jaminan ketersediaan stok fisik real-time langsung dari gudang.
                    </p>
                </div>
                <!-- Total Belanja Badge Card -->
                <div class="bg-white/20 backdrop-blur-md border border-white/30 rounded-2xl p-3 px-5 shadow-sm flex items-center gap-3 shrink-0">
                    <div class="w-10 h-10 rounded-xl bg-white text-rose-600 flex items-center justify-center shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-[10px] text-amber-100 block uppercase font-bold tracking-wider">Total Belanjaan Anda</span>
                        <span class="text-base sm:text-lg font-black font-mono text-white">Rp {{ number_format($totalSpent, 0, ',', '.') }}</span>
                        <span class="text-[11px] text-amber-100 block">({{ $orderCount }} pesanan sukses)</span>
                    </div>
                </div>
            </div>
            <!-- Glow background orb -->
            <div class="absolute -right-6 -bottom-6 w-48 h-48 bg-white/10 rounded-full blur-2xl"></div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <x-alert />

            <!-- 1. Hero Promo Banner (Tema Cerah Amber & Rose) -->
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-amber-500 via-rose-500 to-pink-600 p-8 sm:p-10 text-white shadow-xl shadow-rose-500/20">
                <div class="relative z-10 max-w-2xl">
                    <span class="inline-flex items-center gap-1.5 px-3.5 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-black uppercase tracking-wider mb-3">
                        <span class="w-2 h-2 rounded-full bg-amber-300 animate-ping"></span>
                        Promo Spesial GoShopping
                    </span>
                    <h1 class="text-3xl font-black tracking-tight sm:text-4xl text-white drop-shadow-sm">
                        Belanja Mudah, Cepat, dan Stok Pasti Ready!
                    </h1>
                    <p class="mt-2.5 text-xs sm:text-sm text-rose-100 leading-relaxed max-w-xl">
                        Dapatkan produk terbaik mulai dari Elektronik, Fashion terbaru, hingga Makanan & Minuman dengan harga terbaik langsung dari distributor utama.
                    </p>
                </div>
                <!-- Glowing Abstract Circles -->
                <div class="absolute -right-8 -bottom-8 w-60 h-60 bg-amber-300/30 rounded-full blur-2xl"></div>
                <div class="absolute right-40 -top-10 w-48 h-48 bg-white/20 rounded-full blur-xl"></div>
            </div>

            <!-- 2. Pencarian & Filter Kategori (E-Commerce Style Filter Bar) -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">
                <div class="flex flex-col md:flex-row justify-between items-stretch md:items-center gap-4">
                    <!-- Kategori Pills -->
                    <div class="flex items-center gap-2 overflow-x-auto pb-2 md:pb-0 text-xs font-bold">
                        <a href="{{ route('dashboard') }}" class="px-4 py-2.5 rounded-2xl transition whitespace-nowrap {{ empty($categorySlug) ? 'bg-gradient-to-r from-rose-500 to-pink-600 text-white shadow-md shadow-rose-500/25' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            Semua Produk
                        </a>
                        @foreach ($categories as $cat)
                            <a href="{{ route('dashboard', ['category' => $cat->slug, 'search' => $search]) }}" class="px-4 py-2.5 rounded-2xl transition whitespace-nowrap {{ $categorySlug === $cat->slug ? 'bg-gradient-to-r from-rose-500 to-pink-600 text-white shadow-md shadow-rose-500/25' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                                {{ $cat->name }} ({{ $cat->products_count }})
                            </a>
                        @endforeach
                    </div>

                    <!-- Search Input -->
                    <form method="GET" action="{{ route('dashboard') }}" class="flex gap-2 shrink-0">
                        @if ($categorySlug)<input type="hidden" name="category" value="{{ $categorySlug }}">@endif
                        <div class="relative w-full sm:w-64">
                            <span class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </span>
                            <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama barang..." class="w-full ps-9 pe-3 py-2 text-xs rounded-xl border-slate-200 focus:border-rose-500 focus:ring-rose-500">
                        </div>
                        <button type="submit" class="px-4 py-2 bg-gradient-to-r from-amber-500 to-rose-500 hover:from-amber-600 hover:to-rose-600 text-white text-xs font-bold rounded-xl shadow-sm transition">
                            Cari
                        </button>
                        @if ($search || $categorySlug)
                            <a href="{{ route('dashboard') }}" class="px-3 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-bold rounded-xl transition" title="Bersihkan Filter">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            <!-- 3. Grid Katalog Produk (Modern E-Commerce Cards dengan Warna Cerah Amber/Rose) -->
            <div>
                <div class="flex justify-between items-center mb-5">
                    <div>
                        <h3 class="text-xl font-black text-slate-900 tracking-tight">
                            {{ $categorySlug ? 'Koleksi Kategori: ' . ucwords(str_replace('-', ' ', $categorySlug)) : 'Katalog Pilihan Terlaris' }}
                        </h3>
                        <p class="text-xs text-slate-500">Produk bergaransi toko, siap dipesan melalui kasir GoShopping</p>
                    </div>
                    <span class="text-xs font-bold bg-rose-50 text-rose-600 px-3 py-1 rounded-full border border-rose-100">
                        {{ $catalogProducts->count() }} produk tersedia
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @forelse ($catalogProducts as $prod)
                        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 overflow-hidden flex flex-col justify-between group">
                            <!-- Visual Foto Produk HD Unsplash -->
                            <div class="relative h-48 bg-slate-100 overflow-hidden">
                                <img src="{{ $prod->image_url }}" alt="{{ $prod->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-80"></div>
                                <div class="absolute top-3 left-3 right-3 flex justify-between items-start">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-white/95 text-rose-700 shadow-md backdrop-blur-md">
                                        {{ $prod->category->name ?? 'Retail' }}
                                    </span>
                                    <span class="inline-flex items-center text-[10px] font-mono font-bold text-white bg-slate-900/80 backdrop-blur-md px-2.5 py-0.5 rounded-full border border-white/20">
                                        <i class="fa-solid fa-box mr-1 text-emerald-400"></i>
                                        Stok: {{ $prod->stock }}
                                    </span>
                                </div>
                                <div class="absolute bottom-2.5 left-3">
                                    <span class="text-[10px] font-mono text-white/80">SKU: {{ $prod->sku }}</span>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="p-5 flex-1 flex flex-col justify-between">
                                <div>
                                    <h4 class="font-black text-slate-900 text-sm group-hover:text-rose-600 transition line-clamp-2 leading-snug">
                                        {{ $prod->name }}
                                    </h4>
                                    <p class="text-xs text-slate-500 mt-1.5 line-clamp-2 leading-relaxed">
                                        {{ $prod->description ?: 'Barang berkualitas original resmi, garansi mutu terjamin oleh GoShopping.' }}
                                    </p>
                                </div>

                                <div class="mt-4 pt-3 border-t border-slate-100">
                                    <div class="flex items-baseline justify-between mb-3">
                                        <div>
                                            <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">Harga Resmi</span>
                                            <span class="text-lg font-black font-mono bg-gradient-to-r from-rose-600 to-amber-600 bg-clip-text text-transparent">
                                                Rp {{ number_format($prod->selling_price, 0, ',', '.') }}
                                            </span>
                                        </div>
                                        <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-lg border border-emerald-100">
                                            &check; Ready
                                        </span>
                                    </div>

                                    <!-- Tombol Beli Sekarang (Membuka Modal Checkout) -->
                                    <button type="button" onclick="openOrderModal({{ $prod->id }}, '{{ addslashes($prod->name) }}', '{{ $prod->sku }}', {{ $prod->selling_price }}, {{ $prod->stock }}, '{{ $prod->image_url }}')"
                                        class="w-full py-2.5 px-3 rounded-xl text-xs font-bold text-white bg-gradient-to-r from-amber-500 via-rose-500 to-rose-600 hover:from-amber-600 hover:to-rose-700 active:scale-95 shadow-md shadow-rose-500/20 transition-all flex items-center justify-center gap-1.5">
                                        <i class="fa-solid fa-cart-shopping text-xs"></i>
                                        <span>Beli Sekarang</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full bg-white rounded-3xl p-12 text-center border border-slate-100 shadow-sm">
                            <div class="w-16 h-16 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center mx-auto mb-3">
                                <i class="fa-solid fa-box-open text-2xl"></i>
                            </div>
                            <h4 class="text-base font-black text-slate-800">Tidak ada produk ditemukan</h4>
                            <p class="text-xs text-slate-400 mt-1">Coba gunakan kata kunci pencarian lain atau pilih kategori yang berbeda.</p>
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
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-black text-slate-900">Riwayat Belanja & Struk Transaksi Anda</h3>
                        <p class="text-xs text-slate-500">Daftar transaksi faktur belanja yang terhubung resmi ke akun GoShopping Anda</p>
                    </div>
                    <span class="text-xs font-bold bg-rose-100 text-rose-700 px-3 py-1 rounded-full">
                        {{ $orderCount }} Transaksi Tercatat
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-gray-600 text-xs uppercase font-semibold">
                            <tr>
                                <th class="px-6 py-3.5 text-left">No. Faktur Invoice</th>
                                <th class="px-6 py-3.5 text-left">Tanggal Belanja</th>
                                <th class="px-6 py-3.5 text-left">Rincian Barang</th>
                                <th class="px-6 py-3.5 text-center">Metode Bayar</th>
                                <th class="px-6 py-3.5 text-right">Total Belanja</th>
                                <th class="px-6 py-3.5 text-center">Status</th>
                                <th class="px-6 py-3.5 text-center">Struk Digital</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($myOrders as $order)
                                <tr class="hover:bg-rose-50/20 transition">
                                    <td class="px-6 py-4 font-mono font-bold text-xs text-slate-800">
                                        <span class="bg-slate-100 px-2 py-0.5 rounded">{{ $order->invoice_number }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-xs text-slate-600">
                                        {{ $order->sale_date->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-xs text-slate-700">
                                        <ul class="space-y-1">
                                            @foreach ($order->items as $item)
                                                <li class="flex items-center gap-2">
                                                    @if ($item->product)
                                                        <img src="{{ $item->product->image_url }}" alt="" class="w-6 h-6 rounded-md object-cover border border-slate-200">
                                                    @endif
                                                    <span class="font-bold text-slate-900">{{ $item->product->name ?? 'Produk' }}</span> 
                                                    <span class="text-slate-500 font-mono">({{ $item->quantity }}x @ Rp {{ number_format($item->unit_price, 0, ',', '.') }})</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase {{ $order->payment_method == 'cash' ? 'bg-emerald-50 text-emerald-700' : 'bg-blue-50 text-blue-700' }}">
                                            {{ $order->payment_method }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right font-mono font-black text-rose-600 text-sm">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-black bg-emerald-100 text-emerald-800">
                                            &check; Lunas
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('orders.receipt', $order) }}" target="_blank" class="inline-flex items-center gap-1 px-3 py-1 bg-slate-100 hover:bg-slate-200 text-slate-800 rounded-xl text-xs font-bold transition">
                                            <i class="fa-solid fa-receipt text-slate-500 text-xs"></i>
                                            <span>Lihat Struk</span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-10 text-center text-slate-400 text-sm">
                                        <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-2">
                                            <i class="fa-solid fa-cart-arrow-down text-lg"></i>
                                        </div>
                                        Anda belum memiliki riwayat pembelian. Silakan jelajahi katalog produk di atas!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($myOrders->hasPages())
                    <div class="p-3 border-t border-slate-100 bg-slate-50">
                        {{ $myOrders->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- 5. Modal Checkout Langsung E-Commerce Storefront -->
    <div id="orderModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl max-w-lg w-full overflow-hidden border border-slate-100 transform transition-all animate-fade-in">
            <!-- Modal Header -->
            <div class="p-6 bg-gradient-to-r from-amber-500 via-rose-500 to-rose-600 text-white flex justify-between items-center">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center">
                        <i class="fa-solid fa-bag-shopping text-base"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-black leading-tight">Konfirmasi Pesanan Langsung</h3>
                        <p class="text-xs text-rose-100">Checkout aman dengan pemotongan stok otomatis</p>
                    </div>
                </div>
                <button type="button" onclick="closeOrderModal()" class="w-8 h-8 rounded-full bg-white/20 hover:bg-white/30 text-white flex items-center justify-center transition">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>

            <!-- Modal Form -->
            <form action="{{ route('orders.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="product_id" id="modalProductId">

                <!-- Detail Produk yang Dipesan -->
                <div class="flex items-center gap-4 p-3 bg-slate-50 rounded-2xl border border-slate-200">
                    <img id="modalProductImg" src="" alt="Produk" class="w-16 h-16 rounded-xl object-cover border border-slate-200 shrink-0">
                    <div class="flex-1 min-w-0">
                        <span id="modalProductSku" class="text-[10px] font-mono text-slate-400 block font-bold"></span>
                        <h4 id="modalProductName" class="text-sm font-black text-slate-900 truncate"></h4>
                        <div class="text-xs font-mono font-bold text-rose-600 mt-0.5">
                            Rp <span id="modalProductPrice"></span> / unit
                        </div>
                    </div>
                </div>

                <!-- Input Kuantitas Jumlah Barang -->
                <div>
                    <label for="modalQuantity" class="block text-xs font-bold text-slate-700 mb-1 flex justify-between">
                        <span>Jumlah Pesanan (Qty)</span>
                        <span class="text-slate-400 font-normal">Stok tersedia: <strong id="modalProductStock" class="text-slate-800"></strong></span>
                    </label>
                    <div class="flex items-center gap-3">
                        <input type="number" name="quantity" id="modalQuantity" min="1" value="1" required
                            class="w-full text-sm font-bold text-center rounded-xl border-slate-300 focus:border-rose-500 focus:ring-rose-500">
                    </div>
                </div>

                <!-- Pilihan Metode Pembayaran -->
                <div>
                    <label for="modalPaymentMethod" class="block text-xs font-bold text-slate-700 mb-1">
                        Metode Pembayaran
                    </label>
                    <select name="payment_method" id="modalPaymentMethod" required class="w-full text-xs rounded-xl border-slate-300 focus:border-rose-500 focus:ring-rose-500">
                        <option value="qris">QRIS (Gopay / OVO / Dana / BCA)</option>
                        <option value="transfer">Transfer Virtual Account Bank</option>
                        <option value="cash">Bayar Tunai di Kasir Toko</option>
                        <option value="credit_card">Kartu Kredit / Debit</option>
                    </select>
                </div>

                <!-- Alamat / Catatan Pengiriman -->
                <div>
                    <label for="modalNotes" class="block text-xs font-bold text-slate-700 mb-1">
                        Alamat Pengiriman / Catatan Pesanan
                    </label>
                    <textarea name="notes" id="modalNotes" rows="2" placeholder="Masukkan alamat lengkap pengiriman atau catatan khusus..."
                        class="w-full text-xs rounded-xl border-slate-300 focus:border-rose-500 focus:ring-rose-500"></textarea>
                </div>

                <!-- Total Tagihan -->
                <div class="p-3.5 rounded-2xl bg-rose-50 border border-rose-100 flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-700">Total Pembayaran:</span>
                    <span class="text-xl font-black font-mono text-rose-600">
                        Rp <span id="modalTotalAmount">0</span>
                    </span>
                </div>

                <!-- Actions -->
                <div class="flex items-center gap-3 pt-2">
                    <button type="button" onclick="closeOrderModal()" class="w-1/3 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition">
                        Batal
                    </button>
                    <button type="submit" class="w-2/3 py-2.5 bg-gradient-to-r from-rose-500 to-amber-500 hover:from-rose-600 hover:to-amber-600 text-white text-xs font-black rounded-xl shadow-md transition active:scale-95 flex items-center justify-center gap-1.5">
                        <i class="fa-solid fa-lock text-xs"></i>
                        <span>Konfirmasi & Bayar</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script Modal Checkout E-Commerce -->
    <script>
        let currentModalPrice = 0;
        let currentModalStock = 0;

        function openOrderModal(id, name, sku, price, stock, img) {
            currentModalPrice = price;
            currentModalStock = stock;

            document.getElementById('modalProductId').value = id;
            document.getElementById('modalProductName').innerText = name;
            document.getElementById('modalProductSku').innerText = 'SKU: ' + sku;
            document.getElementById('modalProductPrice').innerText = Number(price).toLocaleString('id-ID');
            document.getElementById('modalProductStock').innerText = stock + ' unit';
            document.getElementById('modalProductImg').src = img;

            const qtyInput = document.getElementById('modalQuantity');
            qtyInput.value = 1;
            qtyInput.max = stock;

            updateModalTotal();

            document.getElementById('orderModal').classList.remove('hidden');
        }

        function closeOrderModal() {
            document.getElementById('orderModal').classList.add('hidden');
        }

        function updateModalTotal() {
            const qty = parseInt(document.getElementById('modalQuantity').value) || 1;
            const total = qty * currentModalPrice;
            document.getElementById('modalTotalAmount').innerText = Number(total).toLocaleString('id-ID');
        }

        document.getElementById('modalQuantity').addEventListener('input', updateModalTotal);
    </script>
</x-app-layout>

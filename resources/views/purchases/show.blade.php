<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Faktur Pembelian') }} #{{ $purchase->reference_number }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Dicatat pada: {{ $purchase->created_at->format('d M Y H:i') }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('purchases.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium rounded-lg transition">
                    &larr; Kembali ke Daftar
                </a>
                <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-gray-800 hover:bg-gray-900 text-white text-sm font-medium rounded-lg transition">
                    <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                <!-- Invoice Header -->
                <div class="flex justify-between items-start pb-8 border-b border-gray-100">
                    <div>
                        <span class="text-xs uppercase tracking-wider font-semibold text-indigo-600">Purchase Order</span>
                        <h3 class="text-2xl font-bold font-mono text-gray-900 mt-1">{{ $purchase->reference_number }}</h3>
                        <p class="text-xs text-gray-500 mt-1">Tanggal: {{ $purchase->purchase_date->format('d F Y') }}</p>
                        <div class="mt-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                Selesai / Masuk Gudang
                            </span>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-xs font-semibold text-gray-400 uppercase">Pemasok / Supplier</span>
                        <h4 class="text-lg font-bold text-gray-800 mt-1">{{ $purchase->supplier->name ?? 'Supplier Dihapus' }}</h4>
                        <p class="text-xs text-gray-600 mt-0.5">{{ $purchase->supplier->phone ?? '-' }}</p>
                        <p class="text-xs text-gray-600">{{ $purchase->supplier->email ?? '-' }}</p>
                        <p class="text-xs text-gray-500 mt-1 max-w-xs">{{ $purchase->supplier->address ?? '-' }}</p>
                    </div>
                </div>

                <!-- Petugas & Catatan -->
                <div class="py-4 border-b border-gray-100 flex flex-wrap justify-between text-xs text-gray-500">
                    <div>
                        <span>Petugas Penerima: </span>
                        <strong class="text-gray-700">{{ $purchase->user->name ?? 'Sistem' }} ({{ $purchase->user->role ?? '-' }})</strong>
                    </div>
                    @if ($purchase->notes)
                        <div class="mt-2 sm:mt-0">
                            <span>Catatan: </span>
                            <span class="italic text-gray-700">{{ $purchase->notes }}</span>
                        </div>
                    @endif
                </div>

                <!-- Table Items -->
                <div class="overflow-x-auto my-6">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-gray-600 text-xs uppercase font-semibold">
                            <tr>
                                <th class="px-4 py-3 text-left">No</th>
                                <th class="px-4 py-3 text-left">Deskripsi Produk</th>
                                <th class="px-4 py-3 text-left">SKU</th>
                                <th class="px-4 py-3 text-center">Qty</th>
                                <th class="px-4 py-3 text-right">Harga Beli</th>
                                <th class="px-4 py-3 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($purchase->items as $index => $item)
                                <tr>
                                    <td class="px-4 py-3 text-gray-400 text-xs">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3 font-medium text-gray-800">
                                        {{ $item->product->name ?? 'Produk Dihapus' }}
                                    </td>
                                    <td class="px-4 py-3 font-mono text-xs text-gray-500">
                                        {{ $item->product->sku ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-center font-semibold text-gray-700">
                                        {{ $item->quantity }}
                                    </td>
                                    <td class="px-4 py-3 text-right font-mono text-xs text-gray-600">
                                        Rp {{ number_format($item->unit_price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-right font-mono font-semibold text-gray-900">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="border-t-2 border-gray-200 bg-gray-50">
                                <td colspan="5" class="px-4 py-3 text-right font-bold text-gray-700">
                                    Total Pembayaran:
                                </td>
                                <td class="px-4 py-3 text-right font-mono font-bold text-lg text-gray-900">
                                    Rp {{ number_format($purchase->total_amount, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

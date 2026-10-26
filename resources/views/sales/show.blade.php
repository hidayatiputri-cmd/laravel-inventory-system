<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Struk Penjualan') }} #{{ $sale->invoice_number }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Dicatat pada: {{ $sale->created_at->format('d M Y H:i') }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('sales.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium rounded-lg transition">
                    &larr; Kembali ke Daftar
                </a>
                <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg transition">
                    <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak Struk
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                <!-- Struk Header -->
                <div class="flex justify-between items-start pb-8 border-b border-gray-100">
                    <div>
                        <span class="text-xs uppercase tracking-wider font-semibold text-emerald-600">Bukti Pembayaran / Struk</span>
                        <h3 class="text-2xl font-bold font-mono text-gray-900 mt-1">{{ $sale->invoice_number }}</h3>
                        <p class="text-xs text-gray-500 mt-1">Tanggal: {{ $sale->sale_date->format('d F Y') }}</p>
                        <div class="mt-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                Lunas ({{ strtoupper($sale->payment_method) }})
                            </span>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-xs font-semibold text-gray-400 uppercase">Pelanggan</span>
                        <h4 class="text-lg font-bold text-gray-800 mt-1">{{ $sale->user->name ?? 'Pelanggan Umum' }}</h4>
                        @if ($sale->user && $sale->user->email)
                            <p class="text-xs text-gray-500">{{ $sale->user->email }}</p>
                        @endif
                    </div>
                </div>

                @if ($sale->notes)
                    <div class="py-3 border-b border-gray-100 text-xs text-gray-600">
                        <span class="font-medium text-gray-500">Catatan:</span> {{ $sale->notes }}
                    </div>
                @endif

                <!-- Items Table -->
                <div class="overflow-x-auto my-6">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-gray-600 text-xs uppercase font-semibold">
                            <tr>
                                <th class="px-4 py-3 text-left">No</th>
                                <th class="px-4 py-3 text-left">Produk</th>
                                <th class="px-4 py-3 text-left">Kategori</th>
                                <th class="px-4 py-3 text-center">Qty</th>
                                <th class="px-4 py-3 text-right">Harga</th>
                                <th class="px-4 py-3 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($sale->items as $index => $item)
                                <tr>
                                    <td class="px-4 py-3 text-gray-400 text-xs">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3 font-medium text-gray-800">
                                        {{ $item->product->name ?? 'Produk Dihapus' }}
                                        <div class="font-mono text-xs text-gray-400">{{ $item->product->sku ?? '' }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-xs text-gray-500">
                                        {{ $item->product->category->name ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-center font-bold text-gray-800">
                                        {{ $item->quantity }}
                                    </td>
                                    <td class="px-4 py-3 text-right font-mono text-xs text-gray-600">
                                        Rp {{ number_format($item->unit_price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-right font-mono font-bold text-gray-900">
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
                                <td class="px-4 py-3 text-right font-mono font-extrabold text-xl text-emerald-600">
                                    Rp {{ number_format($sale->total_amount, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

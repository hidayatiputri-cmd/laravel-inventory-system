<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SaleController extends Controller
{
    /**
     * Display a listing of sales transactions with search and pagination.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');

        $sales = Sale::query()
            ->with(['user', 'items.product'])
            ->when($search, function ($query, $search) {
                $query->where('invoice_number', 'like', "%{$search}%")
                      ->orWhereHas('user', function ($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      });
            })
            ->latest('sale_date')
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('sales.index', compact('sales', 'search'));
    }

    /**
     * Show the form for creating a new sale transaction.
     */
    public function create(): View
    {
        $customers = User::where('role', 'customer')->orderBy('name')->get();
        $products = Product::where('stock', '>', 0)
            ->with('category')
            ->orderBy('name')
            ->get()
            ->each(function ($p) {
                $p->append('image_url');
            });

        return view('sales.create', compact('customers', 'products'));
    }

    /**
     * Store a newly created sale in storage.
     * Aturan bisnis:
     * - Gunakan DB::transaction() agar transaksi atomik.
     * - Amankan stok pakai Product::lockForUpdate() untuk mencegah race condition.
     * - Hitung total harga & subtotal langsung di server-side (mengambil selling_price asli produk).
     * - Tolak transaksi dengan pesan error jika stok tidak mencukupi.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'sale_date' => 'required|date',
            'payment_method' => 'required|string|in:cash,transfer,qris,credit_card',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ], [
            'sale_date.required' => 'Tanggal penjualan wajib diisi.',
            'payment_method.required' => 'Metode pembayaran wajib dipilih.',
            'items.required' => 'Minimal harus ada 1 barang dalam transaksi.',
            'items.*.product_id.required' => 'Produk wajib dipilih.',
            'items.*.quantity.min' => 'Jumlah beli minimal 1 unit.',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                // Generate nomor faktur/invoice otomatis
                $invoiceNumber = 'INV-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(3)));

                $totalAmount = 0;
                $processedItems = [];

                // Validasi dan kurangi stok dengan lockForUpdate
                foreach ($validated['items'] as $itemData) {
                    $productId = $itemData['product_id'];
                    $qty = (int) $itemData['quantity'];

                    // Kunci baris data produk selama transaksi berlangsung
                    $product = Product::where('id', $productId)->lockForUpdate()->firstOrFail();

                    // Tolak transaksi jika stok tidak mencukupi
                    if ($product->stock < $qty) {
                        throw new Exception("Stok untuk produk '{$product->name}' (SKU: {$product->sku}) tidak mencukupi! Tersisa: {$product->stock} unit, diminta: {$qty} unit.");
                    }

                    // Ambil harga jual dari data produk asli di server (menghindari manipulasi client-side)
                    $unitPrice = (float) $product->selling_price;
                    $subtotal = $qty * $unitPrice;
                    $totalAmount += $subtotal;

                    // Kurangi stok barang
                    $product->stock -= $qty;
                    $product->save();

                    $processedItems[] = [
                        'product_id' => $product->id,
                        'quantity' => $qty,
                        'unit_price' => $unitPrice,
                        'subtotal' => $subtotal,
                    ];
                }

                // Buat record Sale
                $sale = Sale::create([
                    'invoice_number' => $invoiceNumber,
                    'user_id' => $validated['user_id'] ?? null,
                    'sale_date' => $validated['sale_date'],
                    'total_amount' => $totalAmount,
                    'payment_method' => $validated['payment_method'],
                    'status' => 'completed',
                    'notes' => $validated['notes'] ?? null,
                ]);

                // Simpan item-item transaksi penjualan
                foreach ($processedItems as $item) {
                    $sale->items()->create($item);
                }
            });

            return redirect()
                ->route('sales.index')
                ->with('success', 'Transaksi penjualan berhasil diproses dan stok produk telah diperbarui!');
        } catch (Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified sale transaction details.
     */
    public function show(Sale $sale): View
    {
        $sale->load(['user', 'items.product.category']);

        return view('sales.show', compact('sale'));
    }

    /**
     * Update order / transaction status (completed, pending, cancelled).
     */
    public function updateStatus(Request $request, Sale $sale): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|string|in:completed,pending,cancelled',
        ]);

        $sale->update(['status' => $validated['status']]);

        return back()->with('success', "Status transaksi #{$sale->invoice_number} berhasil diubah menjadi " . strtoupper($validated['status']) . '!');
    }
}

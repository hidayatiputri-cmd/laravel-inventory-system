<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PurchaseController extends Controller
{
    /**
     * Display a listing of purchases with search and pagination.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');

        $purchases = Purchase::query()
            ->with(['supplier', 'user', 'items.product'])
            ->when($search, function ($query, $search) {
                $query->where('reference_number', 'like', "%{$search}%")
                      ->orWhereHas('supplier', function ($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      });
            })
            ->latest('purchase_date')
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('purchases.index', compact('purchases', 'search'));
    }

    /**
     * Show the form for creating a new purchase transaction.
     */
    public function create(): View
    {
        $suppliers = Supplier::orderBy('name')->get();
        $products = Product::orderBy('name')->get();

        return view('purchases.create', compact('suppliers', 'products'));
    }

    /**
     * Store a newly created purchase in storage.
     * Menggunakan DB::transaction() dan lockForUpdate() untuk pembaruan stok & harga beli.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_date' => 'required|date',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ], [
            'supplier_id.required' => 'Supplier wajib dipilih.',
            'purchase_date.required' => 'Tanggal pembelian wajib diisi.',
            'items.required' => 'Minimal harus ada 1 barang yang dibeli.',
            'items.*.product_id.required' => 'Produk wajib dipilih.',
            'items.*.quantity.min' => 'Jumlah kuantitas minimal 1 unit.',
            'items.*.unit_price.min' => 'Harga beli satuan tidak boleh bernilai negatif.',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                // Generate nomor referensi otomatis jika belum ada
                $referenceNumber = 'PO-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(3)));

                // Hitung total di sisi server
                $totalAmount = 0;
                $processedItems = [];

                foreach ($validated['items'] as $itemData) {
                    // Lock record produk untuk pembaruan stok yang aman
                    $product = Product::where('id', $itemData['product_id'])->lockForUpdate()->firstOrFail();

                    $qty = (int) $itemData['quantity'];
                    $unitPrice = (float) $itemData['unit_price'];
                    $subtotal = $qty * $unitPrice;
                    $totalAmount += $subtotal;

                    // Tambahkan stok produk dan perbarui purchase_price terbaru
                    $product->stock += $qty;
                    $product->purchase_price = $unitPrice;
                    $product->save();

                    $processedItems[] = [
                        'product_id' => $product->id,
                        'quantity' => $qty,
                        'unit_price' => $unitPrice,
                        'subtotal' => $subtotal,
                    ];
                }

                // Simpan data master purchase
                $purchase = Purchase::create([
                    'reference_number' => $referenceNumber,
                    'supplier_id' => $validated['supplier_id'],
                    'user_id' => Auth::id(),
                    'purchase_date' => $validated['purchase_date'],
                    'total_amount' => $totalAmount,
                    'status' => 'completed',
                    'notes' => $validated['notes'] ?? null,
                ]);

                // Simpan item-item pembelian
                foreach ($processedItems as $item) {
                    $purchase->items()->create($item);
                }
            });

            return redirect()
                ->route('purchases.index')
                ->with('success', 'Transaksi pembelian berhasil disimpan dan stok produk telah ditambahkan!');
        } catch (Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memproses transaksi pembelian: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified purchase details.
     */
    public function show(Purchase $purchase): View
    {
        $purchase->load(['supplier', 'user', 'items.product']);

        return view('purchases.show', compact('purchase'));
    }
}

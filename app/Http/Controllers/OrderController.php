<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Memproses pesanan langsung dari Customer Storefront.
     * Aturan:
     * - DB::transaction() agar pesanan atomik.
     * - lockForUpdate() pada produk agar stok tidak minus.
     * - Status pesanan otomatis completed.
     * - Kurangi stok fisik produk secara real-time.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'payment_method' => 'required|string|in:qris,transfer,cash,credit_card',
            'notes' => 'nullable|string|max:500',
        ], [
            'product_id.required' => 'Pilih produk yang ingin dibeli.',
            'quantity.min' => 'Jumlah pesanan minimal 1 unit.',
            'payment_method.required' => 'Pilih metode pembayaran.',
        ]);

        try {
            $invoiceNumber = '';

            DB::transaction(function () use ($validated, &$invoiceNumber) {
                $user = Auth::user();
                $product = Product::where('id', $validated['product_id'])->lockForUpdate()->firstOrFail();

                $qty = (int) $validated['quantity'];

                if ($product->stock < $qty) {
                    throw new Exception("Maaf, stok '{$product->name}' tersisa {$product->stock} unit. Jumlah pesanan Anda ({$qty}) melebihi ketersediaan.");
                }

                $unitPrice = (float) $product->selling_price;
                $totalAmount = $qty * $unitPrice;

                // Kurangi stok fisik produk
                $product->stock -= $qty;
                $product->save();

                // Generate invoice resmi
                $invoiceNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(3)));

                $sale = Sale::create([
                    'invoice_number' => $invoiceNumber,
                    'user_id' => $user->id,
                    'sale_date' => now()->toDateString(),
                    'total_amount' => $totalAmount,
                    'payment_method' => $validated['payment_method'],
                    'status' => 'completed',
                    'notes' => $validated['notes'] ?? 'Pesanan online customer storefront',
                ]);

                $sale->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'unit_price' => $unitPrice,
                    'subtotal' => $totalAmount,
                ]);
            });

            return redirect()
                ->route('dashboard')
                ->with('success', "Pesanan #{$invoiceNumber} berhasil dikonfirmasi! Stok produk telah diperbarui dan struk belanja Anda telah diterbitkan.");
        } catch (Exception $e) {
            return back()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Tampilkan struk digital belanja khusus customer.
     */
    public function receipt(Sale $sale): View
    {
        $user = Auth::user();

        // Customer hanya boleh melihat struk miliknya sendiri, kecuali admin/staff
        if ($user->role === 'customer' && $sale->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat struk ini.');
        }

        $sale->load(['user', 'items.product.category']);

        return view('sales.show', compact('sale'));
    }
}

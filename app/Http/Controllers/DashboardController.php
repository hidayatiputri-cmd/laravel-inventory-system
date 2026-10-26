<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the main inventory dashboard with metrics, low stock alert,
     * product catalog search, and transactions table with date filtering.
     */
    public function index(Request $request): View
    {
        // 1. KPI Metrik Utama
        $totalProducts = Product::count();
        $totalSalesCount = Sale::count();
        $totalSalesRevenue = Sale::sum('total_amount');
        $totalPurchasesCount = Purchase::count();
        $totalPurchasesAmount = Purchase::sum('total_amount');

        // 2. Daftar Produk Stok Rendah (stock <= minimum_stock)
        $lowStockProducts = Product::query()
            ->with('category')
            ->whereColumn('stock', '<=', 'minimum_stock')
            ->orderBy('stock', 'asc')
            ->get();

        $lowStockCount = $lowStockProducts->count();

        // 3. Pencarian Cepat Produk (SKU / Nama / Kategori) dengan Pagination
        $productSearch = $request->query('product_search');
        $products = Product::query()
            ->with('category')
            ->when($productSearch, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('sku', 'like', "%{$search}%");
                });
            })
            ->latest('id')
            ->paginate(5, ['*'], 'products_page')
            ->withQueryString();

        // 4. Tabel Transaksi Penjualan dengan Filter Tanggal & No Invoice/Customer dengan Pagination
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $trxSearch = $request->query('trx_search');

        $salesTransactions = Sale::query()
            ->with(['user', 'items.product'])
            ->when($startDate, function ($query, $date) {
                $query->whereDate('sale_date', '>=', $date);
            })
            ->when($endDate, function ($query, $date) {
                $query->whereDate('sale_date', '<=', $date);
            })
            ->when($trxSearch, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('invoice_number', 'like', "%{$search}%")
                      ->orWhereHas('user', function ($sub) use ($search) {
                          $sub->where('name', 'like', "%{$search}%");
                      });
                });
            })
            ->latest('sale_date')
            ->latest('id')
            ->paginate(6, ['*'], 'sales_page')
            ->withQueryString();

        return view('dashboard', compact(
            'totalProducts',
            'totalSalesCount',
            'totalSalesRevenue',
            'totalPurchasesCount',
            'totalPurchasesAmount',
            'lowStockProducts',
            'lowStockCount',
            'products',
            'productSearch',
            'salesTransactions',
            'startDate',
            'endDate',
            'trxSearch'
        ));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Render dashboard disesuaikan per role pengguna (Admin, Staff, Customer).
     */
    public function index(Request $request): View
    {
        $user = Auth::user();

        // 1. DASHBOARD KHUSUS CUSTOMER (Online Shop Shopping & Order History)
        if ($user->role === 'customer') {
            $categorySlug = $request->query('category');
            $search = $request->query('search');

            // Kategori untuk navigasi filter katalog
            $categories = Category::withCount('products')->get();

            // Katalog produk yang tersedia untuk dibeli oleh customer
            $catalogProducts = Product::query()
                ->with('category')
                ->where('stock', '>', 0)
                ->when($categorySlug, function ($q, $slug) {
                    $q->whereHas('category', function ($sub) use ($slug) {
                        $sub->where('slug', $slug);
                    });
                })
                ->when($search, function ($q, $keyword) {
                    $q->where(function ($sub) use ($keyword) {
                        $sub->where('name', 'like', "%{$keyword}%")
                            ->orWhere('description', 'like', "%{$keyword}%");
                    });
                })
                ->latest('id')
                ->paginate(8, ['*'], 'catalog_page')
                ->withQueryString();

            // Riwayat transaksi belanja khusus milik customer yang sedang login
            $myOrders = Sale::query()
                ->with(['items.product'])
                ->where('user_id', $user->id)
                ->latest('sale_date')
                ->latest('id')
                ->paginate(5, ['*'], 'orders_page')
                ->withQueryString();

            $totalSpent = Sale::where('user_id', $user->id)->sum('total_amount');
            $orderCount = Sale::where('user_id', $user->id)->count();

            return view('dashboard.customer', compact(
                'user',
                'categories',
                'catalogProducts',
                'myOrders',
                'totalSpent',
                'orderCount',
                'categorySlug',
                'search'
            ));
        }

        // 2. DASHBOARD KHUSUS STAFF (Fokus Operasional Gudang, Kasir, Restock, & Cek Stok Cepat)
        if ($user->role === 'staff') {
            $totalProducts = Product::count();
            $availableStockSum = Product::sum('stock');
            $lowStockProducts = Product::with('category')
                ->whereColumn('stock', '<=', 'minimum_stock')
                ->orderBy('stock', 'asc')
                ->get();
            $lowStockCount = $lowStockProducts->count();

            // Pencarian Cepat Produk / Update Stok Cepat
            $productSearch = $request->query('product_search');
            $products = Product::query()
                ->with('category')
                ->when($productSearch, function ($query, $search) {
                    $query->where('name', 'like', "%{$search}%")
                          ->orWhere('sku', 'like', "%{$search}%");
                })
                ->latest('id')
                ->paginate(6, ['*'], 'products_page')
                ->withQueryString();

            // Transaksi Kasir / Penjualan Hari Ini & Terkini
            $todaySalesCount = Sale::whereDate('sale_date', now()->toDateString())->count();
            $todayPurchasesCount = Purchase::whereDate('purchase_date', now()->toDateString())->count();

            $recentSales = Sale::with(['user', 'items.product'])
                ->latest('sale_date')
                ->latest('id')
                ->limit(5)
                ->get();

            $recentPurchases = Purchase::with(['supplier', 'items.product'])
                ->latest('purchase_date')
                ->latest('id')
                ->limit(5)
                ->get();

            return view('dashboard.staff', compact(
                'user',
                'totalProducts',
                'availableStockSum',
                'lowStockProducts',
                'lowStockCount',
                'products',
                'productSearch',
                'todaySalesCount',
                'todayPurchasesCount',
                'recentSales',
                'recentPurchases'
            ));
        }

        // 3. DASHBOARD KHUSUS ADMIN (Statistik Lengkap Finansial, Supplier, Master Data, & Analisis)
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalSuppliers = Supplier::count();
        $totalCustomers = User::where('role', 'customer')->count();

        $totalSalesCount = Sale::count();
        $totalSalesRevenue = Sale::sum('total_amount');
        $totalPurchasesCount = Purchase::count();
        $totalPurchasesAmount = Purchase::sum('total_amount');

        // Net Profit Estimate: Total Pendapatan Penjualan - Total Pengeluaran Pembelian
        $grossProfit = $totalSalesRevenue - $totalPurchasesAmount;

        // Low stock alert list
        $lowStockProducts = Product::with('category')
            ->whereColumn('stock', '<=', 'minimum_stock')
            ->orderBy('stock', 'asc')
            ->get();
        $lowStockCount = $lowStockProducts->count();

        // Pencarian Produk SKU / Nama
        $productSearch = $request->query('product_search');
        $products = Product::query()
            ->with('category')
            ->when($productSearch, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('sku', 'like', "%{$search}%");
            })
            ->latest('id')
            ->paginate(5, ['*'], 'products_page')
            ->withQueryString();

        // Filter Transaksi dengan Rentang Tanggal
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
                $query->where('invoice_number', 'like', "%{$search}%")
                      ->orWhereHas('user', function ($sub) use ($search) {
                          $sub->where('name', 'like', "%{$search}%");
                      });
            })
            ->latest('sale_date')
            ->latest('id')
            ->paginate(6, ['*'], 'sales_page')
            ->withQueryString();

        return view('dashboard.admin', compact(
            'user',
            'totalProducts',
            'totalCategories',
            'totalSuppliers',
            'totalCustomers',
            'totalSalesCount',
            'totalSalesRevenue',
            'totalPurchasesCount',
            'totalPurchasesAmount',
            'grossProfit',
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

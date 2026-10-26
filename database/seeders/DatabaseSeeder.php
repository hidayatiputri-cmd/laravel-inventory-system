<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun User untuk Testing (Admin, Staff, Customer)
        $users = [
            [
                'email' => 'admin@inventory.com',
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ],
            [
                'email' => 'staff@inventory.com',
                'name' => 'Staff Gudang & Kasir',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'email_verified_at' => now(),
            ],
            [
                'email' => 'customer@inventory.com',
                'name' => 'Budi Santoso (Customer)',
                'password' => Hash::make('password'),
                'role' => 'customer',
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        // 2. Tepat 3 Kategori Utama
        $categoriesData = [
            [
                'name' => 'Elektronik',
                'slug' => 'elektronik',
                'description' => 'Perangkat elektronik, aksesoris komputer, gadget, dan periferal digital.',
            ],
            [
                'name' => 'Pakaian',
                'slug' => 'pakaian',
                'description' => 'Pakaian pria dan wanita, busana kasual, kaos polos, dan fashion harian.',
            ],
            [
                'name' => 'Makanan & Minuman',
                'slug' => 'makanan-minuman',
                'description' => 'Produk kopi, camilan, minuman kemasan, dan bahan konsumsi harian.',
            ],
        ];

        $categories = [];
        foreach ($categoriesData as $catData) {
            $categories[$catData['slug']] = Category::firstOrCreate(
                ['slug' => $catData['slug']],
                $catData
            );
        }

        // 3. Supplier Pendukung yang Relevan dengan 3 Kategori Tersebut
        $suppliersData = [
            [
                'name' => 'PT Mega Elektronika Digital',
                'email' => 'sales@megaelektronika.co.id',
                'phone' => '021-5558901',
                'address' => 'Kawasan Niaga Harco Mangga Dua Blok C No. 12, Jakarta Pusat',
            ],
            [
                'name' => 'CV Garmen Tekstil Nusantara',
                'email' => 'order@garmentekstil.com',
                'phone' => '022-7201445',
                'address' => 'Jl. Cigondewah Industri No. 45, Bandung Kulon, Jawa Barat',
            ],
            [
                'name' => 'PT Berkah Pangan Mandiri',
                'email' => 'supply@berkahpangan.id',
                'phone' => '031-8945612',
                'address' => 'Jl. Rungkut Madya No. 88, Surabaya, Jawa Timur',
            ],
        ];

        foreach ($suppliersData as $supData) {
            Supplier::firstOrCreate(
                ['name' => $supData['name']],
                $supData
            );
        }

        // 4. 6 Produk Bervariasi Lengkap dengan SKU, Harga Beli, Harga Jual, dan Stok Awal
        // (Masing-masing 2 produk per kategori, mencakup simulasi stok aman dan stok rendah/alert)
        $productsData = [
            // Kategori: Elektronik
            [
                'category_id' => $categories['elektronik']->id,
                'name' => 'Logitech Silent Wireless Mouse M220',
                'sku' => 'ELC-MOU-M220',
                'stock' => 35,
                'minimum_stock' => 10,
                'purchase_price' => 125000,
                'selling_price' => 179000,
                'description' => 'Mouse tanpa kabel dengan teknologi silent click 90% peredam suara dan jangkauan 10 meter.',
            ],
            [
                'category_id' => $categories['elektronik']->id,
                'name' => 'Flashdisk Kingston DataTraveler 64GB USB 3.2',
                'sku' => 'ELC-FLS-64GB',
                'stock' => 5, // Di bawah minimum_stock (5 <= 10) untuk memicu Low Stock Alert
                'minimum_stock' => 10,
                'purchase_price' => 55000,
                'selling_price' => 85000,
                'description' => 'Media penyimpanan portabel kecepatan tinggi USB 3.2 Gen 1 dengan bodi tutup pelindung.',
            ],

            // Kategori: Pakaian
            [
                'category_id' => $categories['pakaian']->id,
                'name' => 'Kaos Polos Cotton Combed 30s Hitam (Size L)',
                'sku' => 'PAK-TSH-CM30-L',
                'stock' => 50,
                'minimum_stock' => 15,
                'purchase_price' => 35000,
                'selling_price' => 65000,
                'description' => 'Kaos polos premium bahan 100% katun combed 30s sejuk, nyaman, dan jahitan rantai rapi.',
            ],
            [
                'category_id' => $categories['pakaian']->id,
                'name' => 'Kemeja Formal Oxford Slimfit Putih (Size XL)',
                'sku' => 'PAK-KEM-OXF-XL',
                'stock' => 6, // Di bawah minimum_stock (6 <= 8) untuk memicu Low Stock Alert
                'minimum_stock' => 8,
                'purchase_price' => 85000,
                'selling_price' => 149000,
                'description' => 'Kemeja pria lengan panjang bahan katun oxford tebal, tidak mudah kusut, cocok untuk kerja formal.',
            ],

            // Kategori: Makanan & Minuman
            [
                'category_id' => $categories['makanan-minuman']->id,
                'name' => 'Kopi Arabika Gayo Specialty 250gr (Whole Beans)',
                'sku' => 'FNB-KOP-GY250',
                'stock' => 25,
                'minimum_stock' => 8,
                'purchase_price' => 68000,
                'selling_price' => 98000,
                'description' => 'Biji kopi sangrai 100% Single Origin Arabika dataran tinggi Gayo Aceh dengan proses semi-wash.',
            ],
            [
                'category_id' => $categories['makanan-minuman']->id,
                'name' => 'Madu Murni Randu Organik 500ml',
                'sku' => 'FNB-MDU-RND-500',
                'stock' => 18,
                'minimum_stock' => 5,
                'purchase_price' => 60000,
                'selling_price' => 92000,
                'description' => 'Madu murni alami nektar bunga randu tanpa pemanis buatan, dikemas dalam botol food-grade 500ml.',
            ],
        ];

        foreach ($productsData as $prodData) {
            Product::firstOrCreate(
                ['sku' => $prodData['sku']],
                $prodData
            );
        }
    }
}

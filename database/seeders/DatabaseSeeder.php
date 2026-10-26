<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Demo Users (Admin, Staff, Customer)
        $admin = User::firstOrCreate(
            ['email' => 'admin@inventory.com'],
            [
                'name' => 'Demo Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        $staff = User::firstOrCreate(
            ['email' => 'staff@inventory.com'],
            [
                'name' => 'Demo Staff',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'email_verified_at' => now(),
            ]
        );

        $customer = User::firstOrCreate(
            ['email' => 'customer@inventory.com'],
            [
                'name' => 'Demo Customer',
                'password' => Hash::make('password'),
                'role' => 'customer',
                'email_verified_at' => now(),
            ]
        );

        // 2. Seed Categories
        $categoriesData = [
            [
                'name' => 'Elektronik & Gadget',
                'slug' => 'elektronik-gadget',
                'description' => 'Perangkat elektronik, gadget, dan aksesoris komputer',
            ],
            [
                'name' => 'Alat Tulis Kantor',
                'slug' => 'alat-tulis-kantor',
                'description' => 'Kebutuhan ATK kantor, kertas, dan perlengkapan administrasi',
            ],
            [
                'name' => 'Pakaian & Fashion',
                'slug' => 'pakaian-fashion',
                'description' => 'Pakaian pria, wanita, dan aksesoris fashion',
            ],
            [
                'name' => 'Makanan & Minuman',
                'slug' => 'makanan-minuman',
                'description' => 'Kebutuhan bahan pangan dan minuman kemasan',
            ],
        ];

        $categories = [];
        foreach ($categoriesData as $cat) {
            $categories[$cat['slug']] = Category::firstOrCreate(
                ['slug' => $cat['slug']],
                $cat
            );
        }

        // 3. Seed Suppliers
        $suppliersData = [
            [
                'name' => 'PT Sumber Mega Elektronik',
                'email' => 'sales@sumbermega.com',
                'phone' => '021-5551234',
                'address' => 'Jl. Mangga Dua Raya No. 45, Jakarta Pusat',
            ],
            [
                'name' => 'CV Makmur Sejahtera ATK',
                'email' => 'info@makmuratk.com',
                'phone' => '022-7778899',
                'address' => 'Jl. Sudirman No. 120, Bandung',
            ],
            [
                'name' => 'PT Tekstil Nusantara Indah',
                'email' => 'supplier@tekstilnusantara.co.id',
                'phone' => '024-8889900',
                'address' => 'Kawasan Industri Candi Blok A, Semarang',
            ],
            [
                'name' => 'UD Berkah Pangan Abadi',
                'email' => 'order@berkahpangan.com',
                'phone' => '031-6663322',
                'address' => 'Jl. Rungkut Industri No. 88, Surabaya',
            ],
        ];

        foreach ($suppliersData as $sup) {
            Supplier::firstOrCreate(
                ['name' => $sup['name']],
                $sup
            );
        }

        // 4. Seed Products
        $productsData = [
            // Elektronik
            [
                'category_id' => $categories['elektronik-gadget']->id,
                'name' => 'Logitech Wireless Mouse M185',
                'sku' => 'ELC-LOG-M185',
                'stock' => 50,
                'minimum_stock' => 10,
                'purchase_price' => 110000,
                'selling_price' => 165000,
                'description' => 'Mouse wireless 2.4GHz ergonomis dengan baterai tahan lama.',
            ],
            [
                'category_id' => $categories['elektronik-gadget']->id,
                'name' => 'Keyboard Mechanical RGB TKL',
                'sku' => 'ELC-KBD-RGB',
                'stock' => 25,
                'minimum_stock' => 5,
                'purchase_price' => 320000,
                'selling_price' => 450000,
                'description' => 'Keyboard mechanical switch blue dengan backlight RGB.',
            ],
            [
                'category_id' => $categories['elektronik-gadget']->id,
                'name' => 'USB Flashdisk 64GB USB 3.0',
                'sku' => 'ELC-FLS-064G',
                'stock' => 8, // Di bawah minimum_stock untuk simulasi alert
                'minimum_stock' => 15,
                'purchase_price' => 60000,
                'selling_price' => 95000,
                'description' => 'Flashdrive high speed transfer 64GB casing metal.',
            ],

            // ATK
            [
                'category_id' => $categories['alat-tulis-kantor']->id,
                'name' => 'Kertas HVS A4 80gr 1 Rim',
                'sku' => 'ATK-HVS-A480',
                'stock' => 100,
                'minimum_stock' => 20,
                'purchase_price' => 42000,
                'selling_price' => 55000,
                'description' => 'Kertas HVS ukuran A4 80 gram isi 500 lembar.',
            ],
            [
                'category_id' => $categories['alat-tulis-kantor']->id,
                'name' => 'Pulpen Gel Hitam 0.5mm (Pak isi 12)',
                'sku' => 'ATK-PEN-GL05',
                'stock' => 40,
                'minimum_stock' => 10,
                'purchase_price' => 28000,
                'selling_price' => 40000,
                'description' => 'Pulpen tinta gel hitam cepat kering isi 12 pcs per pak.',
            ],

            // Fashion
            [
                'category_id' => $categories['pakaian-fashion']->id,
                'name' => 'Kaos Polos Cotton Combed 30s Hitam (L)',
                'sku' => 'FSH-TSH-BLK-L',
                'stock' => 60,
                'minimum_stock' => 15,
                'purchase_price' => 35000,
                'selling_price' => 65000,
                'description' => 'Kaos polos bahan 100% cotton combed 30s adem dan nyaman.',
            ],

            // Makanan & Minuman
            [
                'category_id' => $categories['makanan-minuman']->id,
                'name' => 'Kopi Arabika Gayo Specialty 250gr',
                'sku' => 'FNB-KOP-GY250',
                'stock' => 30,
                'minimum_stock' => 8,
                'purchase_price' => 65000,
                'selling_price' => 95000,
                'description' => 'Biji kopi sangrai Arabika Gayo Aceh proses semi-washed.',
            ],
        ];

        foreach ($productsData as $prod) {
            Product::firstOrCreate(
                ['sku' => $prod['sku']],
                $prod
            );
        }
    }
}

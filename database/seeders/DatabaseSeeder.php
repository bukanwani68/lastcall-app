<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Data Merchant
        $merchant = User::create([
            'name' => 'Bapak Merchant',
            'email' => 'merchant@lastcall.com',
            'password' => Hash::make('password123'),
        ]);

        // 2. Buat Data Toko (4 Toko)
        $store1 = Store::create([
            'user_id' => $merchant->id,
            'name' => 'Bakery Berkah Senja',
            'address' => 'Jl. Sudirman No. 10',
            'closing_time' => '22:00:00',
        ]);

        $store2 = Store::create([
            'user_id' => $merchant->id,
            'name' => 'Nasi Padang Ampera',
            'address' => 'Jl. Merdeka No. 45',
            'closing_time' => '21:00:00',
        ]);

        $store3 = Store::create([
            'user_id' => $merchant->id,
            'name' => 'Kopi & Senja Cafe',
            'address' => 'Jl. Diponegoro No. 12',
            'closing_time' => '23:00:00',
        ]);

        $store4 = Store::create([
            'user_id' => $merchant->id,
            'name' => 'Dapur Bento Japanese Food',
            'address' => 'Jl. Pemuda No. 88',
            'closing_time' => '21:30:00',
        ]);

        // 3. Buat Data Produk (12 Makanan Surplus)
        Product::insert([
            // Toko 1: Bakery Berkah Senja
            [
                'store_id' => $store1->id,
                'name' => 'Surprise Box Roti Manis (Isi 5)',
                'normal_price' => 50000,
                'discount_price' => 30000,
                'stock' => 8,
            ],
            [
                'store_id' => $store1->id,
                'name' => 'Pastry & Croissant Campur',
                'normal_price' => 40000,
                'discount_price' => 24000,
                'stock' => 5,
            ],
            [
                'store_id' => $store1->id,
                'name' => 'Bolu Coklat Utuh (Sisa Display)',
                'normal_price' => 80000,
                'discount_price' => 45000,
                'stock' => 2,
            ],

            // Toko 2: Nasi Padang Ampera
            [
                'store_id' => $store2->id,
                'name' => 'Paket Nasi Rendang + Sayur',
                'normal_price' => 28000,
                'discount_price' => 15000,
                'stock' => 12,
            ],
            [
                'store_id' => $store2->id,
                'name' => 'Ayam Bakar Sisa Etalase',
                'normal_price' => 16000,
                'discount_price' => 8000,
                'stock' => 15,
            ],
            [
                'store_id' => $store2->id,
                'name' => 'Gulai Tunjang Kuah Kental',
                'normal_price' => 22000,
                'discount_price' => 10000,
                'stock' => 4,
            ],

            // Toko 3: Kopi & Senja Cafe
            [
                'store_id' => $store3->id,
                'name' => 'Cold Brew Coffee 1L',
                'normal_price' => 65000,
                'discount_price' => 35000,
                'stock' => 6,
            ],
            [
                'store_id' => $store3->id,
                'name' => 'Sandwich Smoked Beef',
                'normal_price' => 35000,
                'discount_price' => 18000,
                'stock' => 7,
            ],
            [
                'store_id' => $store3->id,
                'name' => 'Matcha & Chocolate Slice Cake',
                'normal_price' => 45000,
                'discount_price' => 22000,
                'stock' => 3,
            ],

            // Toko 4: Dapur Bento Japanese Food
            [
                'store_id' => $store4->id,
                'name' => 'Chicken Teriyaki Bento Set',
                'normal_price' => 42000,
                'discount_price' => 21000,
                'stock' => 10,
            ],
            [
                'store_id' => $store4->id,
                'name' => 'Assorted Sushi Roll (12 pcs)',
                'normal_price' => 60000,
                'discount_price' => 30000,
                'stock' => 5,
            ],
            [
                'store_id' => $store4->id,
                'name' => 'Takoyaki & Okonomiyaki Combo',
                'normal_price' => 38000,
                'discount_price' => 19000,
                'stock' => 9,
            ],
        ]);
    }
}
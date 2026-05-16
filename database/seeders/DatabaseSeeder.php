<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@pos.com',
            'role' => 'admin',
            'password' => Hash::make('password123'),
        ]);

        // Create Kasir
        User::create([
            'name' => 'Kasir 1',
            'email' => 'kasir@pos.com',
            'role' => 'kasir',
            'password' => Hash::make('password123'),
        ]);

        // Sample Categories
        $catFood = Category::create(['nama' => 'Makanan']);
        $catDrink = Category::create(['nama' => 'Minuman']);
        $catStationery = Category::create(['nama' => 'Alat Tulis']);
        $catOther = Category::create(['nama' => 'Lain-lain']);

        // Sample Products
        $products = [
            ['nama' => 'Indomie Goreng', 'harga' => 3500, 'stok' => 100, 'category_id' => $catFood->id],
            ['nama' => 'Indomie Kuah', 'harga' => 3000, 'stok' => 80, 'category_id' => $catFood->id],
            ['nama' => 'Teh Botol Sosro 450ml', 'harga' => 5000, 'stok' => 50, 'category_id' => $catDrink->id],
            ['nama' => 'Aqua 600ml', 'harga' => 4000, 'stok' => 120, 'category_id' => $catDrink->id],
            ['nama' => 'Coca Cola 390ml', 'harga' => 7000, 'stok' => 30, 'category_id' => $catDrink->id],
            ['nama' => 'Roti Sari Roti Coklat', 'harga' => 8500, 'stok' => 25, 'category_id' => $catFood->id],
            ['nama' => 'Chitato 68g', 'harga' => 12000, 'stok' => 40, 'category_id' => $catFood->id],
            ['nama' => 'Pocari Sweat 500ml', 'harga' => 8000, 'stok' => 35, 'category_id' => $catDrink->id],
            ['nama' => 'Good Day Cappuccino 250ml', 'harga' => 6000, 'stok' => 60, 'category_id' => $catDrink->id],
            ['nama' => 'Pulpen Standard AE7', 'harga' => 3000, 'stok' => 200, 'category_id' => $catStationery->id],
            ['nama' => 'Buku Tulis Sidu 38 Lembar', 'harga' => 5000, 'stok' => 150, 'category_id' => $catStationery->id],
            ['nama' => 'Pensil 2B Faber Castell', 'harga' => 4000, 'stok' => 100, 'category_id' => $catStationery->id],
            ['nama' => 'Silverqueen 65g', 'harga' => 15000, 'stok' => 20, 'category_id' => $catFood->id],
            ['nama' => 'Oreo 137g', 'harga' => 10000, 'stok' => 45, 'category_id' => $catFood->id],
            ['nama' => 'Tissue Paseo 250 Sheet', 'harga' => 15000, 'stok' => 3, 'category_id' => $catOther->id],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}

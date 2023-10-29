<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 30; $i++) {
            Product::create([
                'category_id' => 13,
                'name' => 'Panasonic Let\'s note '.$i,
                'description' => 'CF-S10 No.'.$i,
                'price' => 100000
            ]);
        }
    }
}

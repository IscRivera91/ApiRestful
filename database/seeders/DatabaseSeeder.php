<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         User::factory(200)->create();
         Category::factory(30)->create();
         Product::factory(500)->create()->each(function ($product) {
             $categories_ids = Category::all()->random(rand(1,5))->pluck('id');
             $product->categories()->attach($categories_ids);
         });
         Transaction::factory(50)->create();
    }
}

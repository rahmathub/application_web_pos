<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Product;


class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 20; $i++) {
            $productId = rand(1, 20);
            $product = Product::find($productId);

            Transaction::create([
                'product_id' => $productId,
                'transaction_date' => $faker->date(),
                'product_total' => $faker->numberBetween(1, 10),
                'price_total' => $product->price * $faker->numberBetween(1, 10),
            ]);
        }
    }
}
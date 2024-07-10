<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class SpecialPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $products = DB::table('products')->pluck('id', 'name');

        DB::table('special_price')->insert([
            'id' => Uuid::uuid4(),
            'product_id' => $products['A'],
            'quantity' => 3,
            'price' => 130,
        ]);

        DB::table('special_price')->insert([
            'id' => Uuid::uuid4(),
            'product_id' => $products['B'],
            'quantity' => 2,
            'price' => 45,
        ]);
    }
}

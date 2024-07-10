<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            'id' => Uuid::uuid4(),
            'name' => 'A',
            'unit_price' => 50
        ]);

        DB::table('products')->insert([
            'id' => Uuid::uuid4(),
            'name' => 'B',
            'unit_price' => 30

        ]);

        DB::table('products')->insert([
            'id' => Uuid::uuid4(),
            'name' => 'C',
            'unit_price' => 20
        ]);

        DB::table('products')->insert([
            'id' => Uuid::uuid4(),
            'name' => 'D',
            'unit_price' => 10
        ]);
    }
}

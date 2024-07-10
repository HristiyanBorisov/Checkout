<?php

namespace App\Repository;

use App\Models\Product;
use App\Models\SpecialPrice;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class ProductRepository implements ProductRepositoryInterface, GeneralRepositoryInterface
{
    public function getAllProducts(): Collection
    {
        return Product::query()
            ->whereNull('deleted_at')
            ->orderBy('name')
            ->get();
    }

    public function addProduct($data) : string
    {
        return Product::create($data)->id;
    }

    public function renameProduct($id, $new_name) : bool
    {
        return Product::where('id', $id)->update(['name' => $new_name]) ;
    }

    public function deleteProduct($id) : bool
    {
        return Product::where('id', $id)->update(['deleted_at' => now()]);
    }

    public function getSpecialPrice() : Collection
    {
        return DB::table('special_price')
            ->join('products', 'products.id', '=', 'special_price.product_id')
            ->whereNull('products.deleted_at')
            ->whereNull('special_price.deleted_at')
            ->get([
                'special_price.*',
                'products.name as product_name'
            ]);
    }

    public function addSpecialOffer(
        string $product_id,
        array $data,
    ) : bool
    {
        $doesSpecialPriceExists = SpecialPrice::where('product_id', $product_id)->whereNull('deleted_at')->first();

        if (!empty($doesSpecialPriceExists->id)) {

            $result = SpecialPrice::where('product_id', $product_id)->update( [
                'quantity' => $data['quantity'],
                'price' => $data['price']
            ] );

        } else {

            $result = SpecialPrice::create(
                [
                    'id' => Uuid::uuid4(),
                    'product_id' => $product_id,
                    'quantity' => $data['quantity'],
                    'price' => $data['price'],
                ]
            );

        }

        return (bool) $result;
    }

    public function deleteSpecialOffer($id) : bool
    {
        return (bool) SpecialPrice::where('id', $id)->update(['deleted_at' => now()]);
    }
}

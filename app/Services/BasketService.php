<?php

namespace App\Services;

use App\Models\Product;
use App\Services\BasketServiceInterface;
use App\Services\GeneralServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Ramsey\Uuid\UuidInterface;

class BasketService implements BasketServiceInterface, GeneralServiceInterface
{
    public function addToBasket(
        string $product_id
    ): array
    {
        $userId = Auth::id();

        $basketKey = "basket_{$userId}";

        $basket = json_decode(Redis::get($basketKey), true) ?? [];

        $product = Product::findOrFail($product_id);

        if (!isset($basket['items']) || !array_key_exists($product->id, $basket['items'])) {
            $basket['items'][$product->id] = [
                "id" => $product->id,
                "name" => $product->name,
                "price" => $product->unit_price,
                "quantity" => 1,
            ];
        } else {
            $basket['items'][$product->id]["quantity"] += 1;
        }

        Redis::set($basketKey, json_encode($basket));

        return $basket;
    }
}

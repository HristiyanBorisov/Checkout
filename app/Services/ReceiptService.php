<?php

namespace App\Services;

use App\Models\SpecialPrice;
use App\Services\GeneralServiceInterface;
use App\Services\ReceiptServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class ReceiptService implements ReceiptServiceInterface, GeneralServiceInterface
{

    private UuidInterface $userId;

    private string $basketKey;

    private ReceiptCalculationService $receiptCalculationService;

    public function __construct()
    {
        $this->userId = Uuid::fromString(Auth::id());

        $this->basketKey = "basket_{$this->userId->toString()}";

        $this->receiptCalculationService = app(ReceiptCalculationService::class);
    }

    public function getReceipt(): array
    {
        $basket = json_decode(Redis::get($this->basketKey), true) ?? [];

        if (empty($basket)) {
            return [
                'total' => 0
            ];
        }

        $total = 0;

        foreach ($basket['items'] as $key => $value) {

            $specialPrice = SpecialPrice::where('product_id', '=', $key)->first();

            if ($specialPrice) {

                $neededForDiscount = $specialPrice->quantity;
                $discountedPrice = $specialPrice->price;

                $productsPrice = $this->receiptCalculationService->getTotalPrice($value['quantity'], $value['price'], $neededForDiscount, $discountedPrice);


            } else {

                $productsPrice = $value['price'] * $value['quantity'];

            }

            $basket['items'][$key]['total'] = $productsPrice;
            $total += $productsPrice;

        }

        $basket['total'] = $total;

        return $basket;
    }

    public function clearReceipt(): bool
    {
        return Redis::del($this->basketKey);
    }
}

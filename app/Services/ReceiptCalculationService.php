<?php

namespace App\Services;

use App\Services\GeneralServiceInterface;
use App\Services\ReceiptCalculationServiceInterface;

class ReceiptCalculationService implements ReceiptCalculationServiceInterface, GeneralServiceInterface
{
    public function getTotalPrice(
        int   $quantity,
        float $pricePerItem,
        int   $discountOnNumberOfItems,
        float $discountedPrice
    ): float
    {
        // Calculate the number of pairs and remaining items
        $pairs = intdiv($quantity, $discountOnNumberOfItems);
        $remainingItems = $quantity % $discountOnNumberOfItems;


        // Calculate the total price based on pairs and remaining items
        return ($pairs * $discountedPrice) + ($remainingItems * $pricePerItem);
    }
}

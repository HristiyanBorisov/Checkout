<?php

namespace App\Repository;

use App\Enums\OrderStatusEnum;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Repository\GeneralRepositoryInterface;
use App\Repository\OrderRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;

class OrderRepository implements OrderRepositoryInterface, GeneralRepositoryInterface
{

    public function submitOrder($data): void
    {
        if (!empty($data['items'])) {

            $order = Order::create(
                [
                    'id' => Uuid::uuid4(),
                    'user_id' => Auth::id(),
                    'status' => OrderStatusEnum::CREATED->value,
                    'total' => $data['total'],
                ]
            );

            foreach ($data['items'] as $item) {
                OrderProduct::create(
                    [
                        'id' => Uuid::uuid4(),
                        'order_id' => Uuid::fromString($order->id),
                        'product_id' => Uuid::fromString($item['id']),
                        'quantity' => $item['quantity'],
                        'price' => (double) $item['total'],
                    ]
                );
            }

        }
    }

}

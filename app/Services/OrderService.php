<?php

namespace App\Services;

use App\Enums\OrderStatusEnum;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Repository\OrderRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class OrderService implements OrderServiceInterface, GeneralServiceInterface
{

    private ReceiptServiceInterface $receiptService;

    private OrderRepositoryInterface $orderRepository;

    public function __construct()
    {
        $this->receiptService = app(ReceiptServiceInterface::class);

        $this->orderRepository = app(OrderRepositoryInterface::class);
    }

    public function submitOrder(): void
    {
        $receipt = $this->receiptService->getReceipt();

        $this->orderRepository->submitOrder($receipt);

        $this->receiptService->clearReceipt();
    }

    public function getOrderHistory(): Collection
    {
        $orders = DB::table('orders')
            ->join('order_products', 'orders.id', '=', 'order_products.order_id')
            ->join('products', 'order_products.product_id', '=', 'products.id')
            ->select(
                'orders.*',
                DB::raw("JSON_ARRAYAGG(
                    JSON_OBJECT(
                        'id', products.id,
                        'name', products.name,
                        'quantity', order_products.quantity,
                        'price', order_products.price
                    )
                ) as products")
            )
            ->where('orders.user_id', Auth::id())
            ->groupBy('orders.id')
            ->orderBy('orders.created_at')
            ->get();

        $orders->transform(function ($order) {
            $order->products = json_decode($order->products);
            return $order;
        });

        return $orders;
    }

    public function getAllOrders(): Collection
    {
        $orders = DB::table('orders')
            ->join('order_products', 'orders.id', '=', 'order_products.order_id')
            ->join('products', 'order_products.product_id', '=', 'products.id')
            ->select(
                'orders.*',
                DB::raw("JSON_ARRAYAGG(
                    JSON_OBJECT(
                        'id', products.id,
                        'name', products.name,
                        'quantity', order_products.quantity,
                        'price', order_products.price
                    )
                ) as products")
            )
            ->groupBy('orders.id')
            ->orderBy('orders.created_at')
            ->get();

        $orders->transform(function ($order) {
            $order->products = json_decode($order->products);
            return $order;
        });

        return $orders;
    }

    public function getPendingOrders(): Collection
    {
        $orders = DB::table('orders')
            ->join('order_products', 'orders.id', '=', 'order_products.order_id')
            ->join('products', 'order_products.product_id', '=', 'products.id')
            ->select(
                'orders.*',
                DB::raw("JSON_ARRAYAGG(
                    JSON_OBJECT(
                        'id', products.id,
                        'name', products.name,
                        'quantity', order_products.quantity,
                        'price', order_products.price
                    )
                ) as products")
            )
            ->where('orders.status', '=', OrderStatusEnum::CREATED->value)
            ->groupBy('orders.id')
            ->orderBy('orders.created_at')
            ->get();

        $orders->transform(function ($order) {
            $order->products = json_decode($order->products);
            return $order;
        });

        return $orders;
    }

    public function moveOrderStatus($data): bool
    {
        $order = Order::where('id', $data['order_id'])->first();

        if ($data['new_status'] != $order->status) {
            return Order::where('id', $data['order_id'])->update(['status' => $data['new_status']]);
        }

        return false;
    }
}

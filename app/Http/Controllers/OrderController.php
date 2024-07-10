<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatusEnum;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Services\OrderServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class OrderController extends Controller
{
    private ReceiptController $receipt;

    private OrderServiceInterface $orderService;

    public function __construct()
    {
        $this->receipt = app(ReceiptController::class);
        $this->orderService = app(OrderServiceInterface::class);
    }

    public function submitOrder(): ?RedirectResponse
    {
        $this->orderService->submitOrder();
        return redirect()->route('dashboard');
    }

    public function getOrderHistory(): Collection
    {
        return $this->orderService->getOrderHistory();
    }

    public function getAllOrders(): Collection
    {
        return $this->orderService->getAllOrders();
    }

    public function getPendingOrders(): Collection
    {
        return $this->orderService->getPendingOrders();
    }

    public function moveOrderStatus(
        Request $request,
    ): RedirectResponse
    {
        $params = [
            'order_id' => $request->order_id,
            'new_status' => $request->new_status
        ];

        $this->orderService->moveOrderStatus($params);

        return redirect()->back();
    }
}

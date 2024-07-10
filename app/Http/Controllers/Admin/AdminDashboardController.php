<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Services\ProductServiceInterface;

class AdminDashboardController extends Controller
{
    private ProductController $products;

    private OrderController $orders;

    private ProductServiceInterface $productService;


    public function __construct()
    {
        $this->products = new ProductController();
        $this->orders = new OrderController();

        $this->productService = app(ProductServiceInterface::class);
    }

    public function index()
    {

        $products = $this->products->getAllProducts();

        $specialPrice = $this->products->getSpecialPrice();

        $orders = $this->orders->getAllOrders();

        $pendingOrders = $this->orders->getPendingOrders();

        $statuses = OrderStatusEnum::cases();

        return view('admin_dashboard', compact('products', 'specialPrice', 'orders', 'pendingOrders', 'statuses'));
    }
}

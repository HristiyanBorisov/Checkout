<?php

namespace App\Http\Controllers;

use App\Services\ProductServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    protected ProductController $products;

    protected ReceiptController $receipt;

    protected OrderController $orders;

    public function __construct()
    {
        $this->products = new ProductController();
        $this->receipt = new ReceiptController();
        $this->orders = new OrderController();
    }

    public function index()
    {
        $products = $this->products->getAllProducts();

        $specialPrice = $this->products->getSpecialPrice();

        $receipt = $this->receipt->getReceipt();

        $orderHistory = $this->orders->getOrderHistory();

        $user = Auth::user();

        return view('dashboard', compact('products', 'specialPrice', 'receipt', 'orderHistory', 'user'));
    }
}

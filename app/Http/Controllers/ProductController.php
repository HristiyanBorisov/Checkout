<?php

namespace App\Http\Controllers;

use App\Services\BasketServiceInterface;
use App\Services\ProductServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{
    private ProductServiceInterface $productService;

    private BasketServiceInterface $basketService;

    public function __construct()
    {
        $this->productService = app(ProductServiceInterface::class);
        $this->basketService = app(BasketServiceInterface::class);
    }

    public function getAllProducts(): Collection
    {
        return $this->productService->getAllProducts();
    }

    public function addToBasket(
        Request $request,
    ): RedirectResponse
    {
        $this->basketService->addToBasket($request->product_id);

        return redirect()->route('dashboard');
    }

    public function addProduct(
        Request $request,
    ): RedirectResponse
    {
        $request->validate(
            [
                'product_name' => 'required | string | max:255',
                'product_price' => 'required | min:0 | max:999999.99',
            ]
        );

        $this->productService->addProduct($request->product_name, $request->product_price);

        return redirect()->route('admin.dashboard');
    }

    public function renameProduct(
        Request $request,
    ): RedirectResponse
    {
        $request->validate(
            [
                'product_id' => 'required | string | max:36',
                'product_new_name' => 'required | string | max:255',
            ]
        );
        $this->productService->renameProduct($request->product_id, $request->product_new_name);

        return redirect()->route('admin.dashboard');
    }

    public function deleteProduct(
        Request $request,
    ): RedirectResponse
    {
        $request->validate(
            [
                'product_id' => 'required | string | max:36',
            ]
        );

        $this->productService->deleteProduct($request->product_id);

        return redirect()->route('admin.dashboard');
    }


    public function getSpecialPrice(): Collection
    {
        return $this->productService->getSpecialPrice();
    }

    public function addSpecialOffer(
        Request $request,
    ): RedirectResponse
    {
        $request->validate(
            [
                'id' => 'required | string | max:36',
                'quantity' => 'required | min:0 | max:999999.99',
                'price' => 'required | min:0 | max:999999.99',
            ]
        );

        $this->productService->addSpecialOffer($request->id, $request->quantity, $request->price);

        return redirect()->route('admin.dashboard');
    }

    public function deleteSpecialOffer(
        Request $request,
    ): RedirectResponse
    {
        $request->validate(
            [
                'id' => 'required | string | max:36',
            ]
        );

        $this->productService->deleteSpecialOffer($request->id);

        return redirect()->route('admin.dashboard');
    }
}

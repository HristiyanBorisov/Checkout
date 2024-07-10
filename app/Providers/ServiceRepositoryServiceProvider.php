<?php

namespace App\Providers;

use App\Repository\OrderRepository;
use App\Repository\OrderRepositoryInterface;
use App\Repository\ProductRepository;
use App\Repository\ProductRepositoryInterface;
use App\Services\BasketService;
use App\Services\BasketServiceInterface;
use App\Services\OrderService;
use App\Services\OrderServiceInterface;
use App\Services\ProductService;
use App\Services\ProductServiceInterface;
use App\Services\ReceiptService;
use App\Services\ReceiptServiceInterface;
use Illuminate\Support\ServiceProvider;

class ServiceRepositoryServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Repositories
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);

        // Services
        $this->app->bind(OrderServiceInterface::class, OrderService::class);
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
        $this->app->bind(BasketServiceInterface::class, BasketService::class);
        $this->app->bind(ReceiptServiceInterface::class, ReceiptService::class);
    }
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}

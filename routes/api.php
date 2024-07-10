<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReceiptController;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// Products
Route::group(
    [ 'prefix' => 'products' ],
    function () {
        Route::get(
            '/',
            [ ProductController::class, 'getAllProducts' ]
        )->name(
            'products.products'
        );

        Route::get(
            '/special_price',
            [ ProductController::class, 'getSpecialPrice' ]
        )->name(
            'products.special_price'
        );

        Route::post(
            '/add_to_basket',
            [ ProductController::class, 'addToBasket' ]
        )->name(
            'products.add_to_basket'
        );
    }
);

// Receipt
Route::group(
    [ 'prefix' => 'receipt' ],
    function () {
        Route::get(
            '/',
            [ ReceiptController::class, 'getReceipt' ]
        )->name(
            'receipt.get'
        );
    }
);

// Order
Route::group(
    [ 'prefix' => 'order' ],
    function () {
        Route::post(
            '/',
            [ OrderController::class, 'submitOrder' ]
        )->name(
            'order.submit'
        );

        Route::get(
            '/history',
            [ OrderController::class, 'getOrderHistory' ]
        )->name(
            'order.history'
        );
    }
);


// Admin
Route::middleware([ IsAdmin::class ])->group(function () {
    Route::group(
        [ 'prefix' => 'admin' ],
        function () {
            Route::post(
                'add_product',
                [ ProductController::class, 'addProduct' ]
            )->name(
                'admin.add_product'
            );

            Route::put(
                'rename_product',
                [ ProductController::class, 'renameProduct' ]
            )->name(
                'admin.rename_product'
            );

            Route::delete(
                'delete_product',
                [ ProductController::class, 'deleteProduct' ]
            )->name(
                'admin.delete_product'
            );

            Route::post(
                'add_special_offer',
                [ ProductController::class, 'addSpecialOffer' ]
            )->name(
                'admin.add_special_offer'
            );

            Route::delete(
                'delete_special_offer',
                [ ProductController::class, 'deleteSpecialOffer' ]
            )->name(
                'admin.delete_special_offer'
            );

            Route::put(
                'move_order_status',
                [ OrderController::class, 'moveOrderStatus' ]
            )->name(
                'admin.move_order_status'
            );
        }
    );
});

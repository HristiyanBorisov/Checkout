<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(
            'order_products',
            function (
                Blueprint $blueprint
            ) {
            $blueprint->uuid('id');
            $blueprint->foreignUuid('order_id')->references('id')->on('orders');
            $blueprint->foreignUuid('product_id')->references('id')->on('products')->cascadeOnDelete();
            $blueprint->integer('quantity');
            $blueprint->double('price');
            $blueprint->timestampTz('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_products');
    }
};

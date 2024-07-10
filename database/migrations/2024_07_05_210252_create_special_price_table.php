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
            'special_price',
            function (
                Blueprint $blueprint
            ) {
                $blueprint->uuid('id')->primary();
                $blueprint->foreignUuid('product_id')->references('id')->on('products');
                $blueprint->integer('quantity');
                $blueprint->decimal('price', 8, 2)->default(0);
                $blueprint->timestampTz('created_at')->useCurrent();
                $blueprint->timestampTz('deleted_at')->nullable();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('special_price');
    }
};

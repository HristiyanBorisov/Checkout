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
            'orders',
            function (
                Blueprint $blueprint
            ) {
            $blueprint->uuid('id')->primary();
            $blueprint->foreignUuid('user_id')->references('id')->on('users')->onDelete('cascade');
            $blueprint->enum(
                'status',
                array_column(\App\Enums\OrderStatusEnum::cases(), 'value')
            );
            $blueprint->double('total');
            $blueprint->timestampTz('created_at')->useCurrent();
            $blueprint->timestampTz('updated_at')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

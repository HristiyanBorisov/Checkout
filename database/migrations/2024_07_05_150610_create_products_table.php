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
            'products',
            function (
                Blueprint $blueprint
            ) {
                $blueprint->uuid('id')->primary();
                $blueprint->string('name')->unique();
                $blueprint->double('unit_price');
                $blueprint->timestampTz('created_at')->useCurrent();
                $blueprint->dateTimeTz('deleted_at')->nullable();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

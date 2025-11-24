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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('carts_id')->index('fk_cart_items_id1_idx');
            $table->unsignedBigInteger('products_id')->index('fk_cart_items_id2_idx');
            $table->bigInteger('quantity')->nullable();
            $table->decimal('price', 10, 0)->nullable();
            $table->decimal('subtotal', 10, 0)->nullable();
            $table->timestamps();

            // Use a single primary key 'id'. Composite primary keys including an
            // autoincrement column are not supported by SQLite and are unnecessary
            // when using an explicit id column.
            // $table->primary(['id', 'carts_id', 'products_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};

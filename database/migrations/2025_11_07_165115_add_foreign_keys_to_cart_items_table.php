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
        Schema::table('cart_items', function (Blueprint $table) {
            $table->foreign(['carts_id'], 'fk_cart_items_id1')->references(['id'])->on('carts')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['products_id'], 'fk_cart_items_id2')->references(['id'])->on('products')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropForeign('fk_cart_items_id1');
            $table->dropForeign('fk_cart_items_id2');
        });
    }
};

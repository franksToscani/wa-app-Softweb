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
        Schema::table('products_has_product_attributes', function (Blueprint $table) {
            $table->foreign(['products_id'], 'fk_products_has_product_attributes_id1')->references(['id'])->on('products')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['product_attributes_id'], 'fk_products_has_product_attributes_id2')->references(['id'])->on('product_attributes')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products_has_product_attributes', function (Blueprint $table) {
            $table->dropForeign('fk_products_has_product_attributes_id1');
            $table->dropForeign('fk_products_has_product_attributes_id2');
        });
    }
};

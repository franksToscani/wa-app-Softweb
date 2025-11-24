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
        Schema::create('products_has_product_attributes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('products_id')->index('fk_products_has_product_attributes_id1_idx');
            $table->unsignedBigInteger('product_attributes_id')->index('fk_products_has_product_attributes_id2_idx');
            $table->timestamp('created_at')->nullable();
            $table->softDeletes();

            // Use single primary key 'id' for SQLite compatibility.
            // $table->primary(['id', 'products_id', 'product_attributes_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products_has_product_attributes');
    }
};

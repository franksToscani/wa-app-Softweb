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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('products_id')->index('fk_product_variants_id1_idx');
            $table->string('sku')->nullable()->unique();
            $table->bigInteger('stock_quantity')->nullable()->default(0);
            $table->decimal('regular_price', 10)->nullable();
            $table->decimal('sale_price', 10)->nullable();
            $table->json('attributes')->nullable();
            $table->timestamp('sale_start_at')->nullable();
            $table->timestamp('sale_end_at')->nullable();
            $table->decimal('tax_class', 5)->nullable();
            $table->timestamp('create_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            // Use single primary key 'id' for SQLite compatibility.
            // $table->primary(['id', 'products_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};

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
        Schema::create('ordered_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('oders_id')->index('fk_ordered_items_id1_idx');
            $table->unsignedBigInteger('products_id')->index('fk_ordered_items_id2_idx');
            $table->string('name')->nullable();
            $table->bigInteger('quantity')->nullable();
            $table->decimal('price', 10, 0)->nullable();
            $table->decimal('subtotal', 10, 0)->nullable();
            $table->decimal('tax_', 10, 0)->nullable();
            $table->decimal('total', 10, 0)->nullable();
            $table->timestamps();

            // Use single primary key 'id' for SQLite compatibility.
            // $table->primary(['id', 'oders_id', 'products_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordered_items');
    }
};

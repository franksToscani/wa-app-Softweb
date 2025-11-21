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
        Schema::create('product_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sku')->nullable()->unique();
            $table->timestamp('create_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('languages_codes_id')->index('fk_product_translations_id1_idx');
            $table->unsignedBigInteger('products_id')->index('fk_product_translations_id2_idx');

            // Use single primary key 'id' for SQLite compatibility.
            // $table->primary(['id', 'languages_codes_id', 'products_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_translations');
    }
};

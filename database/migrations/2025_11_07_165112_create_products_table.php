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
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sku')->nullable()->unique();
            $table->unsignedBigInteger('posts_id')->index('fk_products_id1_idx');
            $table->unsignedBigInteger('medias_id')->index('fk_products_id2_idx');
            $table->unsignedBigInteger('posts_status_id')->index('fk_products_id3_idx');
            $table->unsignedBigInteger('posts_types_id')->index('fk_products_id4_idx');
            $table->bigInteger('stock_quantity')->nullable()->default(0);
            $table->decimal('regular_price', 10)->nullable();
            $table->decimal('sale_price', 10)->nullable();
            $table->timestamp('sale_start_at')->nullable();
            $table->timestamp('sale_end_at')->nullable();
            $table->decimal('tax_class', 5)->nullable();
            $table->timestamp('create_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            // Use single primary key 'id' for SQLite compatibility. Complex
            // composite primary keys that include autoincrement columns will
            // cause errors during SQLite migrations used in tests.
            // $table->primary(['id', 'posts_id', 'medias_id', 'posts_status_id', 'posts_types_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

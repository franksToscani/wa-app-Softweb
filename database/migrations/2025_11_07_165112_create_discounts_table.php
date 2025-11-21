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
        Schema::create('discounts', function (Blueprint $table) {
            $table->comment('Sconti automatici programmati.');
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('type')->nullable()->comment('type (percentage, fixed_amount)');
            $table->decimal('value', 10, 0)->nullable();
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->tinyInteger('active')->nullable()->default(0);
            $table->json('conditions')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('products_id')->index('fk_discounts_id1_idx');

            // Use single primary key 'id' for SQLite compatibility.
            // $table->primary(['id', 'products_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};

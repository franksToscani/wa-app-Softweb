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
        Schema::create('oders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('users_id')->index('fk_oders_id1_idx');
            $table->bigInteger('oder_number')->nullable();
            $table->string('status')->nullable();
            $table->string('payement_metod')->nullable();
            $table->decimal('sutotal', 10, 0)->nullable();
            $table->decimal('discount_total', 10, 0)->nullable();
            $table->decimal('shipping_total', 10, 0)->nullable();
            $table->decimal('tax_total', 10, 0)->nullable();
            $table->decimal('grand_total', 10, 0)->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Use single primary key 'id' for SQLite compatibility.
            // $table->primary(['id', 'users_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oders');
    }
};

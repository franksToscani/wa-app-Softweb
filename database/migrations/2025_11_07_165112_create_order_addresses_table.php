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
        Schema::create('order_addresses', function (Blueprint $table) {
            $table->comment('Indirizzi di spedizione e fatturazione.');
            $table->bigIncrements('id');
            $table->string('type')->nullable()->comment('billing / shipping');
            $table->string('full_name')->nullable();
            $table->string('company')->nullable();
            $table->string('address_ligne')->nullable()->comment('indirizzo di spedizione');
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('province')->nullable();
            $table->string('contry')->nullable();
            $table->string('phone_number')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('oders_id')->index('fk_order_addresses_id1_idx');

            // Use single primary key 'id' for SQLite compatibility.
            // $table->primary(['id', 'oders_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_addresses');
    }
};

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
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->comment('Pagamenti ricevuti per gli ordini.');
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('oders_id')->index('fk_payment_transactions_id1_idx');
            $table->bigInteger('transaction_id')->nullable();
            $table->decimal('amount', 10, 0)->nullable();
            $table->string('payment_metod')->nullable();
            $table->string('status')->nullable();
            $table->json('payload')->nullable();
            $table->timestamps();

            // Use single primary key 'id' for SQLite compatibility.
            // $table->primary(['id', 'oders_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};

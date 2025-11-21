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
        Schema::create('carts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('users_id')->index('fk_carts_id1_idx');
            $table->decimal('total', 10, 0)->nullable();
            $table->decimal('discount_total', 10, 0)->nullable();
            $table->timestamps();

            // Use single primary key 'id' for compatibility with SQLite. Composite
            // primary keys that include an autoincrement column cause errors in
            // SQLite during tests.
            // $table->primary(['id', 'users_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};

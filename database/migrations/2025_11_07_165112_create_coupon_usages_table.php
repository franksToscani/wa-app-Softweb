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
        Schema::create('coupon_usages', function (Blueprint $table) {
            $table->comment('Registro uso dei coupon.:-)');
            $table->bigIncrements('id');
            $table->unsignedBigInteger('coupons_id')->index('fk_coupon_usages_id1_idx');
            $table->unsignedBigInteger('users_id')->index('fk_coupon_usages_id2_idx');
            $table->unsignedBigInteger('oders_id')->index('fk_coupon_usages_id3_idx');
            $table->timestamp('use_at')->nullable();

            // Use single primary key 'id' for compatibility with SQLite and to
            // avoid composite primary keys that include an autoincrement column.
            // $table->primary(['id', 'coupons_id', 'users_id', 'oders_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupon_usages');
    }
};

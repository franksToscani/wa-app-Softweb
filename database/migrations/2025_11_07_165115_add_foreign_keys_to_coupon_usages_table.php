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
        Schema::table('coupon_usages', function (Blueprint $table) {
            $table->foreign(['coupons_id'], 'fk_coupon_usages_id1')->references(['id'])->on('coupons')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['users_id'], 'fk_coupon_usages_id2')->references(['id'])->on('users')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['oders_id'], 'fk_coupon_usages_id3')->references(['id'])->on('oders')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupon_usages', function (Blueprint $table) {
            $table->dropForeign('fk_coupon_usages_id1');
            $table->dropForeign('fk_coupon_usages_id2');
            $table->dropForeign('fk_coupon_usages_id3');
        });
    }
};

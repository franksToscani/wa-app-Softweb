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
        Schema::create('coupons', function (Blueprint $table) {
            $table->comment('Codici sconto manuali.');
            $table->bigIncrements('id');
            $table->unsignedBigInteger('oders_id')->index('fk_coupons_id1_idx');
            $table->bigInteger('coupon_code')->nullable();
            $table->string('description')->nullable();
            $table->string('type')->nullable();
            $table->decimal('value', 10, 0)->nullable();
            $table->date('start_at')->nullable();
            $table->date('end_at')->nullable();
            $table->tinyInteger('is_active')->nullable()->default(0);
            $table->timestamps();
            $table->softDeletes();

            // Use single primary key 'id' for SQLite compatibility.
            // $table->primary(['id', 'oders_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};

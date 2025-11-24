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
        Schema::create('permissions_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome');
            $table->string('slug');
            $table->timestamps();
            $table->unsignedBigInteger('permissions_id')->index('fk_permissions_translations_id1_idx');
            $table->unsignedBigInteger('languages_codes_id')->index('fk_permissions_translations_id2_idx');

            $table->unique(['languages_codes_id']);
            $table->unique(['permissions_id'], 'permissions_id_unique');
            // Use single primary key 'id' for SQLite compatibility.
            // $table->primary(['id', 'permissions_id', 'languages_codes_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions_translations');
    }
};

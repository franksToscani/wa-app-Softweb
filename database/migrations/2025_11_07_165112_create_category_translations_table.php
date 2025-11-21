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
        Schema::create('category_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('slug')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('categories_id')->unique('categories_id_unique');
            $table->unsignedBigInteger('languages_codes_id')->index('fk_category_translations_id2_idx');

            $table->index(['categories_id'], 'fk_category_translations_id1_idx');
            $table->unique(['languages_codes_id']);
            // Use single primary key 'id' for SQLite compatibility.
            // $table->primary(['id', 'categories_id', 'languages_codes_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_translations');
    }
};

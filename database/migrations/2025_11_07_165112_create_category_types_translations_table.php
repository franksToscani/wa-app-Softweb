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
        Schema::create('category_types_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50);
            $table->string('slug')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('languages_codes_id')->index('fk_category_types_translations_id1_idx');
            $table->unsignedBigInteger('category_types_id');

            $table->index(['category_types_id'], 'fk_category_types_translations_id2_idx');
            $table->unique(['languages_codes_id']);
            // Use single primary key 'id' for compatibility with SQLite.
            // $table->primary(['id', 'languages_codes_id', 'category_types_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_types_translations');
    }
};

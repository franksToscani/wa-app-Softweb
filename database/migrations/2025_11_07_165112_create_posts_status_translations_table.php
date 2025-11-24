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
        Schema::create('posts_status_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('languages_codes_id')->index('fk_posts_status_copy1_id1_idx');
            $table->unsignedBigInteger('posts_status_id')->index('fk_posts_status_translated_id1_idx');

            $table->unique(['languages_codes_id']);
            $table->unique(['posts_status_id'], 'posts_status_id_unique');
            // Use single primary key 'id' for SQLite compatibility.
            // $table->primary(['id', 'languages_codes_id', 'posts_status_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts_status_translations');
    }
};

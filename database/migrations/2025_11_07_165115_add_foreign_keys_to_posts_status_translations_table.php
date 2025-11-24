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
        Schema::table('posts_status_translations', function (Blueprint $table) {
            $table->foreign(['languages_codes_id'], 'fk_posts_status_copy1_id1')->references(['id'])->on('languages_codes')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['posts_status_id'], 'fk_posts_status_translated_id1')->references(['id'])->on('posts_status')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts_status_translations', function (Blueprint $table) {
            $table->dropForeign('fk_posts_status_copy1_id1');
            $table->dropForeign('fk_posts_status_translated_id1');
        });
    }
};

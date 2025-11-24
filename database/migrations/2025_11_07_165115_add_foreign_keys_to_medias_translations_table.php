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
        Schema::table('medias_translations', function (Blueprint $table) {
            $table->foreign(['media_id'], 'fk_media_translations_id1')->references(['id'])->on('medias')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['languages_codes_id'], 'fk_media_translations_id2')->references(['id'])->on('languages_codes')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medias_translations', function (Blueprint $table) {
            $table->dropForeign('fk_media_translations_id1');
            $table->dropForeign('fk_media_translations_id2');
        });
    }
};

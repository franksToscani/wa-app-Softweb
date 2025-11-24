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
        Schema::create('medias_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('file_name');
            $table->string('file_path');
            $table->string('mime_type')->nullable();
            $table->string('alt_text')->nullable();
            $table->string('slug', 50)->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('media_id')->index('fk_media_translations_id1_idx');
            $table->unsignedBigInteger('languages_codes_id')->index('fk_media_translations_id2_idx');

            $table->unique(['languages_codes_id']);
            $table->unique(['media_id'], 'media_id_unique');
            // Use single primary key 'id' for SQLite compatibility.
            // $table->primary(['id', 'media_id', 'languages_codes_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medias_translations');
    }
};

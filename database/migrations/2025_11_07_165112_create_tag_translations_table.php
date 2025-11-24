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
        Schema::create('tag_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome_tag');
            $table->text('descrizione')->nullable();
            $table->string('slug')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->softDeletes();
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('tags_id')->index('fk_tags_translations_id1_idx');
            $table->unsignedBigInteger('languages_codes_id')->index('fk_tags_translations_id2_idx');

            $table->unique(['languages_codes_id']);
            // Use single primary key 'id' for SQLite compatibility.
            // $table->primary(['id', 'languages_codes_id']);
            $table->unique(['tags_id'], 'tags_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tag_translations');
    }
};

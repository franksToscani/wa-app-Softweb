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
        Schema::create('posts_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('post_type', 50);
            $table->string('title');
            $table->longText('content');
            $table->text('excerpt')->nullable();
            $table->string('template')->nullable();
            $table->string('slug')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('posts_id')->index('fk_posts_translations_id1_idx');
            $table->unsignedBigInteger('languages_codes_id')->index('fk_posts_translations_id2_idx');

            $table->unique(['languages_codes_id']);
            $table->unique(['posts_id'], 'posts_id_unique');
            // Use single primary key 'id' for SQLite compatibility.
            // $table->primary(['id', 'posts_id', 'languages_codes_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts_translations');
    }
};

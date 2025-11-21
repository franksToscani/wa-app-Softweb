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
        Schema::create('posts_types_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50);
            $table->string('slug')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('languages_codes_id')->index('fk_posts_types_copy1_id1_idx');
            $table->unsignedBigInteger('posts_types_id')->index('fk_posts_types_copy1_id2_idx');

            $table->unique(['languages_codes_id']);
            $table->unique(['posts_types_id'], 'posts_types_id_unique');
            // Use single primary key 'id' for SQLite compatibility.
            // $table->primary(['id', 'languages_codes_id', 'posts_types_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts_types_translations');
    }
};

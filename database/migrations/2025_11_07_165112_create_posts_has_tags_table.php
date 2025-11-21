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
        Schema::create('posts_has_tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('posts_id')->index('fk_posts_has_tags_id1_idx');
            $table->unsignedBigInteger('tags_id')->index('fk_posts_has_tags_id2_idx');
            $table->timestamp('create_at')->nullable();
            $table->timestamp('update_at')->nullable();

            // Use single primary key 'id' for SQLite compatibility.
            // $table->primary(['id', 'posts_id', 'tags_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts_has_tags');
    }
};

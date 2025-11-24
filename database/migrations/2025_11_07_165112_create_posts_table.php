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
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('posts_types_id')->index('fk_posts_id4_idx');
            $table->string('title');
            $table->longText('content');
            $table->text('excerpt')->nullable();
            $table->string('template')->nullable();
            $table->tinyInteger('is_highlighted')->default(0);
            $table->tinyInteger('comments_enabled')->default(1);
            $table->tinyInteger('views_count')->nullable();
            $table->timestamp('published_at')->nullable()->unique('published_at_unique');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('users_id')->index('fk_posts_id1_idx');
            $table->unsignedBigInteger('posts_status_id')->index('fk_posts_id2_idx');
            $table->unsignedBigInteger('media_id')->index('fk_posts_id5_idx');
            $table->unsignedBigInteger('categories_id')->index('fk_posts_id3_idx');
            $table->unsignedBigInteger('parent_id')->nullable()->index('fk_posts_parent_idx');

            // Use single primary key 'id' for SQLite compatibility. Composite
            // primary keys with autoincrement columns aren't portable to SQLite
            // and cause test migrations to fail.
            // $table->primary(['id', 'posts_types_id', 'users_id', 'posts_status_id', 'media_id', 'categories_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};

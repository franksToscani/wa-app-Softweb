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
        Schema::table('posts', function (Blueprint $table) {
            $table->foreign(['users_id'], 'fk_posts_id1')->references(['id'])->on('users')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['posts_status_id'], 'fk_posts_id2')->references(['id'])->on('posts_status')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['categories_id'], 'fk_posts_id3')->references(['id'])->on('categories')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['posts_types_id'], 'fk_posts_id4')->references(['id'])->on('posts_types')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['media_id'], 'fk_posts_id5')->references(['id'])->on('medias')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['parent_id'], 'fk_posts_parent')->references(['id'])->on('posts')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign('fk_posts_id1');
            $table->dropForeign('fk_posts_id2');
            $table->dropForeign('fk_posts_id3');
            $table->dropForeign('fk_posts_id4');
            $table->dropForeign('fk_posts_id5');
            $table->dropForeign('fk_posts_parent');
        });
    }
};

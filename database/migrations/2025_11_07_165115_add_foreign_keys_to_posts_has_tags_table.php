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
        Schema::table('posts_has_tags', function (Blueprint $table) {
            $table->foreign(['posts_id'], 'fk_posts_has_tags_id1')->references(['id'])->on('posts')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['tags_id'], 'fk_posts_has_tags_id2')->references(['id'])->on('tags')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts_has_tags', function (Blueprint $table) {
            $table->dropForeign('fk_posts_has_tags_id1');
            $table->dropForeign('fk_posts_has_tags_id2');
        });
    }
};

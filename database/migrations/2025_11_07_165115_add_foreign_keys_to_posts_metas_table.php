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
        Schema::table('posts_metas', function (Blueprint $table) {
            $table->foreign(['posts_id'], 'fk_posts_metas_id1')->references(['id'])->on('posts')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts_metas', function (Blueprint $table) {
            $table->dropForeign('fk_posts_metas_id1');
        });
    }
};

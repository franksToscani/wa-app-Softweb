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
        Schema::create('posts_metas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('post_meta_key');
            $table->json('post_meta_value');
            $table->timestamps();
            $table->unsignedBigInteger('posts_id')->index('fk_posts_metas_id1_idx');

            // Use single primary key 'id' for SQLite compatibility.
            // $table->primary(['id', 'posts_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts_metas');
    }
};

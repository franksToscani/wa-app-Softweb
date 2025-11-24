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
        Schema::table('products', function (Blueprint $table) {
            $table->foreign(['posts_id'], 'fk_products_id1')->references(['id'])->on('posts')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['medias_id'], 'fk_products_id2')->references(['id'])->on('medias')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['posts_status_id'], 'fk_products_id3')->references(['id'])->on('posts_status')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['posts_types_id'], 'fk_products_id4')->references(['id'])->on('posts_types')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('fk_products_id1');
            $table->dropForeign('fk_products_id2');
            $table->dropForeign('fk_products_id3');
            $table->dropForeign('fk_products_id4');
        });
    }
};

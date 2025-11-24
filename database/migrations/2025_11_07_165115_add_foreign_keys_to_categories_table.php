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
        Schema::table('categories', function (Blueprint $table) {
            $table->foreign(['category_types_id'], 'fk_categories_id1')->references(['id'])->on('category_types')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['media_id'], 'fk_categories_id2')->references(['id'])->on('medias')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['parent_id'], 'fk_categories_parent')->references(['id'])->on('categories')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign('fk_categories_id1');
            $table->dropForeign('fk_categories_id2');
            $table->dropForeign('fk_categories_parent');
        });
    }
};

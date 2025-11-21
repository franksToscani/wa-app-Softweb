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
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('menu_order')->nullable()->default(0);
            $table->tinyInteger('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('media_id')->index('fk_categories_id2_idx');
            $table->unsignedBigInteger('category_types_id')->index('fk_categories_id1_idx');
            $table->unsignedBigInteger('parent_id')->nullable()->index('fk_categories_parent_idx');

            // Use single primary key 'id' for SQLite compatibility.
            // $table->primary(['id', 'media_id', 'category_types_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('products')) {
            return;
        }

        // Modify foreign key from products.posts_id -> posts.id to cascade on delete
        Schema::table('products', function (Blueprint $table) {
            try {
                // Drop existing FK if present (name from original migration)
                $table->dropForeign('fk_products_id1');
            } catch (\Exception $e) {
                // ignore if it doesn't exist
            }

            // Recreate with ON DELETE CASCADE
            $table->foreign('posts_id', 'fk_products_id1')
                ->references('id')
                ->on('posts')
                ->onUpdate('no action')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('products')) {
            return;
        }

        Schema::table('products', function (Blueprint $table) {
            try {
                $table->dropForeign('fk_products_id1');
            } catch (\Exception $e) {
                // ignore
            }

            // Recreate original constraint (no action on delete)
            $table->foreign('posts_id', 'fk_products_id1')
                ->references('id')
                ->on('posts')
                ->onUpdate('no action')
                ->onDelete('no action');
        });
    }
};

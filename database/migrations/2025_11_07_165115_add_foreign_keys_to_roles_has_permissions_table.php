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
        Schema::table('roles_has_permissions', function (Blueprint $table) {
            $table->foreign(['roles_id'], 'fk_roles_has_permissions_id1')->references(['id'])->on('roles')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['permissions_id'], 'fk_roles_has_permissions_id2')->references(['id'])->on('permissions')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('roles_has_permissions', function (Blueprint $table) {
            $table->dropForeign('fk_roles_has_permissions_id1');
            $table->dropForeign('fk_roles_has_permissions_id2');
        });
    }
};

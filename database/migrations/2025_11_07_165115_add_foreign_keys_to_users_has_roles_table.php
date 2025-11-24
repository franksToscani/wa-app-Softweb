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
        Schema::table('users_has_roles', function (Blueprint $table) {
            $table->foreign(['users_id'], 'fk_users_has_roles_id1')->references(['id'])->on('users')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['roles_id'], 'fk_users_has_roles_id2')->references(['id'])->on('roles')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users_has_roles', function (Blueprint $table) {
            $table->dropForeign('fk_users_has_roles_id1');
            $table->dropForeign('fk_users_has_roles_id2');
        });
    }
};

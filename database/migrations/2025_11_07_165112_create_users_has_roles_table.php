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
        Schema::create('users_has_roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('users_id')->index('fk_users_has_roles_id1_idx');
            $table->unsignedBigInteger('roles_id')->index('fk_users_has_roles_id2_idx');
            $table->timestamps();

            // Use single primary key 'id' for SQLite compatibility.
            // $table->primary(['id', 'users_id', 'roles_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_has_roles');
    }
};

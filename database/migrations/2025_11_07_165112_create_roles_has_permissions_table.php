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
        Schema::create('roles_has_permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('roles_id')->index('fk_roles_has_permissions_id1_idx');
            $table->unsignedBigInteger('permissions_id')->index('fk_roles_has_permissions_id2_idx');
            $table->timestamps();
            $table->softDeletes();

            // Use single primary key 'id' for SQLite compatibility.
            // $table->primary(['id', 'roles_id', 'permissions_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles_has_permissions');
    }
};

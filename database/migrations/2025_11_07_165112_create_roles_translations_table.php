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
        Schema::create('roles_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome');
            $table->string('descrizione')->nullable();
            $table->string('slug')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('roles_id')->index('fk_roles_translations_id1_idx');
            $table->unsignedBigInteger('languages_codes_id')->index('fk_roles_translations_id2_idx');

            $table->unique(['languages_codes_id']);
            // Use single primary key 'id' for SQLite compatibility.
            // $table->primary(['id', 'roles_id', 'languages_codes_id']);
            $table->unique(['roles_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles_translations');
    }
};

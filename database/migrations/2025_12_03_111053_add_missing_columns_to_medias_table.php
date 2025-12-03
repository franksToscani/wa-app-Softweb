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
        Schema::table('medias', function (Blueprint $table) {
            if (!Schema::hasColumn('medias', 'name')) {
                $table->string('name')->nullable()->after('id');
            }
            if (!Schema::hasColumn('medias', 'url')) {
                $table->string('url')->nullable()->after('file_path');
            }
            if (!Schema::hasColumn('medias', 'description')) {
                $table->text('description')->nullable()->after('alt_text');
            }
            if (!Schema::hasColumn('medias', 'uploaded_by')) {
                $table->foreignId('uploaded_by')->nullable()->after('description')->constrained('users')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medias', function (Blueprint $table) {
            $table->dropForeign(['uploaded_by']);
            $table->dropColumn(['name', 'url', 'description', 'uploaded_by']);
        });
    }
};

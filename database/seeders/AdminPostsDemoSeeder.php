<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminPostsDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        // Medias (only metadata for selects) - create these first so categories can reference a media_id
        $medias = [
            ['file_name' => 'cover-sample-1.jpg', 'file_path' => '/storage/media/cover-sample-1.jpg', 'mime_type' => 'image/jpeg', 'created_at' => $now, 'updated_at' => $now],
            ['file_name' => 'cover-sample-2.png', 'file_path' => '/storage/media/cover-sample-2.png', 'mime_type' => 'image/png', 'created_at' => $now, 'updated_at' => $now],
        ];
        $mediaId = null;
        if (DB::getSchemaBuilder()->hasTable('medias')) {
            foreach ($medias as $m) {
                DB::table('medias')->updateOrInsert(['file_name' => $m['file_name']], $m);
            }
            $mediaId = DB::table('medias')->where('file_name', 'cover-sample-1.jpg')->value('id');
        }

        // Ensure there's at least one category type if the schema requires it
        $categoryTypeId = null;
        if (DB::getSchemaBuilder()->hasTable('category_types')) {
            DB::table('category_types')->updateOrInsert(['name' => 'Default'], ['name' => 'Default', 'created_at' => $now, 'updated_at' => $now]);
            $categoryTypeId = DB::table('category_types')->where('name', 'Default')->value('id');
        }

        // Categories (reference category_types and medias if present)
        $categories = [
            ['name' => 'News', 'description' => 'Latest news and updates', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Blog', 'description' => 'General articles and posts', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Tutorials', 'description' => 'How-to and tutorials', 'created_at' => $now, 'updated_at' => $now],
        ];
        if (DB::getSchemaBuilder()->hasTable('categories')) {
            foreach ($categories as $c) {
                $payload = $c;
                if ($mediaId !== null && !array_key_exists('media_id', $payload)) {
                    $payload['media_id'] = $mediaId;
                }
                if ($categoryTypeId !== null && !array_key_exists('category_types_id', $payload)) {
                    $payload['category_types_id'] = $categoryTypeId;
                }
                DB::table('categories')->updateOrInsert(['name' => $c['name']], $payload);
            }
        }

        // Posts types
        $types = [
            ['name' => 'Article', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Page', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Announcement', 'created_at' => $now, 'updated_at' => $now],
        ];
        if (DB::getSchemaBuilder()->hasTable('posts_types')) {
            foreach ($types as $t) {
                DB::table('posts_types')->updateOrInsert(['name' => $t['name']], $t);
            }
        }

        // Posts status
        $status = [
            ['name' => 'Draft', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Published', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Archived', 'created_at' => $now, 'updated_at' => $now],
        ];
        if (DB::getSchemaBuilder()->hasTable('posts_status')) {
            foreach ($status as $s) {
                DB::table('posts_status')->updateOrInsert(['name' => $s['name']], $s);
            }
        }

        // Medias (only metadata for selects)
        $medias = [
            ['file_name' => 'cover-sample-1.jpg', 'file_path' => '/storage/media/cover-sample-1.jpg', 'mime_type' => 'image/jpeg', 'created_at' => $now, 'updated_at' => $now],
            ['file_name' => 'cover-sample-2.png', 'file_path' => '/storage/media/cover-sample-2.png', 'mime_type' => 'image/png', 'created_at' => $now, 'updated_at' => $now],
        ];
        if (DB::getSchemaBuilder()->hasTable('medias')) {
            foreach ($medias as $m) {
                DB::table('medias')->updateOrInsert(['file_name' => $m['file_name']], $m);
            }
        }
    }
}

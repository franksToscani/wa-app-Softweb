<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SampleContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Temporarily disable foreign key checks so we can insert demo rows without
        // having to populate every referenced lookup table. This is acceptable for
        // local/demo data.
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $now = now();

        // Create 5 demo posts
        $posts = [];
        for ($i = 1; $i <= 5; $i++) {
            $posts[] = [
                'posts_types_id' => 1,
                'title' => "Demo post #{$i}",
                'content' => "Questo è il contenuto di prova del post numero {$i}.",
                'excerpt' => "Estratto del post {$i}",
                'template' => null,
                'is_highlighted' => ($i === 1) ? 1 : 0,
                'comments_enabled' => 1,
                'views_count' => rand(0, 100),
                'published_at' => $now->copy()->subDays(5 - $i),
                'created_at' => $now,
                'updated_at' => $now,
                'users_id' => 1,
                'posts_status_id' => 1,
                'media_id' => 1,
                'categories_id' => 1,
                'parent_id' => null,
            ];
        }

        DB::table('posts')->insert($posts);

        // Grab inserted post IDs (MySQL returns next autoinc but we'll query recent rows)
        $insertedPosts = DB::table('posts')->orderByDesc('id')->limit(5)->get();

        // Create 6 demo products linked to the posts above (or with posts_id 0 if not enough)
        $products = [];
        $postIds = $insertedPosts->pluck('id')->toArray();
        for ($i = 1; $i <= 6; $i++) {
            $products[] = [
                'sku' => 'DEMO-' . strtoupper(Str::random(6)),
                'posts_id' => $postIds[$i % count($postIds)] ?? ($postIds[0] ?? 1),
                'medias_id' => 1,
                'posts_status_id' => 1,
                'posts_types_id' => 1,
                'stock_quantity' => rand(0, 100),
                'regular_price' => rand(10, 200),
                'sale_price' => null,
                'sale_start_at' => null,
                'sale_end_at' => null,
                'tax_class' => null,
                'create_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('products')->insert($products);

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}

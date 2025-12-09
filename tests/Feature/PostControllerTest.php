<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test 1: Verifica che un post possa essere inserito nel database
     */
    public function test_can_insert_post_to_database(): void
    {
        $postData = [
            'title' => 'Il Mio Primo Post',
            'content' => '<h2>Titolo Contenuto</h2><p>Questo è il contenuto HTML del post</p>',
            'excerpt' => 'Un breve riassunto del post',
            'posts_types_id' => 1,
            'users_id' => 1,
            'posts_status_id' => 1,
            'media_id' => 1,
            'categories_id' => 1,
            'is_highlighted' => false,
            'comments_enabled' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::table('posts')->insert($postData);

        $this->assertDatabaseHas('posts', [
            'title' => 'Il Mio Primo Post',
            'content' => '<h2>Titolo Contenuto</h2><p>Questo è il contenuto HTML del post</p>',
        ]);
    }

    /**
     * Test 2: Verifica che un post possa avere contenuto HTML lungo (longtext)
     */
    public function test_can_store_large_html_content(): void
    {
        $longHtmlContent = '<p>' . str_repeat('Lorem ipsum dolor sit amet. ', 1000) . '</p>';

        $postData = [
            'title' => 'Post con Contenuto Lungo',
            'content' => $longHtmlContent,
            'excerpt' => 'Riassunto breve',
            'posts_types_id' => 1,
            'users_id' => 1,
            'posts_status_id' => 1,
            'media_id' => 1,
            'categories_id' => 1,
            'is_highlighted' => false,
            'comments_enabled' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::table('posts')->insert($postData);

        $savedPost = DB::table('posts')
            ->where('title', 'Post con Contenuto Lungo')
            ->first();

        $this->assertEquals($longHtmlContent, $savedPost->content);
    }

    /**
     * Test 3: Verifica che un post possa essere recuperato dal database
     */
    public function test_can_retrieve_post_from_database(): void
    {
        $postId = DB::table('posts')->insertGetId([
            'title' => 'Post di Lettura',
            'content' => '<p>Contenuto da leggere</p>',
            'excerpt' => 'Riassunto',
            'posts_types_id' => 1,
            'users_id' => 1,
            'posts_status_id' => 1,
            'media_id' => 1,
            'categories_id' => 1,
            'is_highlighted' => false,
            'comments_enabled' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $post = DB::table('posts')->find($postId);

        $this->assertNotNull($post);
        $this->assertEquals('Post di Lettura', $post->title);
        $this->assertEquals('<p>Contenuto da leggere</p>', $post->content);
    }

    /**
     * Test 4: Verifica che un post possa essere aggiornato
     */
    public function test_can_update_post_in_database(): void
    {
        $postId = DB::table('posts')->insertGetId([
            'title' => 'Post Originale',
            'content' => '<p>Contenuto originale</p>',
            'excerpt' => 'Riassunto originale',
            'posts_types_id' => 1,
            'users_id' => 1,
            'posts_status_id' => 1,
            'media_id' => 1,
            'categories_id' => 1,
            'is_highlighted' => false,
            'comments_enabled' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('posts')->where('id', $postId)->update([
            'title' => 'Post Aggiornato',
            'content' => '<p>Contenuto aggiornato</p>',
            'excerpt' => 'Riassunto aggiornato',
            'updated_at' => now(),
        ]);

        $this->assertDatabaseHas('posts', [
            'id' => $postId,
            'title' => 'Post Aggiornato',
            'content' => '<p>Contenuto aggiornato</p>',
        ]);

        $this->assertDatabaseMissing('posts', [
            'id' => $postId,
            'title' => 'Post Originale',
        ]);
    }

    /**
     * Test 5: Verifica che un post possa essere eliminato
     */
    public function test_can_delete_post_from_database(): void
    {
        $postId = DB::table('posts')->insertGetId([
            'title' => 'Post da Eliminare',
            'content' => '<p>Questo sarà eliminato</p>',
            'posts_types_id' => 1,
            'users_id' => 1,
            'posts_status_id' => 1,
            'media_id' => 1,
            'categories_id' => 1,
            'is_highlighted' => false,
            'comments_enabled' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('posts')->where('id', $postId)->delete();

        $this->assertDatabaseMissing('posts', [
            'id' => $postId,
            'title' => 'Post da Eliminare',
        ]);
    }

    /**
     * Test 6: Verifica che i campi nullable funzionino
     */
    public function test_post_can_have_nullable_fields(): void
    {
        $postData = [
            'title' => 'Post Minimo',
            'content' => '<p>Contenuto minimo</p>',
            'posts_types_id' => 1,
            'users_id' => 1,
            'posts_status_id' => 1,
            'media_id' => 1,
            'categories_id' => 1,
            'is_highlighted' => false,
            'comments_enabled' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $postId = DB::table('posts')->insertGetId($postData);

        $this->assertDatabaseHas('posts', [
            'id' => $postId,
            'title' => 'Post Minimo',
        ]);

        $post = DB::table('posts')->find($postId);
        $this->assertNull($post->excerpt);
    }

    /**
     * Test 7: Verifica che più post possano essere creati
     */
    public function test_multiple_posts_can_be_created(): void
    {
        $posts = [
            [
                'title' => 'Post 1',
                'content' => '<p>Contenuto 1</p>',
                'posts_types_id' => 1,
                'users_id' => 1,
                'posts_status_id' => 1,
                'media_id' => 1,
                'categories_id' => 1,
                'is_highlighted' => false,
                'comments_enabled' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Post 2',
                'content' => '<p>Contenuto 2</p>',
                'posts_types_id' => 1,
                'users_id' => 1,
                'posts_status_id' => 1,
                'media_id' => 1,
                'categories_id' => 1,
                'is_highlighted' => true,
                'comments_enabled' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Post 3',
                'content' => '<p>Contenuto 3</p>',
                'posts_types_id' => 1,
                'users_id' => 1,
                'posts_status_id' => 1,
                'media_id' => 1,
                'categories_id' => 1,
                'is_highlighted' => false,
                'comments_enabled' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('posts')->insert($posts);

        $this->assertEquals(3, DB::table('posts')->count());

        foreach ($posts as $postData) {
            $this->assertDatabaseHas('posts', [
                'title' => $postData['title'],
                'content' => $postData['content'],
            ]);
        }
    }

    /**
     * Test 8: Verifica che il field content supporti HTML
     */
    public function test_post_content_supports_html(): void
    {
        $htmlContent = <<<'HTML'
            <div class="container">
                <h1>Titolo Principale</h1>
                <p>Paragrafo con <strong>testo bold</strong> e <em>testo italico</em></p>
                <ul>
                    <li>Lista item 1</li>
                    <li>Lista item 2</li>
                </ul>
                <img src="image.jpg" alt="Immagine">
            </div>
        HTML;

        $postId = DB::table('posts')->insertGetId([
            'title' => 'Post HTML Complesso',
            'content' => $htmlContent,
            'posts_types_id' => 1,
            'users_id' => 1,
            'posts_status_id' => 1,
            'media_id' => 1,
            'categories_id' => 1,
            'is_highlighted' => false,
            'comments_enabled' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $savedPost = DB::table('posts')->find($postId);

        $this->assertEquals($htmlContent, $savedPost->content);
        $this->assertStringContainsString('<strong>', $savedPost->content);
        $this->assertStringContainsString('<ul>', $savedPost->content);
    }
}
<?php

namespace Tests\Feature\Future\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\Post;
use App\Models\User;

class PostTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
    }
    
    public function testGetIndexData(): void
    {
        Post::create(
            [
                'title' => 'test',
                'description' => 'test',
                'content' => 'test',
                'slug' => 'test',
                'user_id' => $this->user->id
            ]
        );
        $response = $this->json('GET', 'api/posts', [], []);
        $response->assertStatus(200);
    }

    public function testCreatePost(): void
    {
        $payload = [
            'title' => 'test',
            'description' => 'test',
            'content' => 'test',
            'slug' => 'test',
        ];
        $this->setHeaders($this->user);
        $response = $this->json('POST', 'api/posts', $payload, $this->headers);
        $response->assertStatus(200);
        $this->assertDatabaseHas('posts', [
            'title' => $payload['title'],
            'description' => $payload['description'],
            'content' => $payload['content'],
            'slug' => $payload['slug'],
            'user_id' => $this->user->id
        ]);
    }

    public function testGetPostDetail(): void
    {
        $post = Post::create(
            [
                'title' => 'test',
                'description' => 'test',
                'content' => 'test',
                'slug' => 'test',
                'user_id' => $this->user->id
            ]
        );
        $route = "api/posts/{$post->id}";
        $response = $this->json('GET', $route, [], []);
        $response->assertStatus(200);
    }

    public function testUpdatePost(): void
    {
        $post = Post::create(
            [
                'title' => 'test',
                'description' => 'test',
                'content' => 'test',
                'slug' => 'test',
                'user_id' => $this->user->id
            ]
        );
        $payload = [
            'title' => 'test update',
            'description' => 'test update',
            'content' => 'test update',
            'slug' => 'test update',
        ];
        $this->setHeaders($this->user);
        $route = "api/posts/{$post->id}";
        $response = $this->json('PUT', $route, $payload, $this->headers);
        $response->assertStatus(200);
        $this->assertDatabaseHas('posts', [
            'title' => $payload['title'],
            'description' => $payload['description'],
            'content' => $payload['content'],
            'slug' => $payload['slug'],
            'user_id' => $this->user->id
        ]);
    }

    public function testDestroyPost(): void
    {
        $post = Post::create(
            [
                'title' => 'test',
                'description' => 'test',
                'content' => 'test',
                'slug' => 'test',
                'user_id' => $this->user->id
            ]
        );
        $this->setHeaders($this->user);
        $route = "api/posts/{$post->id}";
        $response = $this->json('delete', $route, [], $this->headers);
        $response->assertStatus(200);
    }
}

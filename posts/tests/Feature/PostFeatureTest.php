<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_create_a_post()
    {
        $response = $this->post('/api/posts',[
            'title'=>'Test Post',
            'content'=>'Test Post Content',
        ]) ;
        $response->assertStatus(201)
            ->assertJson([
                'title'=>'Test Post',
                'content'=>'Test Post Content',
            ]);
    }
    public function test_it_can_update_a_post(){
        $post = Post::factory()->create();
        $response = $this->put("/api/posts/{$post->id}", [
            'title'=>'Test 2 Post',
            'content'=>'Test Post Content 2',
        ]);

        $response->assertStatus(200)
            ->assertJson([
               'title'=>'Test 2 Post',
               'content'=>'Test Post Content 2',
            ]);
    }
    public function test_it_can_delete_a_post(){
        $post = Post::factory()->create();
        $response = $this->delete("/api/posts/{$post->id}");
        $response->assertStatus(204);
    }

    public function test_it_can_show_a_post(){
        $post = Post::factory()->create();
        $response = $this->get("/api/posts/{$post->id}");
        $response->assertStatus(200)
        ->assertJson([
            'title'=>$post->title,
            'content'=>$post->content,
        ]);
    }

    public function test_it_can_show_all_posts()
    {
        Post::factory()->count(3)->create();
        $response = $this->get("/api/posts");
        $response->assertStatus(200)
            ->assertJsonCount(3);
    }
}

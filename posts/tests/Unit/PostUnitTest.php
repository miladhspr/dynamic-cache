<?php

namespace Tests\Unit;

use App\Models\Post;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostUnitTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     */
    public function test_a_post_can_be_created(): void
    {
        $post = Post::create([
           'title' =>'test post',
           'content' => 'this is a test post',
        ]);

        $this->assertDatabaseHas('posts',[
           'title' => 'test post'
        ]);
    }

    public function test_a_post_can_be_read()
    {
        $post = Post::factory()->create();
        $foundPost = Post::find($post->id);
        $this->assertEquals($post->title,$foundPost->title);
    }

    public function test_a_post_can_be_updated()
    {
        $post = Post::factory()->create();
        $post->update([
           'title' => 'updated title'
        ]);

        $this->assertDatabaseHas('posts',[
           'title' => 'updated title'
        ]);
    }
    public function test_a_post_can_be_deleted()
    {
        $post = Post::factory()->create();

        $post->delete();

        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
        ]);
    }
}

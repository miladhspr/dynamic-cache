<?php

namespace App\Http\Controllers;

use App\Facades\CustomCache;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $key = 'posts';
        $posts = CustomCache::get($key);
        if (!$posts) {
            $posts = Post::all();
            CustomCache::put($key, $posts->toJson(), 3600); // Cache for 1 hour
        } else {
            $posts = json_decode($posts);
        }
        return response()->json($posts, 200);

    }

    public function store(Request $request)
    {
        $post = Post::create($request->all());
        return response()->json($post, 201);
    }

    public function show($id)
    {
        $key = "post_{$id}";

        $post = CustomCache::get($key);
        if (!$post) {
            $post = Post::find($id);
            if ($post) {
                CustomCache::put($key, $post->toJson(), 600); // Cache for 10 minutes
            } else {
                return response()->json(['message' => 'Post not found'], 404);
            }
        } else {
            $post = json_decode($post);
        }

        return response()->json($post, 200);
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->update($request->all());
        return response()->json($post, 200);
    }

    public function destroy($id)
    {
        Post::destroy($id);
        return response()->json(null, 204);
    }
}

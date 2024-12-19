<?php

namespace App\Observers;

use App\Facades\CustomCache;
use App\Models\Post;

class PostObserver
{
    public function created(Post $post)
    {
        CustomCache::forget("posts");
    }

    public function updated(Post $post)
    {
        CustomCache::forget("post_{$post->id}");
        CustomCache::forget("posts");
    }

    public function deleted(Post $post)
    {
        CustomCache::forget("post_{$post->id}");
        CustomCache::forget("posts");
    }

}

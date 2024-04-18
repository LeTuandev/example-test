<?php

namespace App\Services\Api;

use Illuminate\Http\Response;
use App\Models\Post;
use App\Http\Resources\PostResource;

class PostService
{
    public function getIndexData()
    {
        $post = Post::all();
        return [
            'status' => 200,
            'message' => 'success',
            'data' => PostResource::collection($post),
        ];
    }

    public function createPost(array $data)
    {
        $data['user_id'] = auth()->user()->id;
        $post = Post::create($data);
        return [
            'status' => 200,
            'message' => 'success',
            'data' => PostResource::make($post),
        ];
    }

    public function updatePost(array $data, Post $post)
    {
        $post->update($data);
        return [
            'status' => 200,
            'message' => 'success',
            'data' => PostResource::make($post),
        ];
    }

    public function deletePost(Post $post)
    {
        $post->delete();
        return [
            'status' => 200,
            'message' => 'success',
            'data' => [],
        ];
    }
}

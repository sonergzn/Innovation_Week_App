<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\likes;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

class PostLikeController extends Controller
{
    public function __construct()
    {
    $this->middleware(['auth' , 'verified' ]);
    }

    public function store(Post $post, Request $request)
    {
        likes::create([
            'user_id' => $request->user()->id,
            'post_id' => $post->id
        ]);

        Log::channel('abuse')->info("Liking the post with ID ".$post->id." by user", ['user_id' => $request->user()->id]);
        return back();
    }

    public function destroy(Post $post, Request $request)
    {
        $request->user()->likes()->where('post_id', $post->id)->delete();

        Log::channel('abuse')->info("Unliking the post with ID ".$post->id." by user", ['user_id' => $request->user()->id]);
        return back();
    }
}

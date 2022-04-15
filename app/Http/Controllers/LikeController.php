<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

//    public function handleLike($likeable)
//    {
//        $user = auth()->user();
//
//        if($user->hasLiked($likeable)){
//
//        }
//
//        user()->like($post);
//
//        $post->likes()->create([
//            'user_id' => $request->user()->id,
//        ]);
//        Log::channel('abuse')->info("Liking the post with ID ".$post->id." by user", ['user_id' => $request->user()->id]);
//        return back();
//    }
//
//    public function destroy(Post $post, Request $request)
//    {
//        $request->user()->likes()->where('post_id', $post->id)->delete();
//        Log::channel('abuse')->info("Unliking the post with ID ".$post->id." by user", ['user_id' => $request->user()->id]);
//        return back();
//    }
}

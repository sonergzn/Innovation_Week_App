<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified'], ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $post_id)
    {
        $request->validate(['content' => 'required']);

        $post = Post::find($post_id);
        $user = auth()->user();

        $comment = Comment::create([
            'content' => htmlspecialchars($request->input('content')),
            'author_id' => $user->id,
            'post_id' => $post->id
        ]);

        $url = URL::temporarySignedRoute('posts.show', now()->addMinutes(30), ['id' => $post->id]);
        if (!$request->hasValidSignature()) {
            return redirect()->route('index');
        }
        else{
            return redirect($url);
            //URL::SignedRoute('posts.workspace');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::find($id);
        $comment->delete();
        Log::channel('abuse')->info("DELETING the Comment With id ".$id. " by user", ['user_id' => auth()->user()->id]);
        return redirect()->back()->with('status','Comment Deleted Successfully');
    }
}

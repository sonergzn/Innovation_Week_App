<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\RedirectResponse;

class PostController extends Controller
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

    public function getpostsbyid($id){
        $post = Post::where('id', $id)->first();
        return response()->json($post);
    }

    public function getposts(){
        $posts = Post::all();
        return response()->json($posts);
    }



    public function index(Request $request)
    {
        $posts =  Post::orderBy('updated_at', 'DESC')->paginate(6);

        $posts->withPath($request->fullUrlWithoutQuery('page'));

        Log::channel('abuse')->info("Showing the Blog PAGE by user ");
        $url = URL::temporarySignedRoute('posts.workspace', now()->addMinutes(30));
        //if (! $request->hasValidSignature()) {
          //  return redirect()->route('index')->with('info', 'Please use the navigation bar to navigate !');
        //}
      //  else{
            return view("blog.index")->with('posts', $posts)->with($url);
        //}
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function workspace(Request $request)
    {
        $posts = auth()->user()->posts();

        Log::channel('abuse')->info("Showing the Blog PAGE by user ".auth()->user()->id);
        $url = URL::temporarySignedRoute('posts.workspace', now()->addMinutes(30));
        if (! $request->hasValidSignature()) {
            return redirect()->route('index');
        }
        else{
            return view("blog.workspace")->with('posts', $posts->orderBy('updated_at', 'DESC')->get())->with($url);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        Log::channel('abuse')->info("create blog page is called by user ". auth()->user()->id);
        if (! $request->hasValidSignature()) {
            //abort(401);
            return redirect()->route('index');
        }
        else{
            return view('blog.create')->with('info', 'Please Login first');
        }


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $dateS = Carbon::now()->startOfMonth()->subMonth(1);
        $dateE = Carbon::now();

        $posts = Post::all()->whereBetween('created_at',[$dateS, $dateE]);

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'image' => 'required|mimes:jpg,png,jpeg|max:5048'
        ]);


        if ($validator->fails()) {
            return redirect(URL::temporarySignedRoute('workspace.create', now()->addMinutes(30)))->with('error', Arr::first(Arr::flatten($validator->messages()->get('*'))));
        }

        $newImageName = uniqid() . '-' . $request->title . '-' . $request->image->extension();

        $request->image->move(public_path('images'), $newImageName);


        $post = Post::create([
            'title'=> $request->input('title'),
            'slug'=> Str::random(5),
            'content' => $request->input('content'),
            'image_path' => $newImageName,
            'author_id' => auth()->user()->id
        ]);

        $user->posts()->attach($post);
        Log::channel('abuse')->info("Creating the Post With title ".$request->input('title'). " by user", ['user_id' => $request->user()->id]);
        return redirect()->route('posts.store', compact('posts'))->with('info', 'Your Post has been added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        //$post = Post::where('id', $id)->first();
        $post = Post::findOrFail($id);
        $comments = $post->comments()->paginate(5);
        //Log::channel('abuse')->info("SHOWING the Post With ID ".$id. " by user", ['user_id' => auth()->user()->id]);
        $comments->withPath($request->fullUrlWithoutQuery('page'));
        $url = URL::temporarySignedRoute('posts.workspace', now()->addMinutes(30));

            if(Auth::check()){
            return view('blog.show', compact('post', 'comments'));
        } else{
            return redirect('/login');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editors(Request $request, $id)
    {

        $post = Post::where('id', $id)->first();

        // pending editors
        $invites = $post->invites()->get();

        // non-pending editors
        $editors = $post->editors()->get();
//        if (! $request->hasValidSignature()) {
//            echo "hello";
//            //abort(401);
//           // return redirect()->route('index')->with('info', 'Please use the navigation bar to navigate !');
//        }
//        else{
         return view('blog.editors', compact('post', 'invites', 'editors'));
//        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $post = Post::where('id', $id)->first();
        Log::channel('abuse')->info("EDITING the Post With id ".$id. " by user", ['user_id' => auth()->user()->id]); //Logging
        $url = URL::temporarySignedRoute('posts.workspace', now()->addMinutes(30));
        if (! $request->hasValidSignature()) {
            //abort(401);
            return redirect()->route('index');
        }
        else{
            return view('blog.edit', compact('post'))->with($url);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'image' => 'required|mimes:jpg,png,jpeg|max:5048'
        ]);



        if ($validator->fails()) {
            return redirect(URL::temporarySignedRoute('workspace.edit', now()->addMinutes(30), ['id' => $request->id]))->with('error', Arr::first(Arr::flatten($validator->messages()->get('*'))));
        }

        $UpdatednewImageName = uniqid() . '-' . $request->title . '-' . $request->image->extension();
        $actualPost = Post::find($request->id);

        $request->image->move(public_path('images'), $UpdatednewImageName);

        $actualPost->title = $request->input('title');
        $actualPost->content = $request->input('content');
        //$actualPost->user->id = $request->Auth::user()->id;
        $actualPost->image_path = $UpdatednewImageName;
        $actualPost->update();
        Log::channel('abuse')->info("UPDATING the Post With Title ".$request->input('title'). " by user", ['user_id' => $request->user()->id]);
        return redirect('/blog')->with('message', 'Post has been updated !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();
        Log::channel('abuse')->info("DELETING the Post With id ".$id. " by user", ['user_id' => auth()->user()->id]);
        return redirect()->back()->with('status','Post Deleted Successfully');
    }
}

<?php

namespace App\Http\Controllers;

use App\Mail\GetMyDataMail;
use App\Models\likes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Mail\getdata;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserPageController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified'], ['except' => ['index', 'show']]);
    }

    public function index(Request $request)
    {
        $userid = Auth::id();
        //$userposts = Auth::user()->posts()->get();
        $userposts = DB::table('posts')->where('author_id', auth()->id())->get();

        Log::channel('abuse')->info("Showing the users profile PAGE by user ".auth()->user()->id);
        //dd($userposts);
        return view("user.userhome", compact('userposts'));
    }



    public function edit()
    {
        $user = Auth::user();
        Log::channel('abuse')->info("Showing the users EDIT PAGE by user ".auth()->user()->id);
        return view("user.useredit", compact('user'));
    }

    public function update()
    {
        $userid = Auth::id();
        $dataform = request();

        $user = \App\Models\User::findOrfail($userid);

         $dataform->validate([
            'name' => 'required|max:30|min:2',
            'email' => 'required|email:rfc,dns'
            ]);

        $user->name = $dataform->name;
        $user->email = $dataform->email;
        $user->save();

        $user = Auth::user();
        return redirect('/userpage')->with('Success', "updated successfully");

    }

    public function delete($id)
    {
        if(Auth::check()){
           $user = User::find($id);
           $user->likes()->delete();
           $user->posts()->delete();
           $user->delete();
            return redirect('/')->with('info', 'Your account has been deleted!');
            Log::channel('abuse')->info("DELETING USER ".auth()->user()->id);
        }
        else{
            return redirect('/')-with('info', 'Please Login');
        }
    }

    public function getdata(){
        //dd(Auth::user());
        $userposts = Post::all()->where('user_id', Auth::user()->id);
        Mail::to(Auth::user()->email)->send(new GetMyDataMail());

        return view('user.userhome', compact('userposts'))
        ->with('info', 'Your data has been send to your email address '.Auth::user()->email);
    }

}

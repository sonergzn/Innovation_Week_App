<?php

namespace App\Http\Controllers;

use App\Mail\InviteEmail;
use App\Models\Invite;
use App\Models\Post;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class InviteController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified'], ['except' => ['index', 'show']]);
    }

    public function toMail($mailDetails, $email)
    {
        $details = [
            'url' => $mailDetails['url'],
            'post' => $mailDetails['post']->title,
            'author' => $mailDetails['author']->first()->name,
        ];

        Mail::to($email)->send(new InviteEmail($details));

        if (Mail::failures() != 0) {
            return "Email has been sent successfully.";
        }
        return "Email could not be sent.";
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invite = Invite::find($id);
        $invite->delete();
        Log::channel('abuse')->info("DELETING the invite With id ".$id. " by user", ['user_id' => auth()->user()->id]);

        return redirect()->back()->with('status','Invite Deleted Successfully');
    }

    public function send(Request $request, $post_id)
    {
        $post = Post::find($post_id);

        $request->validate([
            'email' => 'required|email'
        ]);

        $email = $request->input('email');


        if(!User::where('email', $email)->first()){
            return redirect()->route('posts.editors', $post_id)->with('error', 'Email is not registered !');
        }

        if(Invite::where('email', $email)->where('post_id', $post_id)->first()){
            return redirect()->route('posts.editors', $post_id)->with('error', 'Email already sent !');
        }

        if($post->hasEditor($email)){
            return redirect()->route('posts.editors', $post_id)->with('error', 'User is already editor !');
        }

        do {
            $token = Str::random(20);
        } while (Invite::where('token', $token)->first());

        $expiration = new DateTime('+1 day');

        Invite::create([
            'token' => $token,
            'email' => $request->input('email'),
            'post_id' => $post->id,
            'expired_at' => $expiration
        ]);

        $url = URL::temporarySignedRoute(
            'invites.handle', now()->addDays(1), ['token' => $token]
        );

        $mailDetails = [
            'url' => $url,
            'post' => $post,
            'author' => $post->author()
        ];

        $this->toMail($mailDetails, $request->input("email"));

        return Redirect::back()->with('success', 'The Invite has been sent successfully');
    }

    public function handle(Request $request){
        if (! $request->hasValidSignature()) {
            //abort(401);
            return redirect()->route('index');
        }

        $token = $request->query('token');
        $invite = Invite::where('token', $token)->first();

        if(!$invite){
            return redirect('/blog')->with('message', 'Invite does not exist !');
        }

        $email = $invite->email;
        $user = User::where('email', $email)->first();

        if(auth()->user()->id !== $user->id){
            return redirect('/blog')->with('message', 'You not to be logged in !');
        }

        $post = Post::where('id', $invite->post_id)->first();
        $post->editors()->attach($user->id);

        $invite->delete();
        $url = URL::temporarySignedRoute('posts.workspace', now()->addMinutes(30));
        return redirect()->route('posts.workspace');
    }
}

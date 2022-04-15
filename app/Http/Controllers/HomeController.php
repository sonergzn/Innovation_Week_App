<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware(['auth', 'verified']);
        Log::channel('abuse')->info("Redirected to login Page ");
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dateS = Carbon::now()->startOfMonth()->subMonth(3);
        $dateE = Carbon::now();

        $posts = Post::all()->whereBetween('created_at',[$dateS, $dateE]);
        Log::channel('abuse')->info("Showing the INDEX PAGE");

        //return view('index', compact('posts'));
        
        return response()
        ->view('index', compact('posts'))
        ->header('Content-Type', 'text/html');
    }
}

<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Post;

class PagesController extends Controller
{
    public function index() {
        $dateS = Carbon::now()->startOfMonth()->subMonth(1);
        $dateE = Carbon::now(); 
 
        $posts = Post::all()->whereBetween('created_at',[$dateS, $dateE]);
        if($posts == null){
            return view('index');
        }else{
            return view('index', compact('posts'));
        }
        
        //return view('index', compact('posts'));
    }
}

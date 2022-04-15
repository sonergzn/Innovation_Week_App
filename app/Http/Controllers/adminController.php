<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class adminController extends Controller
{

    public function destroy($id){

        if(Auth::check()){
            $user = User::find($id);
            $user->likes()->delete();
            $user->posts()->delete();
            $user->delete();
            return redirect('/')->with('info', 'account has been deleted!');
         }
         else{
            return redirect('/')-with('info', 'Please Login');
         }
    }

    public function index()
    {
        $isadmin = Auth::user()->isadmin;
        $users = User::all();

        If($isadmin == 1){
            return view('admin.index', compact('users'));
        }
        else {
            return redirect('/')->with('info', "insufficient rights");
        }
    }

    public function promoteview($userid){

        if (Auth::user()->isadmin == 1){
            $user = \App\Models\User::findOrFail($userid);
            return view('admin.promoteadmin',compact('user'));
        }else
        {
            return back();
        }
    }


    public function update(Request $request){


        $nonadminuser = \App\Models\User::findOrFail($request->id);

        $validatedData = $request->validate([
            'isadmin' => 'required|numeric'
        ]);

        $nonadminuser->isadmin = $request->isadmin;
        $nonadminuser->save();

        $users = \App\Models\User::all();

        return view('admin.index',compact('users'));
    }

     public function search(Request $request){

        //$searchString = $request->query('searchTerms');
        $searchString = $request->searchTerms;
        if($searchString){
           $users = \App\Models\User::where('name','LIKE','%'.$searchString.'%')->get();
           return view('admin.index',compact('users'));
        }
        else
        {
            $users = \App\Models\User::all();
            return view('admin.index',compact('users'));
        }
    }

    public function blockhtaccess()
    {
        return redirect('/');
    }

 
}

<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\UserPageController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\EditorController;
use App\Http\Controllers\adminController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('index');

//Auth::routes(['verify' => true]);

Route::get('/', [PagesController::class, 'index'])->name('index');

Route::post('/adminpage/promoteadmin', [adminController::class, 'update'])->name('admin.promoteuser')->middleware('auth');


Route::get('/blog/workspace', [PostController::class, 'workspace'])->name('posts.workspace')->middleware('auth');

Route::get('/blog', [PostController::class, 'index'])->name('posts.index');

Route::get('/blog/{id}', [PostController::class, 'show' ])->name('posts.show');

Route::get('/blog/create', [PostController::class, 'create'])->name('posts.create.post')->middleware('auth');

Route::post('/blog', [PostController::class, 'store'])->name('posts.store');


Route::get('/blog/{id}/edit', [PostController::class, 'edit',])->name('posts.edit.post');

Route::put('/blog/{id}', [PostController::class ,'update'])->middleware('auth');

Route::delete('/blog/{id}', [PostController::class, 'destroy'])->middleware('auth');

Route::post('/blog/{post}/likes', [PostLikeController::class, 'store'])->name('posts.likes');

Route::delete('/blog/{post}/likes', [PostLikeController::class, 'destroy'])->name('posts.likes.delete');


Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/userpage', [UserPageController::class, 'index'])->name('user.page.index')->middleware(('verified'));

Route::get('/userpage/{userid}', [UserPageController::class, 'edit'])->name('User.edit');

Route::put('/userpage/{userid}', [UserPageController::class, 'update'])->middleware('auth')->name('editprofile');

Route::delete('/userpage/{userid}', [UserPageController::class, 'delete'])->middleware('auth')->name('deleteprofile');

Route::get('/userpage/data/{user_id}', [UserPageController::class, 'getdata'])->name('user.getdata')->middleware('auth');

// Workspace

Route::get('/blog/workspace/create', [PostController::class, 'create'])->name('workspace.create')->middleware('auth');
Route::get('/blog/workspace/{id}/edit', [PostController::class, 'edit',])->name('workspace.edit');
Route::put('/blog/workspace/{id}', [PostController::class ,'update'])->middleware('auth');

// Comments
Route::post('comments/{post_id}', [CommentController::class, 'store'])->name('comments.store');
Route::delete('comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');
// Invites
Route::post('/invites/{post_id}', [InviteController::class, 'send'])->name('invites.send');
Route::get('/invites', [InviteController::class, 'handle'])->name('invites.handle');
Route::delete('/invites/{id}', [InviteController::class, 'destroy'])->name('invites.destroy');
// Editors
Route::get('/blog/{id}/editors', [PostController::class, 'editors' ])->name('posts.editors');
Route::delete('/blog/{id}/editors', [EditorController::class, 'destroy' ])->name('editors.destroy');

//Route::get('/api/getposts', [\App\Http\Controllers\PostController::class, 'getposts'])->name('getposts');
//Route::get('/api/getposts/{id}', [\App\Http\Controllers\PostController::class, 'getpostsbyid'])->name('getpostsbyid');
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Admin Routes

Route::delete('/adminpage/{userid}', [adminController::class, 'destroy'])->middleware('auth')->name('destroy.user.admin');
Route::put('/adminpage', [adminController::class, 'update'])->name('admin.promoteview')->middleware('auth');
Route::get('/adminpage', [adminController::class, 'index'])->name('admin.index')->middleware('auth');
Route::get('/adminpage/promoteadmin/{userid}', [adminController::class, 'promoteview'])->name('promoteviewuser')->middleware('auth');

Route::get('/adminpage/promoteadmin', [adminController::class, 'search'])->name('search.adminusers')->middleware('auth');


Route::get('/.htaccess', [adminController::class, 'blockhtaccess'])->name('block.htaccess')->middleware('auth');

Route::get('/privacy', function () {
    return view('privacyPolicy');
})->name('privacy');


<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

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

//Base
Route::get('/', function () {
    return view('welcome');
})->middleware(['guest'])->name('home');


//Posts
Route::redirect('/dashboard', '/posts');
Route::get('/posts', [PostController::class, 'index'])
    ->middleware(['auth'])->name('posts.index');
Route::get('/posts/create', [PostController::class, 'create'])
    ->middleware(['auth'])->name('posts.create');
Route::post('/posts/store', [PostController::class, 'store'])
    ->middleware(['auth'])->name('posts.store');

//Comments
Route::post('/comments', [CommentController::class, 'store'])
    ->middleware(['auth'])->name('comments.store');

require __DIR__.'/auth.php';
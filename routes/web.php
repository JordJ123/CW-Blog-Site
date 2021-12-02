<?php

use Illuminate\Support\Facades\Route;
use App\MailHandler;
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

//Routes - Home
Route::get('/', function () {
    return view('welcome');
})->middleware(['guest'])->name('home');


//Routes - Posts
Route::redirect('/dashboard', '/posts');
Route::get('/posts', [PostController::class, 'index'])
    ->middleware(['auth'])->name('posts.index');
Route::get('/posts/create', [PostController::class, 'create'])
    ->middleware(['auth'])->name('posts.create');
Route::get('/posts/{id}/edit', [PostController::class, 'edit'])
    ->middleware(['auth'])->name('posts.edit');
Route::post('/posts/store', [PostController::class, 'store'])
    ->middleware(['auth'])->name('posts.store');
Route::put('/posts/{id}', [PostController::class, 'update'])
    ->middleware(['auth'])->name('posts.update');

//Routes - Comments
Route::post('/comments', [CommentController::class, 'store'])
    ->middleware(['auth'])->name('comments.store');

require __DIR__.'/auth.php';
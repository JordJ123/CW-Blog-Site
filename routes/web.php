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

//Home
Route::get('/', function () {
    return view('welcome');
})->middleware(['guest'])->name('home');


//Posts
Route::redirect('/dashboard', '/posts');
Route::get('/posts', [PostController::class, 'index'])
    ->middleware(['auth'])->name('posts.index');
Route::get('/posts/indexJSON', [PostController::class, 'indexJSON'])
    ->middleware(['auth'])->name('posts.indexJSON');
Route::get('/posts/create', [PostController::class, 'create'])
    ->middleware(['auth'])->name('posts.create');
Route::get('/posts/{id}/edit', [PostController::class, 'edit'])
    ->middleware(['auth'])->name('posts.edit');
Route::post('/posts/store', [PostController::class, 'store'])
    ->middleware(['auth'])->name('posts.store');
Route::put('/posts/{id}', [PostController::class, 'update'])
    ->middleware(['auth'])->name('posts.update');
Route::patch('/posts/{id}/like/{like}', [PostController::class, 'updateLike'])
    ->middleware(['auth'])->name('posts.updateLike');
Route::delete('/posts/{id}', [PostController::class, 'destroy'])
    ->middleware(['auth'])->name('posts.destroy');
Route::delete('/posts/{id}/imageFile', [PostController::class, 'destroyImageFile'])
    ->middleware(['auth'])->name('posts.destroyImageFile');


//Comments
Route::get('/comments/{id}/edit', [CommentController::class, 'edit'])
    ->middleware(['auth'])->name('comments.edit');
Route::post('/comments', [CommentController::class, 'store'])
    ->middleware(['auth'])->name('comments.store');
Route::put('/comments/{id}', [CommentController::class, 'update'])
    ->middleware(['auth'])->name('comments.update');
Route::patch('/comments/{id}/like/{like}', [CommentController::class, 'updateLike'])
    ->middleware(['auth'])->name('comments.updateLike');
Route::delete('/comments/{id}', [CommentController::class, 'destroy'])
    ->middleware(['auth'])->name('comments.destroy');

require __DIR__.'/auth.php';
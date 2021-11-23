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
    if (auth()->check()) {
        return redirect('/posts');
    }
    return view('welcome');
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
require __DIR__.'/auth.php';

//Posts
Route::redirect('/dashboard', '/posts');
Route::get('/posts', [PostController::class, 'index'])
    ->middleware(['auth'])->name('posts.index');

//Comments
Route::post('/comments', [CommentController::class, 'store'])
    ->middleware(['auth'])->name('comments.store');
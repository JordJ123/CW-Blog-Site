<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Image;
use App\Classes\Email;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::all();
        if ($request['page'] && ($request['page'] * 5) <= ($posts->count() + 4)
            || $request['page'] && ($posts->count() == 0)) {
            $page = $request['page'];
            return view('posts.index', 
                ['posts' => $posts, 'page' => $page]);
        } else {
            return redirect()->route('posts.index', ['page' => 1]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'text' => 'required|max:255',
        ]);

        if ($request->hasFile('file')) {
            $imageData = $request->validate([
                'image' => 'mimes:jpeg,bmp,png',
                'imageText' => 'required|max:255',
            ]);
            $request->file->move(public_path('images'), $request->file->hashName());
            $image = new Image;
            $image->path = $request->file->hashName();
            $image->text = $imageData['imageText'];
            $image->post_id = auth()->user()->id;  
            $image->save();
        }

        $post = new Post;
        $post->text = $validatedData['text'];
        $post->user_id = auth()->user()->id;
        $post->save();

        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $validatedData = $request->validate([
            'text' => 'required|max:255',
        ]);

        $post = Post::findOrFail($id);
        $post->text = $validatedData['text'];
        $post->save();

        $sender = new User;
        $sender->name = "Posts R Us";
        $sender->email = "postsrus@email.com";
        $subject = "Edited Post";
        foreach ($post->likes()->get() as $recipent) {
            if ($recipent != $post->user()) {
                $email = new Email($sender, $recipent, $subject, 'emails.edited', 
                ['resource' => $post, 'type' => "post", 'status' => "liked"]);
                $email->send();
            }
        }
        foreach ($post->comments()->get() as $comment) {
            if ($comment->user()->first() != $post->user()->first()) {
                $email = new Email($sender, $comment->user()->first(), $subject, 
                'emails.edited', 
                ['resource' => $post, 'type' => "post", 'status' => "commented on"]);
                $email->send();
            }    
        }

        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

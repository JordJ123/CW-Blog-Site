<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
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
        $post = new Post;
        $post->text = $validatedData['text'];
        $post->user_id = auth()->user()->id;
        $post->save();

        if ($request->hasFile('file')) {
            $imageData = $request->validate([
                'file' => 'mimes:jpeg,bmp,png',
                'imageText' => 'required|max:255',
            ]);
            $image = new Image;
            $image->path = $request->file->hashName();
            $image->text = $imageData['imageText'];
            $image->post_id = $post->id;  
            $image->save();
            $request->file->move(public_path('images'), $request->file->hashName());
        }

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
        
        //Post
        $post = Post::findOrFail($id);
        $post->text = $validatedData['text'];
        $post->save();

        //Image Text
        if ($post->image()->first() != null) {
            $image = $post->image()->first();
            $validatedData = $request->validate([
                'imageText' => 'required|max:255',
            ]);
            $image->text = $validatedData['imageText'];
            $image->save();
        }

        //Image File
        if ($request->hasFile('file')) {
            $imageData = $request->validate([
                'file' => 'required|mimes:jpeg,bmp,png',
                'imageText' => 'required|max:255',
            ]);

            $image = new Image;
            $image->path = $request->file->hashName();
            if ($post->image()->first() != null) {
                $oldImage = $post->image()->first();
                $text = $oldImage->text;
                File::delete(public_path("images/" . $oldImage->path));
                $oldImage->delete();
            } else {
                $validatedData = $request->validate([
                    'imageText' => 'required|max:255',
                ]);
                $text = $validatedData['imageText'];
            }
            $image->text = $text;
            $image->post_id = $post->id;  
            $image->save();
            $request->file->move(public_path('images'), $request->file->hashName());
        }        

        //Email
        $sender = new User;
        $sender->name = "Posts R Us";
        $sender->email = "postsrus@email.com";
        $subject = "Edited Post";
        foreach ($post->likes()->get() as $recipent) {
            if ($recipent->id != $post->user()->id) {
                $email = new Email($sender, $recipent, $subject, 'emails.edited', 
                ['resource' => $post, 'type' => "post", 'status' => "liked"]);
                $email->send();
            }
        }
        foreach ($post->comments()->get() as $comment) {
            if ($comment->user()->first()->id != $post->user()->first()->id) {
                $email = new Email($sender, $comment->user()->first(), $subject, 
                'emails.edited', 
                ['resource' => $post, 'type' => "post", 'status' => "commented on"]);
                $email->send();
            }    
        }

        return redirect()->route('posts.index');
    }

    /**
     * Like/Unlike the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @param  int  $like
     * @return \Illuminate\Http\Response
     */
    public function updateLike(Request $request, $id, $like)
    {

        $post = Post::findOrFail($id);
        if ($like == "true") {
            $post->likes()->attach(auth()->user()->id);
        } else {
            $post->likes()->detach(auth()->user()->id);
        }

        $sender = new User;
        $sender->name = "Posts R Us";
        $sender->email = "postsrus@email.com";
        $recipent = $post->user()->first();
        $subject = "Post Interaction";
        if ($recipent->id != auth()->user()->first()->id) {
            $email = new Email($sender, $recipent, $subject, 'emails.liked', 
            ['resource' => $post, 'type' => "post", 
                'user' => auth()->user()->first()->name]);
            $email->send();
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
        
        $post = Post::findOrFail($id);
        $post->delete();

        $sender = new User;
        $sender->name = "Posts R Us";
        $sender->email = "postsrus@email.com";
        $subject = "Deleted Post";
        foreach ($post->likes()->get() as $recipent) {
            if ($recipent->id != $post->user()) {
                $email = new Email($sender, $recipent, $subject, 'emails.deleted', 
                ['resource' => $post, 'type' => "post", 'status' => "liked"]);
                $email->send();
            }
        }
        foreach ($post->comments()->get() as $comment) {
            if ($comment->user()->first()->id != $post->user()->first()->id) {
                $email = new Email($sender, $comment->user()->first(), $subject, 
                'emails.deleted', 
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
    public function destroyImageFile($id)
    {
        
        $post = Post::findOrFail($id);
        $image = $post->image()->first();
        File::delete(public_path("images/" . $image->path));
        $image->delete();

        return redirect()->route('posts.index');

    }

}

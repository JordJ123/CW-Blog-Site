<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Image;
use App\EmailService;

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
     * Display a listing of the resource in json format.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexJSON(Request $request)
    {
        $allPosts = Post::all();
        $posts = array();
        $end = min($request['page'] * 5, $allPosts->count());
        for ($i = (($request['page'] - 1) * 5); $i < $end; $i++) {
            array_push($posts, $allPosts->reverse()->values()[$i]);
        }
        return $posts;
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
    public function update(Request $request, $id, EmailService $emailService)
    {

        $validatedData = $request->validate([
            'text' => 'required|max:255',
        ]);
        
        //Post
        $post = Post::findOrFail($id);
        $oldText = $post->text;
        $post->text = $validatedData['text'];
        $post->save();

        //Image File (Old)
        $image = $post->image()->first();
        if ($request['deleteImage'] == "true") {
            File::delete(public_path("images/" . $image->path));
            $image->delete();
        } else if ($image != null) {
            $validatedData = $request->validate([
                'imageText' => 'required|max:255',
            ]);
            $image->text = $validatedData['imageText'];
            $image->save();
        }

        //Image File (New)
        if ($request->hasFile('file')) {
            $validatedData = $request->validate([
                'file' => 'required|mimes:jpeg,bmp,png',
                'imageText' => 'required|max:255',
            ]);
            $image = new Image;
            $image->path = $request->file->hashName();
            $image->text = $validatedData['imageText'];
            $image->post_id = $post->id;  
            $image->save();
            $request->file->move(public_path('images'), $request->file->hashName());
        }   

        //Email
        $subject = "Edited Post";
        foreach ($post->likes()->get() as $recipent) {
            if (($recipent->id != $post->user()->first()->id) 
                && ($recipent->id != auth()->user()->id)) {
                $emailService->email($recipent, $subject, 'emails.edited', 
                ['resource' => $post, 'type' => "post", 'status' => "liked"]);
            }
        }
        foreach ($post->comments()->get() as $comment) {
            if (($comment->user()->first()->id != $post->user()->first()->id)
                && ($comment->user()->first()->id != auth()->user()->id)) {
                $emailService->email($comment->user()->first(), $subject, 'emails.edited', 
                ['resource' => $post, 'type' => "post", 'status' => "commented on"]);
            }    
        }
        if ($post->user()->first()->id != auth()->user()->id) {
            $emailService->email($post->user()->first(), "Administrator Edit", 'emails.adminEdit', 
                ['resource' => $post, 'type' => "posts", 'oldText' => $oldText]);
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
    public function updateLike(Request $request, $id, $like, EmailService $emailService)
    {

        $post = Post::findOrFail($id);
        if ($like == "true") {
            $post->likes()->attach(auth()->user()->id);
            $status = "liked";
        } else {
            $post->likes()->detach(auth()->user()->id);
            $status = "unliked";
        }

        $recipent = $post->user()->first();
        $subject = "Post Interaction";
        if ($recipent->id != auth()->user()->id) {
            $emailService->email($recipent, $subject, 'emails.liked', 
            ['resource' => $post, 'type' => "post", 'status' => $status,
            'user' => auth()->user()->name]);
        }

        return null;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, EmailService $emailService)
    {

        $post = Post::findOrFail($id);

        $subject = "Deleted Post";
        foreach ($post->likes()->get() as $recipent) {
            if (($recipent->id != $post->user()->first()->id)
                && ($recipent->id != auth()->user()->id)) {
                $emailService->email($recipent, $subject, 'emails.deleted', 
                ['resource' => $post, 'type' => "post", 'status' => "liked"]);
            }
        }
        foreach ($post->comments()->get() as $comment) {
            if (($comment->user()->first()->id != $post->user()->first()->id)
                && ($comment->user()->first()->id != auth()->user()->id)) {
                $emailService->email($comment->user()->first(), $subject, 
                'emails.deleted', 
                ['resource' => $post, 'type' => "post", 'status' => "commented on"]);
            }    
        }
        if ($post->user()->first()->id != auth()->user()->id) {
            $emailService->email($post->user()->first(), "Administrator Delete", 
                'emails.adminDelete', ['resource' => $post, 'type' => "posts"]);
        }

        
        $post->delete();

        return null;

    }

}

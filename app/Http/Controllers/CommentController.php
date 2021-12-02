<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Classes\Email;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'post_id' => 'required|integer',
        ]);

        $comment = new Comment;
        $comment->text = $validatedData['text'];
        $comment->user_id = auth()->user()->id;
        $comment->post_id = $validatedData['post_id'];
        $comment->save();

        $sender = new User;
        $sender->name = "Posts R Us";
        $sender->email = "postsrus@email.com";
        $recipent = Post::findOrFail($comment->post_id)->user()->first();
        $subject = "Posted Comment";
        $email = new Email($sender, $recipent, 
            $subject, 'emails.comment', ['comment' => $comment]);
        $email->send();

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
        //
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
        //
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\EmailService;

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
    public function store(Request $request, EmailService $emailService)
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

        $recipent = Post::findOrFail($comment->post_id)->user()->first();
        $subject = "Posted Comment";
        if ($recipent->id != auth()->user()->id) {
            $emailService->email($recipent, $subject, 'emails.comments.comment', 
                ['post' => Post::findOrFail($comment->post_id), 'comment' => $comment]);
        }
        return $comment;

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
        $comment = Comment::findOrFail($id);
        return view('comments.edit', ['comment' => $comment]);
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

        $comment = Comment::findOrFail($id);
        $oldComment = new Comment;
        $oldComment->text = $comment->text;
        $oldComment->user_id = $comment->user_id;
        $comment->text = $validatedData['text'];
        $comment->save();

        $recipent = Post::findOrFail($comment->post_id)->user()->first();
        $subject = "Editted Comment";
        if (($recipent->id != $comment->user()->first()->id)
            && ($recipent->id != auth()->user()->id)) {
            $emailService->email($recipent, $subject, 'emails.comments.edited', 
                ['resource' => $comment, 'oldResource' => $oldComment, 'type' => "comment", 
                'status' => "on your post"]);
        }
        foreach ($comment->likes()->get() as $recipent) {
            if (($recipent->id != $comment->user()->first()->id)
                && ($recipent->id != auth()->user()->id)) {
                $emailService->email($recipent, $subject, 'emails.comments.edited', 
                    ['resource' => $comment, 'oldResource' => $oldComment, 'type' => "comment", 
                    'status' => "liked"]);
            }
        }
        if ($comment->user()->first()->id != auth()->user()->id) {
            $emailService->email($comment->user()->first(), "Administrator Edit", 
                'emails.comments.adminEdit', 
                ['resource' => $comment, 'oldResource' => $oldComment, 'type' => "posts"]);
        }

        return null;

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

        $comment = Comment::findOrFail($id);
        if ($like == "true") {
            $comment->likes()->attach(auth()->user()->id);
            $status = "liked";
        } else {
            $comment->likes()->detach(auth()->user()->id);
            $status = "unliked";
        }

        $recipent = $comment->user()->first();
        $subject = "Comment Interaction";
        if ($recipent->id != auth()->user()->id) {
            $emailService->email($recipent, $subject, 'emails.comments.liked', 
                ['resource' => $comment, 'type' => "comment", 'status' => $status,
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

        $comment = Comment::findOrFail($id);

        $recipent = Post::findOrFail($comment->post_id)->user()->first();
        $subject = "Deleted Comment";
        if (($recipent->id != $comment->user()->first()->id)
            && ($recipent->id != auth()->user()->id)) {
            $emailService->email($recipent, $subject, 'emails.comments.deleted', 
            ['resource' => $comment, 'type' => "comment", 'status' => "on your post"]);
        }
        foreach ($comment->likes()->get() as $recipent) {
            if (($recipent->id != $comment->user()->first()->id)
                && ($recipent->id != auth()->user()->id)) {
                $emailService->email($recipent, $subject, 'emails.comments.deleted', 
                ['resource' => $comment, 'type' => "comment", 'status' => "liked"]);
            }
        }
        if ($comment->user()->first()->id != auth()->user()->id) {
            $emailService->email($comment->user()->first(), "Administrator Delete", 
                'emails.comments.adminDelete', ['resource' => $comment, 'type' => "posts"]);
        }

        $comment->delete();

        return null;

    }
}

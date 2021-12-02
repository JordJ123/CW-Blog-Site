@extends('layouts.email')

<div>
    <p>A comment has been posted on of your posts</p>
    <div>
       <p><b>{{ $comment->user()->first()->name }}</b></p>
       <p>{{ $comment->text }}</p>
    </div>
</div>    
@extends('layouts.app')

@section('title', 'Feed')

@section('content')
    @foreach ($posts as $post)
        <div>
            <p><b>{{ $post->user()->first()->name }}</b><p>
            <p>{{ $post->text }}</p>
        </div>
    @endforeach
@endsection
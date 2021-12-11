@extends('layouts.email')

<div>
    <p>Your {{ $type }} has been {{ $status }} by {{ $user }}</p>
    <div>
       <p><b>{{ $resource->user()->first()->name }}</b></p>
       <p>{{ $resource->text }}</p>
    </div>
</div>    
@extends('layouts.email')

<div>
    <p>Your {{ $type }} has been {{ $status }} by {{ $user }}</p>
    <div class="p-3 mb-3 border border-dark">
       <p><b>{{ $resource->user()->first()->name }}</b></p>
       <p>{{ $resource->text }}</p>
    </div>
</div>    
@extends('layouts.email')

<div>
    <p>One of your {{ $type }} has been editted by an administrator</p>

    <b>OLD</b>
    <div class="p-3 mb-3 border border-dark">
        <p><b>{{ $oldResource->user()->first()->name }}</b></p>
        <p>{{ $oldResource->text }}</p>
    </div>

    <b>NEW</b>
    <div class="p-3 mb-3 border border-dark">
        <p><b>{{ $resource->user()->first()->name }}</b></p>
        <p>{{ $resource->text }}</p>
    </div>
    
</div>    
@extends('layouts.email')

<div>
    <p>A {{ $type }} you have {{ $status }} has been edited</p>

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

@extends('layouts.email')

<div>
    <p>One of your {{ $type }} has been editted by an administrator</p>

    <b>OLD</b>
    <div class="p-3 mb-3 border border-dark">
        <p><b>{{ $oldResource->user()->first()->name }}</b></p>
        <p>{{ $oldResource->text }}</p>
        @if ($oldImage != null)
            <p><img src="'images/' + {{ $oldImage->path }}" 
                alt="{{ $oldImage->text }}" style="height:128px"/></p>
        @endif
    </div>

    <b>NEW</b>
    <div class="p-3 mb-3 border border-dark">
        <p><b>{{ $resource->user()->first()->name }}</b></p>
        <p>{{ $resource->text }}</p>
        @if ($resource->image()->first() != null)
            <p><img src="'images/' + {{ $resource->image()->first()->path }}" 
                alt="{{ $resource->image()->first()->text }}" style="height:128px"/></p>
        @endif
    </div>
    
</div>    
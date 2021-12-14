@extends('layouts.email')

<div class="p-3 mb-3 border border-dark">
    <p>One of your {{ $type }} has been deleted by an administrator</p>
    <div>
        <p>{{ $resource->text }}</p>
        @if ($resource->image()->first() != null)
            <p><img src="'images/' + {{ $resource->image()->first()->path }}" 
                alt="{{ $resource->image()->first()->text }}" style="height:128px"/></p>
        @endif
    </div>
</div>    
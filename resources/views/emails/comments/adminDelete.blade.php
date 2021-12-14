@extends('layouts.email')

<div class="p-3 mb-3 border border-dark">
    <p>One of your {{ $type }} has been deleted by an administrator</p>
    <div>
        <p>{{ $resource->text }}</p>
    </div>
</div>    
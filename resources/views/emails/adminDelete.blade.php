@extends('layouts.email')

<div>
    <p>One of your {{ $type }} has been deleted by an administrator</p>
    <div>
        <p>{{ $resource->text }}</p>
    </div>
</div>    
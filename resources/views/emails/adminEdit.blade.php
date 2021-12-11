@extends('layouts.email')

<div>
    <p>One of your {{ $type }} has been editted by an administrator</p>
    <div>
        <p><b>Old</b></p>
        <p>{{ $oldText }}</p>
        <p><b>New</b></p>
        <p>{{ $resource->text }}</p>
    </div>
</div>    
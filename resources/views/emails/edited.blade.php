@extends('layouts.email')

<div>
    <p>A {{ $type }} you have {{ $status }} has been edited</p>
    <div>
       <p><b>{{ $resource->user()->first()->name }}</b></p>
       <p>{{ $resource->text }}</p>
    </div>
</div>    
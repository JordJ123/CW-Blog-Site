@extends('layouts.email')

<div>
    <p>A {{ $type }} you have {{ $status }} has been deleted</p>
    <div class="p-3 mb-3 border border-dark">
       <p><b>{{ $resource->user()->first()->name }}</b></p>
       <p>{{ $resource->text }}</p>
    </div>
</div>    

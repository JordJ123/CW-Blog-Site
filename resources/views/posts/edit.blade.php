@extends('layouts.app')

@section('content')

    @if ($post->image()->first() != null)
        @php
            $value = $post->image()->first()->text;
        @endphp
    @else
        @php
            $value = "";
        @endphp       
    @endif  

    <div>
        <h1 class="text-primary">Edit Post</h1>
        <form method="POST" action="{{ route('posts.update', ['id' => $post->id]) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="text" class="form-label text-primary">Post Text</label>
                <input type="text" class="form-control" id="text" name="text" 
                    value="{{ $post->text }}">
            </div>
            <div class="mb-3">
                <label for="imageText" class="form-label text-primary">Image Alt Text</label>
                <input type="text" class="form-control" id="imageText" name="imageText" 
                    value="{{ $value }}">
            </div>
            <div class="mb-3">
                <label for="file" class="form-label text-primary">Image File</label>
                <input type="file" class="form-control" id="file" name="file">
            </div>
            <div>
                <button type="submit" class="text-secondary btn btn-primary">Update</button>
                @if ($post->image()->first() != null) 
                    <button class="ms-1 text-secondary btn btn-danger" @click="destroyImageFile()">
                        Remove Image</button>
                @endif
                <a class="btn link-dark" href="{{ route('posts.index') }}">Cancel</a>
            </div> 
        </form>
    </div>

    <script>
        var app = new Vue ({
            el: "#content",
            methods: {
                destroyImageFile:function() {
                    axios.delete("{{ route('posts.destroyImageFile', ['id' => $post->id]) }}")
                        .then(response => {
                            window.location.href = "{{ route('posts.index') }}"
                        })
                        .catch(response => {console.log(response);})
                }
            }
        })      
    </script>

@endsection


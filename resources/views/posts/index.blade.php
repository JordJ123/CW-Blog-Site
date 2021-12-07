@extends('layouts.app')

@section('title', 'Feed')

@section('content')

    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <a href="{{ route('posts.create') }}">New Post</a>
    

    @php
        $end = min($page * 5, $posts->count());
    @endphp
    @for ($i = (($page - 1) * 5); $i < $end; $i++)
        <div id="post{{ $i }}">
            @php
                $post = $posts->reverse()->values()[$i];
                $alreadyLiked = false;
            @endphp
            @foreach($post->likes() as $user)
                @if ($user == auth()->user())
                    $alreadyLiked = true;
                    break;
                @endif
            @endforeach
            <p><b>
                {{ $post->user()->first()->name }}
                (Likes {{ $post->likes()->count() }})
                @if ($post->user()->first() == auth()->user())
                    <a href="{{ route('posts.edit', ['id' => $post->id]) }}">Edit</a>
                    <form method="POST" action="{{ route('posts.destroy', 
                        ['id' => $post->id]) }}">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="Delete">
                    </form>
                @endif   
                @if ($alreadyLiked)
                        <form method="POST" action="{{ route('posts.updateLike', 
                            ['id' => $post->id, 'like' => 'false']) }}">
                            @csrf
                            @method('PATCH')
                            <input type="submit" value="Unlike">
                        </form>
                    @else
                        <form method="POST" action="{{ route('posts.updateLike', 
                            ['id' => $post->id, 'like' => 'true']) }}">
                        @csrf
                        @method('PATCH')
                        <input type="submit" value="Like">
                    </form>
                @endif
            </b><p>
            @if ($post->image()->first() != null)
                <p><img 
                    src="{{ 'images/'.$post->image()->first()->path }}" 
                    alt="{{ $post->image()->first()->text }}" 
                    style="height:128px"/></p>
            @endif
            <p> {{ $post->text }}</p>
            <p v-for="comment in comments">
                @{{ comment.name }}
                (Likes @{{ comment.likeCount }}): 
                <label v-if="!comment.isEdited">@{{ comment.text }}</label>
                <input v-model="comment.text" v-if="comment.isEdited" type="text"/>
                <button v-if="comment.isEdited" @click="commentUpdate(comment)">
                    Update</button>
                <!-- <button v-if="comment.isEdited" 
                    @click="commentCancel(comment, comment.text)">Cancel</button> -->
                <button v-if="comment.isUser && !comment.isEdited" 
                    @click="commentEdit(comment)">Edit</button></a>
                <button v-if="comment.isUser" @click="commentRemove(comment)">
                    Delete</button>
                <button v-if="!comment.alreadyLiked" @click="commentLike(comment)">
                    Like</button>
                <button v-if="comment.alreadyLiked" @click="commentUnlike(comment)">
                    Unlike</button>   
            </p>
            <p>
                <input v-model="commentBox" type="text"/>
                <button @click="commentPost()">Send</button>
            </p>    
        </div>

        <script>
            var app = new Vue ({
                el: "#post{{ $i }}",
                data: {
                    comments: [],
                    commentBox: ""
                },
                mounted() {
                    axios.get("{{ route('posts.showComments', ['id' => $post->id]) }}")
                        .then(response => {this.comments = response.data;})
                        .catch(response => {console.log(response)})
                },
                methods: {
                    commentEdit:function(comment) {
                        comment.isEdited = true;
                    },
                    commentCancel:function(comment, text) {
                        comment.isEdited = false;
                        comment.text = text;
                    },
                    commentUpdate:function(comment) {
                        axios.put("{{ route('comments.store') }}/" + comment.id, 
                            {
                                text:comment.text,
                            })
                            .then(response => {
                                comment.isEdited = false;
                            })
                            .catch(response => {console.log(response);})  
                        comment.isEdited = false;
                    },
                    commentRemove:function(comment) {
                        axios.delete("{{ route('comments.store') }}/" + comment.id)
                            .then(response => {
                                this.comments.splice(this.comments.indexOf(comment), 1);
                            })
                            .catch(response => {console.log(response);})   
                    },
                    commentPost:function() {
                        axios.post("{{ route('comments.store') }}", 
                            {
                                text:this.commentBox,
                                post_id:{{ $post->id }}
                            })
                            .then(response => {
                                this.commentBox = "";
                                this.comments.push(response.data);
                            })
                            .catch(response => {console.log(response);})  
                    },
                    commentLike:function(comment) {
                        axios.patch("{{ route('comments.store') }}/" + comment.id + "/like/true")
                            .then(response => {
                                comment.likeCount++;
                                comment.alreadyLiked = true;
                            })
                            .catch(response => {console.log(response);}) 
                    },
                    commentUnlike:function(comment) {
                        axios.patch("{{ route('comments.store') }}/" + comment.id + "/like/false")
                            .then(response => {
                                comment.likeCount--;
                                comment.alreadyLiked = false;
                            })
                            .catch(response => {console.log(response);})   
                    }
                }  
            });
        </script>  

    @endfor

    <div>
        <br>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <input type="submit" value="Logout">
        </form>
    </div>

    <div style="text-align:center">
        @php
            $start = max (1, $page - 4);
            $end = min (ceil($posts->count() / 5), $page + 4)
        @endphp
        @if ($page != 1)
            <a href="{{ route('posts.index', ['page' => $page - 1]) }}">Previous</a>
        @endif
        @for ($i = $start; $i <= $end; $i++)
            @if ($page != $i)
                <a href="{{ route('posts.index', ['page' => $i]) }}">{{ $i }}</a>
            @else
                <b> {{ $i }} </b>
            @endif    
        @endfor
        @if ($page != ceil($posts->count() / 5) && $posts->count() != 0)
            <a href="{{ route('posts.index', ['page' => $page + 1]) }}">Next</a>
        @endif
    </div>

@endsection
@extends('layouts.app')

@section('content')

    <div>
        <h1 class="text-primary">Post Feed</h1>
        <a class="btn btn-primary text-secondary mb-3" href="{{ route('posts.create') }}">New Post</a>
    </div>   
    
    @php
        $end = min($page * 5, $posts->count());
    @endphp

    <div style="background-color: #f2f2f2" class="border border-dark p-3 mb-3" v-for="post in posts">
        <p><b>
            @{{ post.name }}
            (Likes @{{ post.likeCount }})
            <button class="text-secondary btn-primary" v-if="isAdmin || post.isUser" 
                @click="postEdit(post)">Edit</button> 
            <button class="text-secondary btn-danger" v-if="isAdmin || post.isUser" 
                @click="postRemove(post)">Delete</button>
            <button class="text-secondary btn-primary" v-if="!post.alreadyLiked" 
                @click="postLike(post)">Like</button>
            <button class="text-secondary btn-primary" v-if="post.alreadyLiked" 
                @click="postUnlike(post)">Unlike</button>   
        </b><p>
        <p v-if="post.image != null"><img :src="'images/' + post.image.path" 
            :alt="post.image.text" style="height:128px"/></p>
        <p>@{{ post.text }}</p>
        <p v-for="comment in post.comments">
            @{{ comment.name }}
            (Likes @{{ comment.likeCount }}): 
            <label v-if="!comment.isEdited">@{{ comment.text }}</label>
            <input v-model="comment.text" v-if="comment.isEdited" type="text"/>
            <button class="text-secondary btn-primary" v-if="comment.isEdited" 
                @click="commentUpdate(post, comment)">Update</button>
            <button class="text-secondary btn-primary" v-if="comment.isEdited" 
                @click="commentCancel(post, comment)">Cancel</button>
            <button class="text-secondary btn-primary" v-if="(isAdmin || comment.isUser) 
                && !comment.isEdited" @click="commentEdit(post, comment)">Edit</button>
            <button class="text-secondary btn-danger" v-if="isAdmin || comment.isUser" 
                @click="commentRemove(post, comment)">Delete</button>
            <button class="text-secondary btn-primary" v-if="!comment.alreadyLiked" 
                @click="commentLike(post, comment)">Like</button>
            <button class="text-secondary btn-primary" v-if="comment.alreadyLiked" 
                @click="commentUnlike(post, comment)">Unlike</button>   
        </p>
        <p>
            <input v-model="post.newComment" type="text"/>
            <button class="text-secondary btn-primary" @click="commentPost(post)">Send</button>
        </p>
    </div>

    <div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-secondary btn btn-danger">Logout</button>
        </form>
    </div>

    <div class="text-center">
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

    <script>
        var app = new Vue ({
            el: "#content",
            data: {
                isAdmin: {{ auth()->user()->isAdmin }},
                posts: [],
            },
            mounted() {
                axios.get("{{ route('posts.indexJSON', ['page' => $page]) }}")
                    .then(response => {
                        this.posts = response.data;
                        this.tempPosts = JSON.parse(JSON.stringify(this.posts))
                    })
                    .catch(response => {console.log(response)});
            },
            methods: {
                postEdit:function(post) {
                    window.location.href 
                        = "{{ route('posts.index') }}/" + post.id + "/edit";
                },
                postRemove:function(post) {
                    axios.delete("{{ route('posts.index') }}/" + post.id)
                        .then(response => {
                            window.location.href = "{{ route('posts.index') }}";
                        })
                        .catch(response => {console.log(response);})   
                },
                postLike:function(post) {
                    axios.patch("{{ route('posts.index') }}/" + post.id + "/like/true")
                        .then(response => {
                            post.likeCount++;
                            post.alreadyLiked = true;
                        })
                       .catch(response => {console.log(response);}) 
                },
                postUnlike:function(post) {
                    axios.patch("{{ route('posts.index') }}/" + post.id + "/like/false")
                        .then(response => {
                            post.likeCount--;
                            post.alreadyLiked = false;
                        })
                        .catch(response => {console.log(response);})   
                },
                commentEdit:function(post, comment) {
                    comment.isEdited = true;
                },
                commentCancel:function(post, comment) {
                    comment.isEdited = false;
                    tempP = this.tempPosts.find(
                        tempPost => tempPost.id == post.id);
                    tempC = tempP.comments.find(
                        tempComment => tempComment.id == comment.id);
                    comment.text = tempC.text;
                },
                commentUpdate:function(post, comment) {
                    axios.put("{{ route('comments.store') }}/" + comment.id, 
                        {
                            text:comment.text,
                        })
                        .then(response => {
                            comment.isEdited = false;
                            tempP = this.tempPosts.find(
                                tempPost => tempPost.id == post.id);
                            tempC = tempP.comments.find(
                                tempComment => tempComment.id == comment.id);
                            tempC.text = comment.text;
                        })
                        .catch(response => {console.log(response);})  
                },
                commentRemove:function(post, comment) {
                    axios.delete("{{ route('comments.store') }}/" + comment.id)
                        .then(response => {
                            post.comments.splice(post.comments.indexOf(comment), 1);
                        })
                        .catch(response => {console.log(response);})   
                },
                commentLike:function(post, comment) {
                    axios.patch("{{ route('comments.store') }}/" + comment.id + "/like/true")
                        .then(response => {
                            comment.likeCount++;
                            comment.alreadyLiked = true;
                        })
                        .catch(response => {console.log(response);}) 
                },
                commentUnlike:function(post, comment) {
                    axios.patch("{{ route('comments.store') }}/" + comment.id + "/like/false")
                        .then(response => {
                            comment.likeCount--;
                            comment.alreadyLiked = false;
                        })
                        .catch(response => {console.log(response);})   
                },
                commentPost:function(post) {
                    axios.post("{{ route('comments.store') }}", 
                        {
                            text:post.newComment,
                            post_id:post.id
                        })
                        .then(response => {
                            post.newComment = "";
                            post.comments.push(response.data);
                        })
                        .catch(response => {console.log(response);})  
                }
            }
        })    
    </script>            

@endsection
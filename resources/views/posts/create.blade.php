@section('title', 'New Post')

@section('content')
    <form name="create" method="POST" action="{{ route('posts.store') }}">
        @csrf
        <textarea name="comment" form="create" name="text" value="{{ old('text') }}">
            </textarea>
        <input type="submit" value="Send">
    </form>
@endsection
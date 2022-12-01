@extends('layouts.app')

@section('content')

    <ul>
        @foreach($posts as $post)
        
            <a href="{{route('posts.show',$post->id)}}">{{$post->title}}</a><br>
            <img height="100 px" src="{{$post->path}}" alt="">
        @endforeach
        
    </ul>
@endsection
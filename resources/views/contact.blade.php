@extends('layouts.app')

@section('content')
    <h1> This is the contact page </h1>
    @if(count($people))
        @foreach ($people as $person)
        <li>{{$person}}</li>
            
        @endforeach
    @endif
@endsection

@section('footer')
  


@endsection

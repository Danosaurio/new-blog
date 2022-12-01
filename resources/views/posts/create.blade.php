@extends('layouts.app')

@section('content')
<h1>CREATE</h1>

{!! Form::open(['method'=>'POST','action'=>'\App\Http\Controllers\PostController@store','files'=>'true']) !!}

    {{csrf_field()}}  
    
    <div class="form-group">
        {!!Form::file('file',['class'=>'form-control'])!!}
    </div>

    <div class="form-group">
        {!! Form::label('title','Title:')!!}
        {!! Form::text('title',null,['class'=>'form-control'])!!}
    </div>
    
    <div class="form-group">
        {!! Form::submit('Create Post',['class'=>'btn btn-primary'])!!}
    </div>  
{!! Form::close() !!}

@if(count($errors)>0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- This is the traditional way
    <form method="post" action="/posts">
        <input type="text" name="title" placeholder="ENTER TITLE">
        <input type="submit" name="submit"> 
    </form>
-->


@endsection
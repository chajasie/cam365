@extends('default')
@section('content')
    My Super duper homepage

    @foreach($lessons as $lesson)
        <h2>{{$lesson}}</h2>
    @endforeach

   <br />
   <br />
   {{$name}}
@stop
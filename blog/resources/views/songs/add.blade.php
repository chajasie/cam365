@extends('default')
@section('content')
    <h2> New Song </h2>
   {!! Form::open(['method' => 'POST', 'route' => 'song_store_path' ]) !!}
        @include('songs.form');
   {!! Form::close() !!}
@stop
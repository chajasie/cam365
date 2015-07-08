@extends('default')
@section('content')
    @foreach($allSongs as $song)
        <li>{!! link_to_route('song_path', $song->title, [$song->slug]) !!}</li>
    @endforeach
    <br />
   {!! link_to_route('song_create_path', 'Add Song', null, ['class' => 'btn btn-primary']) !!}
@stop
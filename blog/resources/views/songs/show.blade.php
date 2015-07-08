@extends('default')
@section('content')
    <h2>{{$song->title}}</h2>
    @if ($song->lyrics)
        <p>
            {!! nl2br($song->lyrics) !!}
        </p>
    @endif
    <!-- <a href="{{ $song->slug }}/edit" title="Edit {{ $song->title }}" alt="title="Edit {{ $song->title }}"><input type="button" class="btn btn-primary" value="Edit" /></a> -->
    {!! link_to_route('song_edit_path', 'Edit ' . $song->title, [$song->slug], ['class' => 'btn btn-primary', 'alt' => 'Edit ' . $song->title, 'title' => 'Edit ' . $song->title]) !!}
    <br /><br />
    {!! delete_form(['song_destroy_path', $song->slug]) !!}
@stop
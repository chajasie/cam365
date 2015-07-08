@extends('default')
@section('content')
    <h2>{{$song->title}}</h2>
   {!! Form::model($song, ['method' => 'PATCH', 'route' => ['song_update_path', $song->slug] ]) !!}
        <div class="form-group">
           {!! Form::text('title', null, ['class' => 'form-controller']) !!}
        </div>
        <div class="form-group">
           {!! Form::textarea('lyrics', null, ['class' => 'form-controller']) !!}
        </div>
        <div class="form-group">
           {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
        </div>
   {!! Form::close() !!}
@stop
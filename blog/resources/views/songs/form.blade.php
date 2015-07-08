<div class="form-group {{$errors->has('title') ? 'has-error' : ''}}">
  {!! Form::label('title', 'Title:') !!}
  {!! Form::text('title', 'Song-Title', ['class' => 'form-controller']) !!}
  {!! $errors->first('title', '<span class="help-block">:message</span>') !!}
</div>
<div class="form-group">
  {!! Form::textarea('lyrics', 'Lyrics..', ['class' => 'form-controller']) !!}
</div>
<div class="form-group">
  {!! Form::submit('Add new Song', ['class' => 'btn btn-primary']) !!}
</div>
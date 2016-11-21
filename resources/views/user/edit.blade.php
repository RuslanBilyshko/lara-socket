@extends('page')


@section('title',trans('app.editing')." <b><em>".$user->name."</em></b>")

@section('content')
  {{Form::model($user, array('route' => array('userEdit', $user->id),'role'=>"form"))}}
  <div class="form-group">
    {{Form::label('name', trans('app.name'))}}
    {{Form::text('name')}}
  </div>
  <div class="form-group">
    {{Form::label('email', trans('app.email'))}}
    {{Form::text('email')}}

  </div>
  <div class="form-group">
    {{Form::label('role_id', trans('app.post'))}}
    {{Form::select('role_id', $roles)}}
  </div>


  {{Form::submit(trans('app.update'))}}
  {{Form::close()}}
@endsection
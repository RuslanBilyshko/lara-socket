@extends('page')


@section('title',trans('app.orderCreate'))

@section('content')
  {{Form::model($order, array('role'=>"form"))}}
  <div class="form-group">
    {{Form::label('table', trans('app.table'))}}
    {{Form::select('table', to_select_range(1,10))}}
  </div>
  <div class="form-group">
    {{Form::label('food_id', trans('app.food'))}}
    {{Form::select('food_id', $foods)}}
  </div>
  {{Form::hidden('waiter_id',$uid)}}
{{--  <div class="form-group">
    {{Form::label('status', trans('app.status'))}}
    {{Form::radio('status', 0, $order->status == 0 ? true : false )}} <span>{{trans('app.preparing')}}</span>
    {{Form::radio('status', 1, $order->status == 0 ? false : true )}} <span>{{trans('app.ready')}}</span>
  </div>--}}



  {{Form::submit(trans('app.add'))}}
  {{Form::close()}}
@endsection
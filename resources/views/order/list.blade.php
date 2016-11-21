@extends('page')

@section('title',$title)

@section('content')
   <button onclick="send()">Send</button>
   {!! $content !!}
@endsection

@section('script')
	<script type="text/javascript" src="{{asset("js/order.js")}}"></script>
@endsection

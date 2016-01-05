@extends('layout.default')

@section('content')
	<h3 style="margin-left:2%"> Deleted Magazines</h3>
	<br />
	<p style="margin-left:2%">
	@foreach($deleted as $item)
		Deleted Magazine {{ $item}} <br />
	@endforeach
	</p>
@stop
@extends('layout.default')

@section('content')
	<h1>This is Users List</h1>
	<ul>
	@foreach($users as $user)
		<li>{{ $user->name}}</li>
	@endforeach
	</ul>
@stop

@section('end')
	<p>Created by Dinuka</p>
@stop
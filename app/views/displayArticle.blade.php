@extends('layout.default')

@section('content')
	<h3 style='margin-left:20px'>
		Issue: {{ $issue}}

	</h3>
	<br />
	
	@if(isset($article))
		<div class="row" style="margin-left:1%">
			<div class="col-xs-6 col-md-4 inline lead"><label>Article Name: {{ $articleData[0]['articleHeading']}}</label></div>
			<div class="col-xs-6 col-md-4 inline lead"><label>Author: {{ $articleData[0]['author']}}</label></div>
		</div>
		<div class="row" style="margin-left:1%">
			<div class="form-control" style="margin-top:20px;height:auto;margin:10px;width:auto">
			<img src="data:image/jpeg;base64,{{base64_encode($article[0]['image']) }}"/>
			{{ $article[0]['data']}}
			</div>
		</div>
		<button class="btn btn-info" onclick="location.href=url('editarticle').'/{{$issue}}/{{$articleData[0]['articleNo']}}'">
			Edit Article</button>
	@endif
@stop
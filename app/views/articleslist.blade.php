@extends('layout.default')

@section('content')
	<h3  style="margin-left:2%">Articles List of Magazine {{$heading}}</h3>
	<br />
	{{ Form::open(array('url' => url('deletemultiplearticles') )) }}
		<div style="margin-left:2%">
			@foreach($articles as $item)
				<label>
					@if($item['articleHeading']!='')
						<input type="checkbox" id={{ $item['articleNo']}} name={{ $item['articleNo'] }} value="">
						{{HTML::link(url('viewarticle').$item['issue'].'/'.$item['articleNo'],'ArticleNo:'.$item['articleNo']
						.' '.$item['articleHeading'].' by '.$item['author']) }}
					@endif

				</label>
				<br/>
			@endforeach
			<br />
			@if(count($articles)>0)
				<button type="submit" class="btn btn-info">Delete</button>
			@endif
		</div>
	{{ Form::close() }}
			<button class="btn btn-info" onclick="location.href=url('/addarticle').'/{{$issue}}'">Add Article</button>
@stop


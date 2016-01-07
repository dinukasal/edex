@extends('layout.default')

@section('content')
	<h3  style="margin-left:2%">Magazines List</h3>
	<br />
	{{ Form::open(array('url' => url('deletemultiple'))) }}
		<div style="margin-left:2%">
			<?php $counter=0; ?>
			@foreach($magazines as $item)
				<label>
						<input type="checkbox" id={{ $item['issue']}} name={{ $item['issue'] }} value="">
					{{HTML::link('viewmag/'.$item['issue'],'Issue:'.$item['issue']) }}
				</label>
				<br/>
			@endforeach
			<br />
			<button type="submit" class="btn btn-info">Delete</button>
		</div>
	{{ Form::close() }}
@stop


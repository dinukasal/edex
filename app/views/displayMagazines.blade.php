@extends('layout.default')

@section('content')
	<h2 style="margin-left:20px">All Magazines</h2>
	<br />
	<ol>
	@foreach($magazines as $item)
		<div class='col-md-10'>
			<li>
				<h4>
					<div class='row'>
					<div class="col-xs-6 col-md-4 inline">{{ HTML::link('viewmag/'.$item['issue'],'
					Issue:'.$item['issue'],array('class'=>'inline')) }} </div>

					<div class="col-xs-6 col-md-4 inline"><label>Title: {{ $item['heading']}}</label></div>
					<div class="col-xs-6 col-md-4 inline"><label>Submitted Date: {{ $item['date']}}</label></div>
					<br />
					<div class="form-control" style="height:auto;margin:10px">
					<img src="data:image/jpeg;base64,{{base64_encode($item['image']) }}"/>
					</div>
					</div>
				</h4>
			</li>
		</div>
	@endforeach
	</ol>
@stop
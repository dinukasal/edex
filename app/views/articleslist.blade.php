@extends('layout.default')

@section('content')

<div class="panel panel-info" style="margin-top: 2%">

    <div class="panel-heading">
        <h3 class="panel-title">Articles List of Magazine {{$heading}}</h3>
    </div>

    {{ Form::open(array('url' => '/deletemultiplearticles')) }}

    <div class="panel-body">
        @foreach($articles as $item)
        <label>
            @if($item['articleHeading']!='')
            <input type="checkbox" id="{{ $item['articleNo']}}" name="{{ $item['articleNo'] }}" value="">
            {{HTML::link('viewarticle/'.$item['issue'].'/'.$item['articleNo'],'ArticleNo:'.$item['articleNo']
						.' '.$item['articleHeading'].' by '.$item['author']) }}
            @endif

        </label>
        @endforeach

    </div>
    <div class="panel-footer container-fluid">
        @if(count($articles)>0)
        <button type="submit" class="btn btn-info pull-left">Delete</button>
        @endif

        <button class="btn btn-info pull-right" onclick="location.href ='{{url('/addarticle/'.$issue)}}';return false;">Add Article</button>

    </div>

    {{ Form::close() }}

</div>

@stop


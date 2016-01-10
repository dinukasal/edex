@extends('layout.default')

@section('content')


    <div class="panel panel-info">
        <div class="panel panel-heading">
            <h3 class="panel-title">Issue : {{$issue}}</h3>
        </div>

        <div class="panel-body center-block">
            @if(isset($article))
                <div class="row center-block">
                    <div class="col-xs-6 col-md-6 inline lead"><label>Article
                            Name: {{ $articleData['articleHeading']}}</label>
                    </div>
                    <div class="col-xs-6 col-md-6 inline lead"><label>Author: {{ $articleData['author']}}</label></div>
                </div>
                <div class="row center-block">
                    <img src="{{asset($article->image)}}" class="img-responsive" style="width: 300px"/>
                    <p>
                        {{ $article['data']}}
                    </p>
                </div>

            @endif
        </div>

        <div class="panel-footer container-fluid">
            <button class="btn btn-info pull-left" onclick="location.href='{{url('/editarticle/'.$issue.'/'.
													$articleData['articleNo'])}}'">
                Edit Article
            </button>
        </div>
    </div>
@stop
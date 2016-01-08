@extends('layout.default')

@section('content')

<div class="panel panel-info" style="margin-top: 2%">
    <div class="panel-heading">
        <h3 class="panel-title">All Magazines</h3>
    </div>

    <div class="panel-body container-fluid">
        <ol class="list-group">
            @foreach($magazines as $item)
            <li class="list-group-item">
                <div class='row'>
                    <h3>
                        <div class="col-xs-6 col-md-4 inline">
                            {{ HTML::link('viewmag/'.$item['issue'],'
					Issue:'.$item['issue'],array('class'=>'inline')) }} 
                        </div>

                        <div class="col-xs-6 col-md-4 inline"><label>Title: {{ $item['heading']}}</label></div>
                        <div class="col-xs-6 col-md-4 inline"><label>Submitted Date: {{ $item['date']}}</label></div>
                    </h3>
                </div>
                <div class="row container-fluid center-block" style="height:auto;margin:10px">
                    <img src="{{ asset( $item->image) }}" class="img-responsive center-block" style="width: 200px"/>
                </div>
            </li>
            @endforeach
        </ol>
        
        {{ $magazines->links()}}
    </div>
</div>

@stop
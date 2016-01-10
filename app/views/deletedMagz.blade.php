@extends('layout.default')

@section('content')

    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">Deleted Magazine</h3>
        </div>
        <div class="panel-body">
            <ul class="list-group">
                @foreach($deleted as $item)
                    <li class="list-group-item">
                        Deleted Magazine {{ $item}}
                    </li>
                @endforeach

            </ul>
        </div>
    </div>

@stop
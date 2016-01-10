@extends('layout.default')

@section('content')

<div class="container-fluid" style="margin-top: 2%">

    @if(Session::has('error'))
    <div class="alert alert-danger">
        <h4 class="title"> Oops!</h4>
        {{Session::get('error')}}
    </div>
    @endif

    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">Add Magazine</h3>
        </div>

        <div class="panel-body">

            {{ Form::open(array('url' => url('/submitmag') , 'enctype'=>"multipart/form-data")) }}
            <div style="margin-left:2%">
                <div class="row">
                    {{ Form::label('Issue:', '') }}
                    {{ Form::text('issue', $issue,array('class'=>'form-control',
                                'style'=>'margin-bottom:20px;width:200px;display:inline','readonly'=>'readonly')) }}

                    {{ Form::label('Title:', '',array('style'=>'margin-left:20px')) }}
                    {{ Form::text('heading', '', array('class'=>'form-control','style'=>'margin-bottom:20px;width:200px;display:inline')) }}

                    {{ Form::label('Date:', '',array('style'=>'margin-left:20px')) }}
                    {{ Form::text('date', date('Y/m/d') , array('class'=>'form-control','style'=>'margin-bottom:20px;width:200px;display:inline')) }}

                </div>
                <div class="row">
                    <label for="image">Cover Page input</label>
                    <input type="file" name="image" required>
                </div>    
            </div>

            <div class="panel-footer">
                <button type="submit" class="btn btn-info pull-right">Submit</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>

</div>
@stop
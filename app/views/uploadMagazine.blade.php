@extends('layout.default')

@section('content')
  {{ Form::open(array('url' => url('submitmag') , 'enctype'=>"multipart/form-data")) }}
    <div style="margin-left:2%">
      <h3>
      {{ Form::label('Enter Magazine details', '') }}
    </h3>
    <div class="row">
      {{ Form::label('Issue:', '') }}
      {{ Form::text('issue', $issue,array('class'=>'form-control','style'=>'margin-bottom:20px;width:200px;display:inline')) }}

      {{ Form::label('Title:', '',array('style'=>'margin-left:20px')) }}
      {{ Form::text('heading', '', array('class'=>'form-control','style'=>'margin-bottom:20px;width:200px;display:inline')) }}

      {{ Form::label('Date:', '',array('style'=>'margin-left:20px')) }}
      {{ Form::text('date', date('Y/m/d') , array('class'=>'form-control','style'=>'margin-bottom:20px;width:200px;display:inline')) }}

    </div>
    <div class="row">
      <label for="image">Cover Page input</label>
      <input type="file" id="image" name="image">
    </div>    
      <br />
      <br />
      <button type="submit" class="btn btn-info">Submit</button>
    </div>
  {{ Form::close() }}

@stop
@extends('layout.default')

@section('content')
  {{ Form::open(array('url' => url('/submitarticle') , 'enctype'=>"multipart/form-data")) }}
    <div style="margin-left:2%">
      <h3>
      {{ Form::label('Enter the article here', '') }}
    </h3>
    <div class="row">
      {{ Form::label('Issue No:', '') }}
      {{ Form::text('issue', $issue,array('class'=>'form-control','style'=>'margin-bottom:20px;width:200px;display:inline')) }}
    </div>
    <div class="row">
      {{ Form::label('Article No:', '') }}
      {{ Form::text('articleNo', $articleNo ,array('class'=>'form-control','style'=>'margin-bottom:20px;width:200px;display:inline')) }}

      {{ Form::label('Title:', '',array('style'=>'margin-left:20px')) }}
      {{ Form::text('heading', '', array('class'=>'form-control','style'=>'margin-bottom:20px;width:200px;display:inline')) }}

      {{ Form::label('Author:', '',array('style'=>'margin-left:20px')) }}
      {{ Form::text('author', '', array('class'=>'form-control','style'=>'margin-bottom:20px;width:200px;display:inline')) }}
    </div>
        <div class="row">
      <label for="image">Image input</label>
      <input type="file" id="image" name="image">
    </div>    
      <br />
      <textarea name="data" id="data" rows="10" cols="80" style="margin-top:10px"></textarea>
      <br />
      <button type="submit" class="btn btn-info">Submit</button>
    </div>
  {{ Form::close() }}

  <script src="{{asset('/ckeditor/ckeditor.js')}}"></script>                
   <script>
      // Replace the <textarea id="editor1"> with a CKEditor
      // instance, using default configuration.
      CKEDITOR.replace( 'data' );
    </script>
@stop
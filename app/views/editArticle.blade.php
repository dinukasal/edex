@extends('layout.default')

@section('content')
    {{ Form::open(array('url' => url('/updatearticle') , 'enctype'=>"multipart/form-data")) }}
    <div style="margin-left:2%">
        <h3>
            {{ Form::label('Enter the article here', '') }}
        </h3>
        <div class="form-group">
            {{ Form::label('Issue No:', '') }}
            {{ Form::text('issue', $issue,array('class'=>'form-control','style'=>'margin-bottom:20px;width:200px;display:inline')) }}
        </div>
        <div class="form-group">
            {{ Form::label('Article No:', '') }}
            {{ Form::text('articleNo', $articleNo ,array('class'=>'form-control','style'=>'margin-bottom:20px;width:200px;display:inline')) }}

            {{ Form::label('Title:', '',array('style'=>'margin-left:20px')) }}
            {{ Form::text('heading', $articleData['articleHeading'] , array('class'=>'form-control','style'=>'margin-bottom:20px;width:200px;display:inline')) }}

            {{ Form::label('Author:', '',array('style'=>'margin-left:20px')) }}
            {{ Form::text('author', $articleData['author'], array('class'=>'form-control','style'=>'margin-bottom:20px;width:200px;display:inline')) }}
        </div>
        <div class="form-group center-block">
            <label>Current Image</label>
            @if(empty($article->image))
                <span>No Image Available</span>
            @else
                <img src="{{asset($article->image)}}" class="img-responsive center-block" width="200px">
            @endif
        </div>

        <div class="form-group">
            <label for="image">Replace Image</label>
            <input type="file" id="image" name="image">
        </div>

        <div class="form-group center-block">
            <label>Current Advertisement</label>
            @if(!$articleData->hasAd)
                <span>No Advertisement Available</span>
            @else
                <img src="{{asset($articleData->adImage)}}" class="img-responsive center-block" width="200px">
            @endif
        </div>

        <div class="form-group">
            <label for="image">Replace Advertisement</label>
            <input type="file" id="advertisement" name="adImage">
        </div>

        <div class="form-group">
            <textarea name="data" id="data" rows="10" cols="80" style="margin-top:10px">{{ $article['data']}}</textarea>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-info pull-left">Submit</button>
        </div>
    </div>
    {{ Form::close() }}

    <script src="{{asset('ckeditor/ckeditor.js')}}"></script>
    <script>
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('data');
    </script>
@stop
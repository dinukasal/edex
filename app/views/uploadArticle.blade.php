@extends('layout.default')

@section('content')


    <div class="container-fluid">

        @if(Session::has('error'))
            <div class="alert alert-danger">
                <h4 class="title"> Oops!</h4>
                {{Session::get('error')}}
            </div>
        @endif

        {{ Form::open(array('url' => url('submitarticle') , 'enctype'=>"multipart/form-data")) }}
        <div style="margin-left:2%">
            <div class="form-group">
                <h3>
                    {{ Form::label('Enter the article here', '') }}
                </h3>
            </div>
            <div class="form-group">
                {{ Form::label('Issue No:', '') }}
                {{ Form::text('issue', $issue,array('class'=>'form-control',
                'style'=>'margin-bottom:20px;width:200px;display:inline', 'readonly'=>'readonly','required'=>'required')) }}
            </div>
            <div class="form-group">
                {{ Form::label('Article No:', '') }}
                {{ Form::text('articleNo', $articleNo ,array('class'=>'form-control',
                'style'=>'margin-bottom:20px;width:200px;display:inline', 'readonly'=>'readonly','required'=>'required')) }}

                {{ Form::label('Title:', '',array('style'=>'margin-left:20px')) }}
                {{ Form::text('heading', '', array('class'=>'form-control',
                'style'=>'margin-bottom:20px;width:200px;display:inline','required'=>'required')) }}

                {{ Form::label('Author:', '',array('style'=>'margin-left:20px')) }}
                {{ Form::text('author', '', array('class'=>'form-control',
                'style'=>'margin-bottom:20px;width:200px;display:inline','required'=>'required')) }}
            </div>
            <div class="form-group">
                <label for="image">Image input</label>
                <input type="file" id="image" name="image" required>
            </div>
            <div class="form-group">
                <textarea name="data" id="data" rows="10" cols="80" style="margin-top:10px" required></textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-info pull-left">Submit</button>
            </div>
        </div>
        {{ Form::close() }}
    </div>

    <script src="{{asset('/ckeditor/ckeditor.js')}}"></script>
    <script>
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('data');
    </script>
@stop
@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h3>
            {{ trans('global.create') }} {{ trans('cruds.homeContent.title_singular') }}
        </h3>
     
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.home-contents.store") }}" enctype="multipart/form-data">
            @csrf
          
            <div class="form-group">
                <label for="video" style="font-weight:650;">{{ trans('Video Upload') }}</label>
                <input class="form-control {{ $errors->has('video') ? 'is-invalid' : '' }}" type="file" name="video" id="video" accept="video/*">
                @if($errors->has('video'))
                    <div class="invalid-feedback">
                        {{ $errors->first('video') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('Upload a video file (mp4, webm, etc.)') }}</span>
            </div>
            
            <div class="form-group">
                <label for="content" style="font-weight:650;" >{{ trans('cruds.homeContent.fields.content') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('content') ? 'is-invalid' : '' }}" name="content" id="content">{!! old('content') !!}</textarea>
              
                @if($errors->has('content'))
                    <div class="invalid-feedback">
                        {{ $errors->first('content') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.homeContent.fields.content_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection
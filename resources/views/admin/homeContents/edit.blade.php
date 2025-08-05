@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h3>
            {{ trans('global.edit') }} {{ trans('cruds.homeContent.title_singular') }}
        </h3>
        
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.home-contents.update", [$homeContent->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            
          
            <div class="form-group">
                <label for="video" style="font-weight:650;">{{ __('Video Upload') }}</label>
                <input class="form-control {{ $errors->has('video') ? 'is-invalid' : '' }}" type="file" name="video" id="video" accept="video/*">
            
                @if($errors->has('video'))
                    <div class="invalid-feedback">
                        {{ $errors->first('video') }}
                    </div>
                @endif
            
                <span class="help-block">{{ __('Upload a video file (mp4, webm, etc.)') }}</span>
            </div>
            
            {{-- Show current video if exists --}}
            @if(!empty($homeContent->video))
                <div class="form-group">
                    <label style="font-weight:650;">{{ __('Current Video:') }}</label><br>
                    <video width="400" height="250" controls>
                        <source src="{{ asset($homeContent->video) }}" type="video/mp4">
                        <source src="{{ asset($homeContent->video) }}" type="video/webm">
                        Your browser does not support the video tag.
                    </video>
                </div>
            @endif

            
            <div class="form-group">
                <label for="content" class="text-primary" style="font-weight:650;" >{{ trans('cruds.homeContent.fields.content') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('content') ? 'is-invalid' : '' }}" name="content" id="content">{!! old('content', $homeContent->content) !!}</textarea>
          
            
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
@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h3>
            {{ trans('global.create') }} {{ trans('cruds.setting.title_singular') }}
        </h3>
      
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.settings.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required text-primary" for="website_title" style="font-weight:650;">{{ trans('cruds.setting.fields.website_title') }}</label>
                <input class="form-control {{ $errors->has('website_title') ? 'is-invalid' : '' }}" type="text" name="website_title" id="website_title" value="{{ old('website_title', '') }}" required>
                @if($errors->has('website_title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('website_title') }}
                    </div>
                @endif
 
            </div>

            <div class="form-group">
                <label class="required text-primary" for="website_title" style="font-weight:650;">{{ trans('Business Name') }}</label>
                <input class="form-control {{ $errors->has('website_title') ? 'is-invalid' : '' }}" type="text" name="business_name" id="website_title" value="{{ old('business_name', '') }}" required>
                @if($errors->has('website_title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('website_title') }}
                    </div>
                @endif

            </div>
            
            <div class="form-group">
                <label class="required text-primary" for="website_title" style="font-weight:650;">{{ trans('cruds.setting.fields.website_title') }}</label>
                <input class="form-control {{ $errors->has('website_title') ? 'is-invalid' : '' }}" type="file" name="breadcrumb_image" id="website_title" value="{{ old('breadcrumb_image', '') }}" required>
                @if($errors->has('website_title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('website_title') }}
                    </div>
                @endif

            </div>
            

            <div class="form-group">
                <label class="required text-primary" for="email" style="font-weight:650;">{{ trans('cruds.setting.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email') }}" required>
                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
      
            </div>
            <div class="form-group">
                <label for="email_1 text-primary" style="font-weight:650;">{{ trans('cruds.setting.fields.email_1') }}</label>
                <input class="form-control {{ $errors->has('email_1') ? 'is-invalid' : '' }}" type="email" name="email_1" id="email_1" value="{{ old('email_1') }}">
                @if($errors->has('email_1'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email_1') }}
                    </div>
                @endif
   
            </div>
            <div class="form-group">
                <label class="required text-primary" for="phone" style="font-weight:650;">{{ trans('cruds.setting.fields.phone') }}</label>
                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', '') }}" required>
                @if($errors->has('phone'))
                    <div class="invalid-feedback">
                        {{ $errors->first('phone') }}
                    </div>
                @endif
        
            </div>
            <div class="form-group">
                <label for="phone_1 " class="text-primary" style="font-weight:650;">{{ trans('cruds.setting.fields.phone_1') }}</label>
                <input class="form-control {{ $errors->has('phone_1') ? 'is-invalid' : '' }}" type="text" name="phone_1" id="phone_1" value="{{ old('phone_1', '') }}">
                @if($errors->has('phone_1'))
                    <div class="invalid-feedback">
                        {{ $errors->first('phone_1') }}
                    </div>
                @endif
         
            </div>
            <div class="form-group">
                <label for="address " class="text-primary" style="font-weight:650;">{{ trans('cruds.setting.fields.address') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('address') ? 'is-invalid' : '' }}" name="address" id="address">{!! old('address') !!}</textarea>
                @if($errors->has('address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('address') }}
                    </div>
                @endif
     
            </div>


            <div class="form-group">
                <label for="address" class="text-primary" style="font-weight:650;"> {{ trans('Instruction Content') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('address') ? 'is-invalid' : '' }}" name="instruct_content" id="address">{!! old('address') !!}</textarea>
                @if($errors->has('address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('address') }}
                    </div>
                @endif
     
            </div>


            <div class="form-group">
                <label for="content" class="text-primary" style="font-weight:650;">{{ trans('cruds.setting.fields.content') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('content') ? 'is-invalid' : '' }}" name="content" id="content">{!! old('content') !!}</textarea>
                @if($errors->has('content'))
                    <div class="invalid-feedback">
                        {{ $errors->first('content') }}
                    </div>
                @endif

            </div>

            <div class="form-group">
                <label for="facebook_link" class="text-primary" style="font-weight:650;">{{ trans('Whats App') }}</label>
                <input class="form-control {{ $errors->has('facebook_link') ? 'is-invalid' : '' }}" type="text" name="whatsapp_link" id="facebook_link" value="{{ old('whatsapp_link', '') }}">
                @if($errors->has('facebook_link'))
                    <div class="invalid-feedback">
                        {{ $errors->first('facebook_link') }}
                    </div>
                @endif

            </div>


            <div class="form-group">
                <label for="facebook_link" class="text-primary" style="font-weight:650;">{{ trans('cruds.setting.fields.facebook_link') }}</label>
                <input class="form-control {{ $errors->has('facebook_link') ? 'is-invalid' : '' }}" type="text" name="facebook_link" id="facebook_link" value="{{ old('facebook_link', '') }}">
                @if($errors->has('facebook_link'))
                    <div class="invalid-feedback">
                        {{ $errors->first('facebook_link') }}
                    </div>
                @endif
      
            </div>
            <div class="form-group">
                <label for="instagram_link" class="text-primary" style="font-weight:650;">{{ trans('cruds.setting.fields.instagram_link') }}</label>
                <input class="form-control {{ $errors->has('instagram_link') ? 'is-invalid' : '' }}" type="text" name="instagram_link" id="instagram_link" value="{{ old('instagram_link', '') }}">
                @if($errors->has('instagram_link'))
                    <div class="invalid-feedback">
                        {{ $errors->first('instagram_link') }}
                    </div>
                @endif

            </div>
            <div class="form-group">
                <label for="twitter_link" class="text-primary" style="font-weight:650;">{{ trans('cruds.setting.fields.twitter_link') }}</label>
                <input class="form-control {{ $errors->has('twitter_link') ? 'is-invalid' : '' }}" type="text" name="twitter_link" id="twitter_link" value="{{ old('twitter_link', '') }}">
                @if($errors->has('twitter_link'))
                    <div class="invalid-feedback">
                        {{ $errors->first('twitter_link') }}
                    </div>
                @endif
     
            </div>
            <div class="form-group">
                <label for="youtube_link" class="text-primary" style="font-weight:650;">{{ trans('cruds.setting.fields.youtube_link') }}</label>
                <input class="form-control {{ $errors->has('youtube_link') ? 'is-invalid' : '' }}" type="text" name="youtube_link" id="youtube_link" value="{{ old('youtube_link', '') }}">
                @if($errors->has('youtube_link'))
                    <div class="invalid-feedback">
                        {{ $errors->first('youtube_link') }}
                    </div>
                @endif
             
            </div>
            <div class="form-group">
                <label for="linkedin_link" class="text-primary" style="font-weight:650;">{{ trans('cruds.setting.fields.linkedin_link') }}</label>
                <input class="form-control {{ $errors->has('linkedin_link') ? 'is-invalid' : '' }}" type="text" name="linkedin_link" id="linkedin_link" value="{{ old('linkedin_link', '') }}">
                @if($errors->has('linkedin_link'))
                    <div class="invalid-feedback">
                        {{ $errors->first('linkedin_link') }}
                    </div>
                @endif
           
            </div>
            <div class="form-group">
                <label for="map" class="text-primary" style="font-weight:650;">{{ trans('cruds.setting.fields.map') }}</label>
                <input class="form-control {{ $errors->has('map') ? 'is-invalid' : '' }}" type="text" name="map" id="map" value="{{ old('map', '') }}">
                @if($errors->has('map'))
                    <div class="invalid-feedback">
                        {{ $errors->first('map') }}
                    </div>
                @endif
                
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

@section('scripts')
<script>
    $(document).ready(function () {
  function SimpleUploadAdapter(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
      return {
        upload: function() {
          return loader.file
            .then(function (file) {
              return new Promise(function(resolve, reject) {
                // Init request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('admin.settings.storeCKEditorImages') }}', true);
                xhr.setRequestHeader('x-csrf-token', window._token);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.responseType = 'json';

                // Init listeners
                var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                xhr.addEventListener('error', function() { reject(genericErrorText) });
                xhr.addEventListener('abort', function() { reject() });
                xhr.addEventListener('load', function() {
                  var response = xhr.response;

                  if (!response || xhr.status !== 201) {
                    return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                  }

                  $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                  resolve({ default: response.url });
                });

                if (xhr.upload) {
                  xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                      loader.uploadTotal = e.total;
                      loader.uploaded = e.loaded;
                    }
                  });
                }

                // Send request
                var data = new FormData();
                data.append('upload', file);
                data.append('crud_id', '{{ $setting->id ?? 0 }}');
                xhr.send(data);
              });
            })
        }
      };
    }
  }

  var allEditors = document.querySelectorAll('.ckeditor');
  for (var i = 0; i < allEditors.length; ++i) {
    ClassicEditor.create(
      allEditors[i], {
        extraPlugins: [SimpleUploadAdapter]
      }
    );
  }
});
</script>

@endsection
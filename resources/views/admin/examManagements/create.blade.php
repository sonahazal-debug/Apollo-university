@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h3>
            {{ trans('global.create') }} {{ trans('cruds.examManagement.title_singular') }}
        </h3>
       
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.exam-managements.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="row">


                <div class="form-group col-6">
                    <label for="course_id" class="text-primary " style="font-weight:650;">{{ trans('cruds.examManagement.fields.course') }}</label>
                    <select class="form-control select2 {{ $errors->has('course') ? 'is-invalid' : '' }}" name="course_id" id="course_id">
                        @foreach($courses as $id => $entry)
                            <option value="{{ $id }}" {{ old('course_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('course'))
                        <div class="invalid-feedback">
                            {{ $errors->first('course') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.examManagement.fields.course_helper') }}</span>
                </div>
              

                <div class="form-group col-6">
                    <label class="text-primary" style="font-weight:650;">{{ trans('cruds.examManagement.fields.status') }}</label>
                    <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                        <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\Models\ExamManagement::STATUS_SELECT as $key => $label)
                            <option value="{{ $key }}" {{ old('status', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('status'))
                        <div class="invalid-feedback">
                            {{ $errors->first('status') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.examManagement.fields.status_helper') }}</span>
                </div>

                <div class="form-group col-6">
                    <label for="exam_id" class="text-primary" style="font-weight:650;">{{ trans('Exam_id') }}</label>
                    <input class="form-control {{ $errors->has('exam_id') ? 'is-invalid' : '' }}" 
                           type="text" 
                           name="exam_id" 
                           id="exam_id" 
                           value="{{ old('exam_id', $randomExamId) }}" 
                           readonly>
                    @if($errors->has('exam_id'))
                        <div class="invalid-feedback">
                            {{ $errors->first('exam_id') }}
                        </div>
                    @endif
                   
                </div>
                
                
                <div class="form-group col-6">
                    <label for="exam_name" class="text-primary" style="font-weight:650;">{{ trans('cruds.examManagement.fields.exam_name') }}</label>
                    <input class="form-control {{ $errors->has('exam_name') ? 'is-invalid' : '' }}" type="text" name="exam_name" id="exam_name" value="{{ old('exam_name', '') }}">
                    @if($errors->has('exam_name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('exam_name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.examManagement.fields.exam_name_helper') }}</span>
                </div>
                {{-- <div class="form-group col-6">
                    <label>{{ trans('cruds.examManagement.fields.exam_mode') }}</label>
                    <select class="form-control {{ $errors->has('exam_mode') ? 'is-invalid' : '' }}" name="exam_mode" id="exam_mode">
                        <option value disabled {{ old('exam_mode', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\Models\ExamManagement::EXAM_MODE_SELECT as $key => $label)
                            <option value="{{ $key }}" {{ old('exam_mode', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('exam_mode'))
                        <div class="invalid-feedback">
                            {{ $errors->first('exam_mode') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.examManagement.fields.exam_mode_helper') }}</span>
                </div> --}}
                <div class="form-group col-6">
                    <label for="start_date" class="text-primary" style="font-weight:650;">{{ trans('cruds.examManagement.fields.start_date') }}</label>
                    <input class="form-control date {{ $errors->has('start_date') ? 'is-invalid' : '' }}" type="text" name="start_date" id="start_date" value="{{ old('start_date') }}">
                    @if($errors->has('start_date'))
                        <div class="invalid-feedback">
                            {{ $errors->first('start_date') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.examManagement.fields.start_date_helper') }}</span>
                </div>
                <div class="form-group col-6">
                    <label for="start_time" class="text-primary" style="font-weight:650;">{{ trans('cruds.examManagement.fields.start_time') }}</label>
                    <input class="form-control timepicker {{ $errors->has('start_time') ? 'is-invalid' : '' }}" type="text" name="start_time" id="start_time" value="{{ old('start_time') }}">
                    @if($errors->has('start_time'))
                        <div class="invalid-feedback">
                            {{ $errors->first('start_time') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.examManagement.fields.start_time_helper') }}</span>
                </div>
                <div class="form-group col-6">
                    <label for="end_time" class="text-primary" style="font-weight:650;">{{ trans('cruds.examManagement.fields.end_time') }}</label>
                    <input class="form-control timepicker {{ $errors->has('end_time') ? 'is-invalid' : '' }}" type="text" name="end_time" id="end_time" value="{{ old('end_time') }}">
                    @if($errors->has('end_time'))
                        <div class="invalid-feedback">
                            {{ $errors->first('end_time') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.examManagement.fields.end_time_helper') }}</span>
                </div>

                
               
                <div class="form-group col-6">
                    <label for="description" class="text-primary" style="font-weight:650;">{{ trans('cruds.examManagement.fields.description') }}</label>
                    <textarea class="form-control ckeditor {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{!! old('description') !!}</textarea>
                    @if($errors->has('description'))
                        <div class="invalid-feedback">
                            {{ $errors->first('description') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.examManagement.fields.description_helper') }}</span>
                </div>
                

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
                xhr.open('POST', '{{ route('admin.exam-managements.storeCKEditorImages') }}', true);
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
                data.append('crud_id', '{{ $examManagement->id ?? 0 }}');
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
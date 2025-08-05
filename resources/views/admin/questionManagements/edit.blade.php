@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h3>
            {{ trans('global.edit') }} {{ trans('cruds.questionManagement.title_singular') }}
        </h3>
       
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.question-managements.update", [$questionManagement->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="question" class="text-primary" style="font-weight:650;">{{ trans('cruds.questionManagement.fields.question') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('question') ? 'is-invalid' : '' }}" name="question" id="question">{!! old('question', $questionManagement->question) !!}</textarea>
                @if($errors->has('question'))
                    <div class="invalid-feedback">
                        {{ $errors->first('question') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.questionManagement.fields.question_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="text-primary" style="font-weight:650;">{{ trans('cruds.questionManagement.fields.question_type') }}</label>
                <select class="form-control {{ $errors->has('question_type') ? 'is-invalid' : '' }}" name="question_type" id="question_type">
                    <option value disabled {{ old('question_type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\QuestionManagement::QUESTION_TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('question_type', $questionManagement->question_type) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('question_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('question_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.questionManagement.fields.question_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="option_1" class="text-primary" style="font-weight:650;">{{ trans('cruds.questionManagement.fields.option_1') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('option_1') ? 'is-invalid' : '' }}" name="option_1" id="option_1">{!! old('option_1', $questionManagement->option_1) !!}</textarea>
                @if($errors->has('option_1'))
                    <div class="invalid-feedback">
                        {{ $errors->first('option_1') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.questionManagement.fields.option_1_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="option_2" class="text-primary" style="font-weight:650;">{{ trans('cruds.questionManagement.fields.option_2') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('option_2') ? 'is-invalid' : '' }}" name="option_2" id="option_2">{!! old('option_2', $questionManagement->option_2) !!}</textarea>
                @if($errors->has('option_2'))
                    <div class="invalid-feedback">
                        {{ $errors->first('option_2') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.questionManagement.fields.option_2_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="option_3" class="text-primary" style="font-weight:650;">{{ trans('cruds.questionManagement.fields.option_3') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('option_3') ? 'is-invalid' : '' }}" name="option_3" id="option_3">{!! old('option_3', $questionManagement->option_3) !!}</textarea>
                @if($errors->has('option_3'))
                    <div class="invalid-feedback">
                        {{ $errors->first('option_3') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.questionManagement.fields.option_3_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="option_4" class="text-primary" style="font-weight:650;">{{ trans('cruds.questionManagement.fields.option_4') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('option_4') ? 'is-invalid' : '' }}" name="option_4" id="option_4">{!! old('option_4', $questionManagement->option_4) !!}</textarea>
                @if($errors->has('option_4'))
                    <div class="invalid-feedback">
                        {{ $errors->first('option_4') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.questionManagement.fields.option_4_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="option_1_image" class="text-primary" style="font-weight:650;">{{ trans('cruds.questionManagement.fields.option_1_image') }}</label>
                <input class="form-control {{ $errors->has('option_1_image') ? 'is-invalid' : '' }}" type="text" name="option_1_image" id="option_1_image" value="{{ old('option_1_image', $questionManagement->option_1_image) }}">
                @if($errors->has('option_1_image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('option_1_image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.questionManagement.fields.option_1_image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="option_2_image" class="text-primary" style="font-weight:650;">{{ trans('cruds.questionManagement.fields.option_2_image') }}</label>
                <input class="form-control {{ $errors->has('option_2_image') ? 'is-invalid' : '' }}" type="text" name="option_2_image" id="option_2_image" value="{{ old('option_2_image', $questionManagement->option_2_image) }}">
                @if($errors->has('option_2_image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('option_2_image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.questionManagement.fields.option_2_image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="category_id" class="text-primary" style="font-weight:650;">{{ trans('cruds.questionManagement.fields.category') }}</label>
                <select class="form-control select2 {{ $errors->has('category') ? 'is-invalid' : '' }}" name="category_id" id="category_id">
                    @foreach($categories as $id => $entry)
                        <option value="{{ $id }}" {{ (old('category_id') ? old('category_id') : $questionManagement->category->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('category'))
                    <div class="invalid-feedback">
                        {{ $errors->first('category') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.questionManagement.fields.category_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="text-primary" style="font-weight:650;">{{ trans('cruds.questionManagement.fields.answer') }}</label>
                <select class="form-control {{ $errors->has('answer') ? 'is-invalid' : '' }}" name="answer" id="answer">
                    <option value disabled {{ old('answer', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\QuestionManagement::ANSWER_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('answer', $questionManagement->answer) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('answer'))
                    <div class="invalid-feedback">
                        {{ $errors->first('answer') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.questionManagement.fields.answer_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="terms" class="text-primary" style="font-weight:650;">{{ trans('cruds.questionManagement.fields.terms') }}</label>
                <input class="form-control {{ $errors->has('terms') ? 'is-invalid' : '' }}" type="text" name="terms" id="terms" value="{{ old('terms', $questionManagement->terms) }}">
                @if($errors->has('terms'))
                    <div class="invalid-feedback">
                        {{ $errors->first('terms') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.questionManagement.fields.terms_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="difficulty_level" class="text-primary" style="font-weight:650;">{{ trans('cruds.questionManagement.fields.difficulty_level') }}</label>
                <input class="form-control {{ $errors->has('difficulty_level') ? 'is-invalid' : '' }}" type="text" name="difficulty_level" id="difficulty_level" value="{{ old('difficulty_level', $questionManagement->difficulty_level) }}">
                @if($errors->has('difficulty_level'))
                    <div class="invalid-feedback">
                        {{ $errors->first('difficulty_level') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.questionManagement.fields.difficulty_level_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="explaination" class="text-primary" style="font-weight:650;">{{ trans('cruds.questionManagement.fields.explaination') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('explaination') ? 'is-invalid' : '' }}" name="explaination" id="explaination">{!! old('explaination', $questionManagement->explaination) !!}</textarea>
                @if($errors->has('explaination'))
                    <div class="invalid-feedback">
                        {{ $errors->first('explaination') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.questionManagement.fields.explaination_helper') }}</span>
            </div>
            <div class="form-group"> 
                <label for="explaination_image" class="text-primary" style="font-weight:650;">{{ trans('cruds.questionManagement.fields.explaination_image') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('explaination_image') ? 'is-invalid' : '' }}" name="explaination_image" id="explaination_image">{!! old('explaination_image', $questionManagement->explaination_image) !!}</textarea>
                @if($errors->has('explaination_image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('explaination_image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.questionManagement.fields.explaination_image_helper') }}</span>
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
                xhr.open('POST', '{{ route('admin.question-managements.storeCKEditorImages') }}', true);
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
                data.append('crud_id', '{{ $questionManagement->id ?? 0 }}');
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
@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <div>
            <h3>
                {{ trans('global.create') }} {{ trans('Question') }}
            </h3>
           
        </div>

        <div>
            <a class="btn btn-danger" href="{{ route('admin.all-questions', Str::slug($exam->exam_name, '-')) }}"> 
                All Questions
            </a>
            
        </div>

          <!-- Field to display dynamically fetched values -->
          <div class="form-group mt-3">
            <label for="max_attempt_q_sum" class="text-primary" style="font-weight:650;">Total Max Attempt Q:</label>
            <input type="text" id="max_attempt_q_sum" class="form-control" readonly>
        </div>
        
        <div class="form-group mt-3">
            <label for="added_q" class="text-primary" style="font-weight:650;"> Total Added Questions:</label>
            <input type="text" id="added_q" class="form-control" readonly>
        </div>

        <div class="form-group mt-3">
        
         <h5>total Q uploaded :  @if(isset($exam))
            ({{ \App\Models\QuestionManagement::where('exam_id', $exam->id)->count() }})
        @endif  </h5>
        </div>

  
    </div>

    

    <div class="card-body">

        <form method="POST" action="{{ route("admin.question-managements.store") }}" enctype="multipart/form-data">
            @csrf

            @if(isset($exam))
                <div class="alert alert-info">
                    <strong>Exam Name:</strong> {{ $exam->exam_name }}
                </div>

                {{-- <div class="alert alert-info">
                    <strong>Course:</strong> {{ $exam->course_id }}
                </div>
                 --}}
                <input type="hidden" name="exam_id" value="{{ $exam->id }}">

                <input type="hidden" name="course_id" value="{{ $exam->course_id }}">
            @endif


           <div class="row">
        <div class="form-group col-12 col-lg-6">
            <label class="text-primary" style="font-weight:650;">{{ trans('Category') }}</label>
            <select class="form-control select2" name="category_id" id="category_id">
                @foreach($categories as $id => $entry)
                    <option value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                @endforeach
            </select>
        </div>

            <div class="form-group col-12 col-lg-6">
                <label class="text-primary" style="font-weight:650;">{{ trans('cruds.questionManagement.fields.question_type') }}</label>
                <input type="text" id="added_q" class="form-control" value="MCQ" readonly>
            </div>

            <div class="form-group col-12 col-lg-6">
                <label for="question" class="text-primary" style="font-weight:650;">
                    {{ trans('cruds.questionManagement.fields.question') }} 
                    @if(isset($exam))
                        ({{ \App\Models\QuestionManagement::where('exam_id', $exam->id)->count() + 1 }})
                    @endif
                </label>
                <input class="form-control {{ $errors->has('question') ? 'is-invalid' : '' }}" name="question" id="question" value="{!! old('question') !!}">
                @if($errors->has('question'))
                    <div class="invalid-feedback">
                        {{ $errors->first('question') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.questionManagement.fields.question_helper') }}</span>
            </div>
            

          

            <div class="form-group col-12 col-lg-6">
                <label class="text-primary" style="font-weight:650;">{{ trans('cruds.questionManagement.fields.answer') }}</label>
                <select class="form-control {{ $errors->has('answer') ? 'is-invalid' : '' }}" name="answer" id="answer">
                    <option value disabled {{ old('answer', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\QuestionManagement::ANSWER_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('answer', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('answer'))
                    <div class="invalid-feedback">
                        {{ $errors->first('answer') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.questionManagement.fields.answer_helper') }}</span>
            </div>
    
          
    
    
    
              
                <div class="form-group col-12 col-lg-6">
                    <label for="option_1" class="text-primary" style="font-weight:650;">{{ trans('cruds.questionManagement.fields.option_1') }}</label>
                    <input class="form-control {{ $errors->has('option_1') ? 'is-invalid' : '' }}" name="option_1" id="option_1" value="{!! old('option_1') !!}"/>
                    @if($errors->has('option_1'))
                        <div class="invalid-feedback">
                            {{ $errors->first('option_1') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.questionManagement.fields.option_1_helper') }}</span>
                </div>
                <div class="form-group col-12 col-lg-6">
                    <label for="option_2" class="text-primary" style="font-weight:650;">{{ trans('cruds.questionManagement.fields.option_2') }}</label>
                    <input class="form-control  {{ $errors->has('option_2') ? 'is-invalid' : '' }}" name="option_2" id="option_2" value="{!! old('option_2') !!}">
                    @if($errors->has('option_2'))
                        <div class="invalid-feedback">
                            {{ $errors->first('option_2') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.questionManagement.fields.option_2_helper') }}</span>
                </div>
                <div class="form-group col-12 col-lg-6">
                    <label for="option_3" class="text-primary" style="font-weight:650;">{{ trans('cruds.questionManagement.fields.option_3') }}</label>
                    <input class="form-control  {{ $errors->has('option_3') ? 'is-invalid' : '' }}" name="option_3" id="option_3" value="{!! old('option_3') !!}">
                    @if($errors->has('option_3'))
                        <div class="invalid-feedback">
                            {{ $errors->first('option_3') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.questionManagement.fields.option_3_helper') }}</span>
                </div>
                <div class="form-group col-12 col-lg-6">
                    <label for="option_4" class="text-primary" style="font-weight:650;">{{ trans('cruds.questionManagement.fields.option_4') }}</label>
                    <input class="form-control  {{ $errors->has('option_4') ? 'is-invalid' : '' }}" name="option_4" id="option_4" value="{!! old('option_4') !!}">
                    @if($errors->has('option_4'))
                        <div class="invalid-feedback">
                            {{ $errors->first('option_4') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.questionManagement.fields.option_4_helper') }}</span>
                </div>
          
             
    
             
    
             
                <div class="form-group col-12 col-lg-6">
                    <label for="explaination" class="text-primary" style="font-weight:650;">{{ trans('cruds.questionManagement.fields.explaination') }}</label>
                    <textarea class="form-control ckeditor {{ $errors->has('explaination') ? 'is-invalid' : '' }}" name="explaination" id="explaination">{!! old('explaination') !!}</textarea>
                    @if($errors->has('explaination'))
                        <div class="invalid-feedback">
                            {{ $errors->first('explaination') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.questionManagement.fields.explaination_helper') }}</span>
                </div>

           </div>

        
      
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('Save & Next') }}
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



<script>
    $(document).ready(function () {
        $('#category_id').change(function () {
            var category_id = $(this).val();
            var course_id = $("input[name='course_id']").val();

            if (category_id) {
                $.ajax({
                    url: '/admin/get-exam-category/' + category_id + '/' + course_id,
                    type: 'GET',
                    success: function (data) {
                        if (data) {
                            $('#max_attempt_q_sum').val(data.max_attempt_q_sum || 0); // Update max_attempt_q sum
                            $('#added_q').val(data.added_q || 0); // Update total added questions
                        } else {
                            $('#max_attempt_q_sum').val(0);
                            $('#added_q').val(0);
                        }
                    }
                });
            } else {
                $('#max_attempt_q_sum').val('');
                $('#added_q').val('');
            }
        });
    });
</script>

@endsection
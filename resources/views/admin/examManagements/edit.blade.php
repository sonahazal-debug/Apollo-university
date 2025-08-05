@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h3>
            {{ trans('global.edit') }} {{ trans('cruds.examManagement.title_singular') }}
        </h3>
     
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.exam-managements.update", [$examManagement->id]) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">

               

                <div class="form-group col-6">
                    <label for="course_id" class="text-primary " style="font-weight:700;">{{ trans('cruds.examManagement.fields.course') }}</label>
                    <select class="form-control select2 {{ $errors->has('course') ? 'is-invalid' : '' }}" name="course_id" id="course_id">
                        @foreach($courses as $id => $entry)
                            <option value="{{ $id }}" {{ (old('course_id') ?? $examManagement->course_id) == $id ? 'selected' : '' }}>{{ $entry }}</option>
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
                    <label for="status" class="text-primary" style="font-weight:650;">{{ trans('cruds.examManagement.fields.status') }}</label>
                    <select class="form-control" name="status" id="status">
                        <option value disabled>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\Models\ExamManagement::STATUS_SELECT as $key => $label)
                            <option value="{{ $key }}" {{ (old('status') ?? $examManagement->status) == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

               

                <div class="form-group col-6">
                    <label for="exam_id" class="text-primary" style="font-weight:650;">{{ trans('Exam_id') }}</label>
                    <input class="form-control" type="text" name="exam_id" id="exam_id" value="{{ old('exam_id', $examManagement->exam_id) }}" readonly>
                </div>

                <div class="form-group col-6">
                    <label for="exam_name" class="text-primary" style="font-weight:650;">{{ trans('cruds.examManagement.fields.exam_name') }}</label>
                    <input class="form-control {{ $errors->has('exam_name') ? 'is-invalid' : '' }}" type="text" name="exam_name" id="exam_name" value="{{ old('exam_name', $examManagement->exam_name) }}">
                    @if($errors->has('exam_name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('exam_name') }}
                        </div>
                    @endif
                </div>

                <div class="form-group col-6">
                    <label for="start_date" class="text-primary" style="font-weight:650;">{{ trans('cruds.examManagement.fields.start_date') }}</label>
                    <input class="form-control date" type="text" name="start_date" id="start_date" value="{{ old('start_date', $examManagement->start_date) }}">
                </div>

                <div class="form-group col-6">
                    <label for="start_time" class="text-primary" style="font-weight:650;">{{ trans('cruds.examManagement.fields.start_time') }}</label>
                    <input class="form-control timepicker" type="text" name="start_time" id="start_time" value="{{ old('start_time', $examManagement->start_time) }}">
                </div>

                <div class="form-group col-6">
                    <label for="end_time" class="text-primary" style="font-weight:650;">{{ trans('cruds.examManagement.fields.end_time') }}</label>
                    <input class="form-control timepicker" type="text" name="end_time" id="end_time" value="{{ old('end_time', $examManagement->end_time) }}">
                </div>

                

                <div class="form-group col-6">
                    <label for="description" class="text-primary" style="font-weight:650;">{{ trans('cruds.examManagement.fields.description') }}</label>
                    <textarea class="form-control ckeditor" name="description" id="description">{!! old('description', $examManagement->description) !!}</textarea>
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
                        return loader.file.then(function (file) {
                            return new Promise(function(resolve, reject) {
                                var xhr = new XMLHttpRequest();
                                xhr.open('POST', '{{ route('admin.exam-managements.storeCKEditorImages') }}', true);
                                xhr.setRequestHeader('x-csrf-token', window._token);
                                xhr.setRequestHeader('Accept', 'application/json');
                                xhr.responseType = 'json';

                                xhr.addEventListener('error', function() { reject('Upload failed.') });
                                xhr.addEventListener('abort', function() { reject() });
                                xhr.addEventListener('load', function() {
                                    var response = xhr.response;

                                    if (!response || xhr.status !== 201) {
                                        return reject(response && response.message ? `${response.message}` : 'Upload failed.');
                                    }

                                    $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                                    resolve({ default: response.url });
                                });

                                var data = new FormData();
                                data.append('upload', file);
                                data.append('crud_id', '{{ $examManagement->id ?? 0 }}');
                                xhr.send(data);
                            });
                        });
                    }
                };
            }
        }

        var allEditors = document.querySelectorAll('.ckeditor');
        for (var i = 0; i < allEditors.length; ++i) {
            ClassicEditor.create(allEditors[i], {
                extraPlugins: [SimpleUploadAdapter]
            });
        }
    });
</script>
@endsection

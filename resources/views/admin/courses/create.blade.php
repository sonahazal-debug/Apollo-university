@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h3>
            {{ trans('global.create') }} {{ trans('cruds.course.title_singular') }}
        </h3>
       
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.courses.store") }}" enctype="multipart/form-data">
            @csrf

             <div class="form-group">
                <label class="required text-primary" for="title" style="font-weight:650;" >{{ trans('Image') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="file" name="image" id="title" value="{{ old('title', '') }}" required>
                @if($errors->has('title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                @endif
           
            </div>
            <div class="form-group">
                <label for="course_name" class="text-primary" style="font-weight:650;" >{{ trans('cruds.course.fields.course_name') }}</label>
                <input class="form-control {{ $errors->has('course_name') ? 'is-invalid' : '' }}" type="text" name="course_name" id="course_name" value="{{ old('course_name', '') }}">
                @if($errors->has('course_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('course_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.course.fields.course_name_helper') }}</span>
            </div>


            <div class="form-group">
                <label for="course_name" class="text-primary" style="font-weight:650;" >{{ trans('Category') }}</label>
                <select class="form-control select2" name="category_id[]" id="category_id" multiple>
                    @foreach($categories as $id => $entry)
                        <option value="{{ $id }}" {{ in_array($id, old('category_id', [])) ? 'selected' : '' }}>
                            {{ $entry }}
                        </option>
                    @endforeach
                </select>
                <span class="help-block">{{ trans('cruds.course.fields.course_name_helper') }}</span>
            </div>

           
            
            
            
            <div class="form-group">
                <label class="text-primary " style="font-weight:650;" >{{ trans('cruds.course.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Course::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.course.fields.status_helper') }}</span>
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
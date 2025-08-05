@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h3>
            {{ trans('global.edit') }} {{ trans('cruds.course.title_singular') }}
        </h3>
       
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.courses.update", [$course->id]) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="required text-primary" for="image" >{{ trans('Image') }}</label>
                <input class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}" type="file" name="image" id="image">
                @if($errors->has('image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </div>
                @endif
                @if($course->image)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $course->image) }}" width="100" alt="Course Image">
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="course_name" class="text-primary">{{ trans('cruds.course.fields.course_name') }}</label>
                <input class="form-control {{ $errors->has('course_name') ? 'is-invalid' : '' }}" type="text" name="course_name" id="course_name" value="{{ old('course_name', $course->course_name) }}">
                @if($errors->has('course_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('course_name') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label class="text-primary">{{ trans('Category') }}</label>
                <select class="form-control select2" name="category_id[]" id="category_id" multiple>
                    @foreach($categories as $id => $entry)
                        <option value="{{ $id }}" 
                            {{ in_array($id, $course->courseCategories->pluck('category_id')->toArray()) ? 'selected' : '' }}>
                            {{ $entry }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="text-primary">{{ trans('cruds.course.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Course::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ $course->status === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
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

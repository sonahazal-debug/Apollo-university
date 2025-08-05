@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h3>
            {{ trans('global.create') }} {{ trans('cruds.student.title_singular') }}
        </h3>
       
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.students.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name" class="text-primary" style="font-weight:650;" >{{ trans('cruds.student.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.student.fields.name_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="student_id " class="text-primary" style="font-weight:650;">Student ID</label>
                <input class="form-control" type="text" name="student_id" id="student_id" value="{{ $studentId }}" readonly>
                
            </div>

            
            <div class="form-group">
                <label for="phone " class="text-primary" style="font-weight:650;">{{ trans('cruds.student.fields.phone') }}</label>
                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', '') }}">
                @if($errors->has('phone'))
                    <div class="invalid-feedback">
                        {{ $errors->first('phone') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.student.fields.phone_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="email " class="text-primary" style="font-weight:650;">{{ trans('cruds.student.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text" name="email" id="email" value="{{ old('email', '') }}">
                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.student.fields.email_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="college" class="text-primary" style="font-weight:650;">{{ trans('cruds.student.fields.college') }}</label>
                <input class="form-control {{ $errors->has('college') ? 'is-invalid' : '' }}" type="text" name="college" id="college" value="{{ old('college', '') }}">
                @if($errors->has('college'))
                    <div class="invalid-feedback">
                        {{ $errors->first('college') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.student.fields.college_helper') }}</span>
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
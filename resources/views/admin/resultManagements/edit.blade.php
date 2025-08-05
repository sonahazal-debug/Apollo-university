@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.resultManagement.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.result-managements.update", [$resultManagement->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="student_id">{{ trans('cruds.resultManagement.fields.student') }}</label>
                <select class="form-control select2 {{ $errors->has('student') ? 'is-invalid' : '' }}" name="student_id" id="student_id">
                    @foreach($students as $id => $entry)
                        <option value="{{ $id }}" {{ (old('student_id') ? old('student_id') : $resultManagement->student->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('student'))
                    <div class="invalid-feedback">
                        {{ $errors->first('student') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.resultManagement.fields.student_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="total_questions">{{ trans('cruds.resultManagement.fields.total_questions') }}</label>
                <input class="form-control {{ $errors->has('total_questions') ? 'is-invalid' : '' }}" type="text" name="total_questions" id="total_questions" value="{{ old('total_questions', $resultManagement->total_questions) }}">
                @if($errors->has('total_questions'))
                    <div class="invalid-feedback">
                        {{ $errors->first('total_questions') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.resultManagement.fields.total_questions_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="total_attempted">{{ trans('cruds.resultManagement.fields.total_attempted') }}</label>
                <input class="form-control {{ $errors->has('total_attempted') ? 'is-invalid' : '' }}" type="text" name="total_attempted" id="total_attempted" value="{{ old('total_attempted', $resultManagement->total_attempted) }}">
                @if($errors->has('total_attempted'))
                    <div class="invalid-feedback">
                        {{ $errors->first('total_attempted') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.resultManagement.fields.total_attempted_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="total_correct">{{ trans('cruds.resultManagement.fields.total_correct') }}</label>
                <input class="form-control {{ $errors->has('total_correct') ? 'is-invalid' : '' }}" type="text" name="total_correct" id="total_correct" value="{{ old('total_correct', $resultManagement->total_correct) }}">
                @if($errors->has('total_correct'))
                    <div class="invalid-feedback">
                        {{ $errors->first('total_correct') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.resultManagement.fields.total_correct_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="total_wrong">{{ trans('cruds.resultManagement.fields.total_wrong') }}</label>
                <input class="form-control {{ $errors->has('total_wrong') ? 'is-invalid' : '' }}" type="text" name="total_wrong" id="total_wrong" value="{{ old('total_wrong', $resultManagement->total_wrong) }}">
                @if($errors->has('total_wrong'))
                    <div class="invalid-feedback">
                        {{ $errors->first('total_wrong') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.resultManagement.fields.total_wrong_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="score">{{ trans('cruds.resultManagement.fields.score') }}</label>
                <input class="form-control {{ $errors->has('score') ? 'is-invalid' : '' }}" type="text" name="score" id="score" value="{{ old('score', $resultManagement->score) }}">
                @if($errors->has('score'))
                    <div class="invalid-feedback">
                        {{ $errors->first('score') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.resultManagement.fields.score_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="rank">{{ trans('cruds.resultManagement.fields.rank') }}</label>
                <input class="form-control {{ $errors->has('rank') ? 'is-invalid' : '' }}" type="text" name="rank" id="rank" value="{{ old('rank', $resultManagement->rank) }}">
                @if($errors->has('rank'))
                    <div class="invalid-feedback">
                        {{ $errors->first('rank') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.resultManagement.fields.rank_helper') }}</span>
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
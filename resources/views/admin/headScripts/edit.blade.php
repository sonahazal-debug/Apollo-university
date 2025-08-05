@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.headScript.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.head-scripts.update", [$headScript->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="name">{{ trans('cruds.headScript.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $headScript->name) }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.headScript.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="script">{{ trans('cruds.headScript.fields.script') }}</label>
                <input class="form-control {{ $errors->has('script') ? 'is-invalid' : '' }}" type="text" name="script" id="script" value="{{ old('script', $headScript->script) }}">
                @if($errors->has('script'))
                    <div class="invalid-feedback">
                        {{ $errors->first('script') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.headScript.fields.script_helper') }}</span>
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
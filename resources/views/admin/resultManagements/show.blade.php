@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.resultManagement.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.result-managements.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.resultManagement.fields.id') }}
                        </th>
                        <td>
                            {{ $resultManagement->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.resultManagement.fields.student') }}
                        </th>
                        <td>
                            {{ $resultManagement->student->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.resultManagement.fields.total_questions') }}
                        </th>
                        <td>
                            {{ $resultManagement->total_questions }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.resultManagement.fields.total_attempted') }}
                        </th>
                        <td>
                            {{ $resultManagement->total_attempted }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.resultManagement.fields.total_correct') }}
                        </th>
                        <td>
                            {{ $resultManagement->total_correct }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.resultManagement.fields.total_wrong') }}
                        </th>
                        <td>
                            {{ $resultManagement->total_wrong }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.resultManagement.fields.score') }}
                        </th>
                        <td>
                            {{ $resultManagement->score }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.resultManagement.fields.rank') }}
                        </th>
                        <td>
                            {{ $resultManagement->rank }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.result-managements.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
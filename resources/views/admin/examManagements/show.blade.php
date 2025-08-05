@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.examManagement.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.exam-managements.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.examManagement.fields.id') }}
                        </th>
                        <td>
                            {{ $examManagement->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.examManagement.fields.course') }}
                        </th>
                        <td>
                            {{ $examManagement->course->course_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.examManagement.fields.test_type') }}
                        </th>
                        <td>
                            {{ $examManagement->test_type }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.examManagement.fields.exam_name') }}
                        </th>
                        <td>
                            {{ $examManagement->exam_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.examManagement.fields.exam_mode') }}
                        </th>
                        <td>
                            {{ App\Models\ExamManagement::EXAM_MODE_SELECT[$examManagement->exam_mode] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.examManagement.fields.start_date') }}
                        </th>
                        <td>
                            {{ $examManagement->start_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.examManagement.fields.start_time') }}
                        </th>
                        <td>
                            {{ $examManagement->start_time }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.examManagement.fields.end_time') }}
                        </th>
                        <td>
                            {{ $examManagement->end_time }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.examManagement.fields.description') }}
                        </th>
                        <td>
                            {!! $examManagement->description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.examManagement.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\ExamManagement::STATUS_SELECT[$examManagement->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.examManagement.fields.time_status') }}
                        </th>
                        <td>
                            {{ App\Models\ExamManagement::TIME_STATUS_SELECT[$examManagement->time_status] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.exam-managements.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
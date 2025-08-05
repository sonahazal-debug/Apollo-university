@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.questionManagement.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.question-managements.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.questionManagement.fields.id') }}
                        </th>
                        <td>
                            {{ $questionManagement->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.questionManagement.fields.question') }}
                        </th>
                        <td>
                            {!! $questionManagement->question !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.questionManagement.fields.question_type') }}
                        </th>
                        <td>
                            {{ App\Models\QuestionManagement::QUESTION_TYPE_SELECT[$questionManagement->question_type] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.questionManagement.fields.option_1') }}
                        </th>
                        <td>
                            {!! $questionManagement->option_1 !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.questionManagement.fields.option_2') }}
                        </th>
                        <td>
                            {!! $questionManagement->option_2 !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.questionManagement.fields.option_3') }}
                        </th>
                        <td>
                            {!! $questionManagement->option_3 !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.questionManagement.fields.option_4') }}
                        </th>
                        <td>
                            {!! $questionManagement->option_4 !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.questionManagement.fields.option_1_image') }}
                        </th>
                        <td>
                            {{ $questionManagement->option_1_image }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.questionManagement.fields.option_2_image') }}
                        </th>
                        <td>
                            {{ $questionManagement->option_2_image }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.questionManagement.fields.category') }}
                        </th>
                        <td>
                            {{ $questionManagement->category->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.questionManagement.fields.answer') }}
                        </th>
                        <td>
                            {{ App\Models\QuestionManagement::ANSWER_SELECT[$questionManagement->answer] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.questionManagement.fields.terms') }}
                        </th>
                        <td>
                            {{ $questionManagement->terms }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.questionManagement.fields.difficulty_level') }}
                        </th>
                        <td>
                            {{ $questionManagement->difficulty_level }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.questionManagement.fields.explaination') }}
                        </th>
                        <td>
                            {!! $questionManagement->explaination !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.questionManagement.fields.explaination_image') }}
                        </th>
                        <td>
                            {!! $questionManagement->explaination_image !!}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.question-managements.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
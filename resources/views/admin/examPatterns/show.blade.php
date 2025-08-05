@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.examPattern.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <a class="btn btn-default" href="{{ route('admin.exam-patterns.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>{{ trans('cruds.examPattern.fields.course') }}</th>
                        <td>{{ $examPattern->course->course_name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.examPattern.fields.category') }}</th>
                        <td>{{ $examPattern->category->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>Pass %</th>
                        <td>{{ $examPattern->pass_perc }}</td>
                    </tr>
                    <tr>
                        <th>Pass Marks</th>
                        <td>{{ $examPattern->pass_mark }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.examPattern.fields.status') }}</th>
                        <td>{{ App\Models\ExamPattern::STATUS_SELECT[$examPattern->status] ?? '' }}</td>
                    </tr>
                </tbody>
            </table>

            {{-- Dynamic Category Breakdown --}}
            <h4 class="mt-4">Exam Categories</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Category Name</th>
                        <th>Correct Mark</th>
                        <th>Negative Mark</th>
                        <th>Max Attempt Questions</th>
                        <th>Is Compulsory</th>
                        <th>Total Marks</th>
                        <th>Total Questions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($examPattern->examCategory as $category)
                        <tr>
                            <td>{{ $category->category->name ?? '-' }}</td>
                            <td>{{ $category->correct_mark }}</td>
                            <td>{{ $category->negative_mark }}</td>
                            <td>{{ $category->max_attemt_q }}</td>
                            <td>{{ $category->is_compulsory ? 'Yes' : 'No' }}</td>
                            <td>{{ $category->total_marks }}</td>
                            <td>{{ $category->total_questions }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <a class="btn btn-default mt-2" href="{{ route('admin.exam-patterns.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>
    </div>
</div>

@endsection


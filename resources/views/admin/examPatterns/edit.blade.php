@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h3>
            {{ trans('global.edit') }} {{ trans('cruds.examPattern.title_singular') }}
        </h3>
        
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.exam-patterns.update', $examPattern->id) }}">
            @csrf
            @method('PUT')

            <!-- Course -->
            <div class="form-group">
                <label for="course_id" class="text-primary">{{ trans('cruds.examPattern.fields.course') }}</label>
                <select name="course_id" class="form-control select2">
                    @foreach($courses as $id => $course)
                        <option value="{{ $id }}" {{ $examPattern->course_id == $id ? 'selected' : '' }}>{{ $course }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Categories -->
            @foreach($categories as $category)
                @php
                    $examCat = $examPattern->examCategory->firstWhere('category_id', $category->id);
                    $patterns = \App\Models\ExamPatternCategory::where('exam_pattern_id', $examPattern->id)
                        ->where('category_id', $category->id)
                        ->get();
                @endphp

                <div class="border rounded p-3 mb-4">
                    <h5>{{ $category->name }}</h5>

                    <input type="hidden" name="number_of_questions[{{ $category->id }}]" value="1">

                    <!-- Max Attempt -->
                    <div class="form-group">
                        <label class="text-primary">Max Attempt Q.</label>
                        <input type="text" name="max_attemt_q[{{ $category->id }}]" class="form-control" value="{{ old("max_attemt_q.$category->id", $examCat->max_attemt_q ?? '') }}">
                    </div>

                    <!-- Is Compulsory -->
                    {{-- <div class="form-group">
                        <label class="text-primary">Is Compulsory</label>
                        <select name="is_compulsory[{{ $category->id }}]" class="form-control">
                            <option value="yes" {{ (optional($examCat)->is_compulsory ?? '') == 'yes' ? 'selected' : '' }}>Yes</option>
                            <option value="no" {{ (optional($examCat)->is_compulsory ?? '') == 'no' ? 'selected' : '' }}>No</option>
                        </select>
                    </div> --}}

                    <!-- Pattern Rows -->
                    <label><strong>Pattern:</strong></label>
                    <div class="pattern-rows">
                        @foreach($patterns as $index => $pattern)
                            <div class="row mb-2">
                                <div class="col-md-3">
                                    <input type="text" name="from[{{ $category->id }}][{{ $index }}]" class="form-control" placeholder="From" value="{{ $pattern->from }}">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="to[{{ $category->id }}][{{ $index }}]" class="form-control" placeholder="To" value="{{ $pattern->to }}">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="correct_mark[{{ $category->id }}][{{ $index }}]" class="form-control" placeholder="Correct Mark" value="{{ $pattern->correct_mark }}">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="negative_mark[{{ $category->id }}][{{ $index }}]" class="form-control" placeholder="Negative Mark" value="{{ $pattern->negative_mark }}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <!-- Pass % -->
            <div class="form-group">
                <label for="pass_perc" class="text-primary">Pass Percentage (%)</label>
                <input type="text" name="pass_perc" class="form-control" value="{{ old('pass_perc', $examPattern->pass_perc) }}">
            </div>

            <!-- Pass Marks -->
            <div class="form-group">
                <label for="pass_mark" class="text-primary">Pass Marks</label>
                <input type="text" name="pass_mark" class="form-control" value="{{ old('pass_mark', $examPattern->pass_mark) }}">
            </div>

            <!-- Status -->
            <div class="form-group">
                <label for="status" class="text-primary">Status</label>
                <select name="status" class="form-control">
                    <option value="active" {{ $examPattern->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $examPattern->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <!-- Submit -->
            <div class="form-group mt-4">
                <button class="btn btn-success" type="submit">Update</button>
                <a href="{{ route('admin.exam-patterns.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection

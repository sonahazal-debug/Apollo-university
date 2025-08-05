<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyExamPatternRequest;
use App\Http\Requests\StoreExamPatternRequest;
use App\Http\Requests\UpdateExamPatternRequest;
use App\Models\CategoryManagement;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\ExamCategory;
use App\Models\ExamPattern;
use App\Models\ExamPatternCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ExamPatternController extends Controller
{
    use CsvImportTrait;


    public function index()
    {
        abort_if(Gate::denies('exam_pattern_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // Eager load relationships
        $examPatterns = ExamPattern::with(['course', 'category', 'examCategory'])->get();
        $examCategories = ExamCategory::with(['course', 'category', 'examPattern'])->get(); // includes CategoryManagement

        return view('admin.examPatterns.index', compact('examPatterns', 'examCategories'));
    }




    public function create()
    {
        abort_if(Gate::denies('exam_pattern_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('course_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $categories = CategoryManagement::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.examPatterns.create', compact('categories', 'courses'));
    }



    public function store(StoreExamPatternRequest $request)
{
    // Create the ExamPattern record
    $examPattern = ExamPattern::create([
        'course_id' => $request->course_id,
        'status' => $request->status,
        'pass_perc' => $request->pass_perc,
        'pass_mark' => $request->pass_mark,
    ]);

    // Now loop over the submitted category IDs
    if ($request->has('from')) {
        foreach ($request->from as $categoryId => $fromValues) {
            // We'll use only the first pattern row for now (index 0)
            ExamCategory::create([
                'course_id' => $request->course_id,
                'exam_pattern_id' => $examPattern->id,
                'category_id' => $categoryId,
                'max_attemt_q' => (int) ($request->max_attemt_q[$categoryId] ?? 0),
                'from' => isset($fromValues[0]) ? (int) $fromValues[0] : null,
                'to' => isset($request->to[$categoryId][0]) ? (int) $request->to[$categoryId][0] : null,
                'correct_mark' => isset($request->correct_mark[$categoryId][0]) ? (int) $request->correct_mark[$categoryId][0] : null,
                'negative_mark' => isset($request->negative_mark[$categoryId][0]) ? (int) $request->negative_mark[$categoryId][0] : null,
            ]);
        }
    }

    return redirect()->route('admin.exam-patterns.index')->with('success', 'Exam pattern created successfully.');
}




public function edit(ExamPattern $examPattern)
{
    abort_if(Gate::denies('exam_pattern_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    $courses = Course::pluck('course_name', 'id')->prepend(trans('global.pleaseSelect'), '');

    // Load related categories and pattern categories
    $examPattern->load('examCategory');
    $categories = ExamCategory::all();

    return view('admin.examPatterns.edit', compact('courses','categories', 'examPattern'));
}



public function update(UpdateExamPatternRequest $request, ExamPattern $examPattern)
{
    // Update ExamPattern record
    $examPattern->update([
        'course_id' => $request->course_id,
        'status' => $request->status,
        'pass_perc' => $request->pass_perc,
        'pass_mark' => $request->pass_mark,
    ]);

    // Sync Exam Categories
    $existingCategories = $examPattern->examCategory->keyBy('category_id');

    if ($request->has('number_of_questions')) {
        foreach ($request->number_of_questions as $categoryId => $numQuestions) {
            $examCategory = $existingCategories[$categoryId] ?? new ExamCategory();
            $examCategory->fill([
                'course_id' => $request->course_id,
                'exam_pattern_id' => $examPattern->id,
                'category_id' => $categoryId,
                'number_of_questions' => $numQuestions,
                'max_attemt_q' => $request->max_attemt_q[$categoryId] ?? null,
                'is_compulsory' => $request->is_compulsory[$categoryId] ?? 'no',
            ])->save();

            // Sync ExamPatternCategory
            $existingPatterns = ExamPatternCategory::where('exam_pattern_id', $examPattern->id)
                ->where('category_id', $categoryId)
                ->get();

            ExamPatternCategory::where('exam_pattern_id', $examPattern->id)
                ->where('category_id', $categoryId)
                ->delete();

            if ($request->has("from.$categoryId")) {
                foreach ($request->from[$categoryId] as $index => $fromValue) {
                    ExamPatternCategory::create([
                        'course_id' => $request->course_id,
                        'exam_pattern_id' => $examPattern->id,
                        'category_id' => $categoryId,
                        'from' => $fromValue,
                        'to' => $request->to[$categoryId][$index] ?? null,
                        'correct_mark' => $request->correct_mark[$categoryId][$index] ?? null,
                        'negative_mark' => $request->negative_mark[$categoryId][$index] ?? null,
                    ]);
                }
            }
        }
    }

    return redirect()->route('admin.exam-patterns.index')->with('success', 'Exam pattern updated successfully.');
}

public function show(ExamPattern $examPattern)
{
    abort_if(Gate::denies('exam_pattern_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    $examPattern->load('course', 'category', 'examCategory.category');

    return view('admin.examPatterns.show', compact('examPattern'));
}

    public function destroy(ExamPattern $examPattern)
    {
        abort_if(Gate::denies('exam_pattern_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $examPattern->delete();

        return back();
    }

    // public function massDestroy(MassDestroyExamPatternRequest $request)
    // {
    //     $examPatterns = ExamPattern::find(request('ids'));

    //     foreach ($examPatterns as $examPattern) {
    //         $examPattern->delete();
    //     }

    //     return response(null, Response::HTTP_NO_CONTENT);
    // }

    public function massDestroy(MassDestroyExamPatternRequest $request)
{
    $examPatterns = ExamPattern::find(request('ids'));

    foreach ($examPatterns as $examPattern) {
        $examPattern->delete();
    }

    return response(null, Response::HTTP_NO_CONTENT);
}




    public function getCourseCategories(Request $request)
{
    $categories = CourseCategory::where('course_id', $request->course_id)
        ->with('category') // Load category details
        ->get()
        ->map(function($courseCategory) {
            return [
                'id' => $courseCategory->category->id,
                'name' => $courseCategory->category->name
            ];
        });

    return response()->json(['categories' => $categories]);
}



}

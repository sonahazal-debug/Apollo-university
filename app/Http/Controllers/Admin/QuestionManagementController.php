<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyQuestionManagementRequest;
use App\Http\Requests\StoreQuestionManagementRequest;
use App\Http\Requests\UpdateQuestionManagementRequest;
use App\Models\CategoryManagement;
use App\Models\ExamCategory;
use App\Models\ExamManagement;
use App\Models\QuestionManagement;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class QuestionManagementController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('question_management_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = QuestionManagement::with(['category'])->select(sprintf('%s.*', (new QuestionManagement)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'question_management_show';
                $editGate      = 'question_management_edit';
                $deleteGate    = 'question_management_delete';
                $crudRoutePart = 'question-managements';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('question_type', function ($row) {
                return $row->question_type ? QuestionManagement::QUESTION_TYPE_SELECT[$row->question_type] : '';
            });
            $table->editColumn('option_1_image', function ($row) {
                return $row->option_1_image ? $row->option_1_image : '';
            });
            $table->editColumn('option_2_image', function ($row) {
                return $row->option_2_image ? $row->option_2_image : '';
            });
            $table->addColumn('category_name', function ($row) {
                return $row->category ? $row->category->name : '';
            });

            $table->editColumn('answer', function ($row) {
                return $row->answer ? QuestionManagement::ANSWER_SELECT[$row->answer] : '';
            });
            $table->editColumn('terms', function ($row) {
                return $row->terms ? $row->terms : '';
            });
            $table->editColumn('difficulty_level', function ($row) {
                return $row->difficulty_level ? $row->difficulty_level : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'category']);

            return $table->make(true);
        }

        return view('admin.questionManagements.index');
    }


    public function allQuestions($slug)
    {
        abort_if(Gate::denies('exam_pattern_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        // Retrieve the exam details
        $exam = ExamManagement::whereRaw("LOWER(REPLACE(exam_name, ' ', '-')) = ?", [Str::slug($slug)])
            ->first(['id', 'exam_name']);  
    
        // Check if the exam exists
        if (!$exam) {
            return redirect()->back()->with('error', 'Exam not found.');
        }
    
        // Retrieve questions where exam_id matches the found exam ID
        $questions = QuestionManagement::with('category')
            ->where('exam_id', $exam->id)
            ->get();
    
        // If no questions found, return with an alert message
        if ($questions->isEmpty()) {
            return redirect()->back()->with('error', 'There are no questions in this category.');
        }
    
        return view('admin.questionManagements.index', compact('questions', 'exam'));
    }
    


    public function create()
    {
        abort_if(Gate::denies('question_management_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = CategoryManagement::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.questionManagements.create', compact('categories'));
    }


    public function addQuestion($slug)
    {
        // Check permissions
        abort_if(Gate::denies('question_management_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        // Find the exam based on the slug
        $exam = ExamManagement::whereRaw("LOWER(REPLACE(exam_name, ' ', '-')) = ?", [strtolower($slug)])->firstOrFail();
    
        // Fetch categories for the dropdown
        $categories = CategoryManagement::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
    
        // Get all ExamCategory records where course_id matches
        $examCategories = ExamCategory::where('course_id', $exam->course_id)->get();
    
        return view('admin.questionManagements.create', compact('categories', 'exam', 'examCategories'));
    }
    
    



    public function store(StoreQuestionManagementRequest $request)
    {

        //dd($request->all());

        $questionManagement = QuestionManagement::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $questionManagement->id]);
        }

        return redirect()->back()->with('success','question added successfully');
    }

    public function edit(QuestionManagement $questionManagement)
    {
        abort_if(Gate::denies('question_management_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = CategoryManagement::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $questionManagement->load('category');

        return view('admin.questionManagements.edit', compact('categories', 'questionManagement'));
    }

    public function update(UpdateQuestionManagementRequest $request, QuestionManagement $questionManagement)
    {
        $questionManagement->update($request->all());

        return redirect()->route('admin.question-managements.index');
    }

    public function show(QuestionManagement $questionManagement)
    {
        abort_if(Gate::denies('question_management_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $questionManagement->load('category');

        return view('admin.questionManagements.show', compact('questionManagement'));
    }

    public function destroy(QuestionManagement $questionManagement)
    {
        abort_if(Gate::denies('question_management_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $questionManagement->delete();

        return back();
    }

    public function massDestroy(MassDestroyQuestionManagementRequest $request)
    {
        $questionManagements = QuestionManagement::find(request('ids'));

        foreach ($questionManagements as $questionManagement) {
            $questionManagement->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('question_management_create') && Gate::denies('question_management_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new QuestionManagement();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }


    public function getExamCategory($category_id, $course_id)
    {
        $maxAttemptQSum = ExamCategory::where('course_id', $course_id)
                                      ->where('category_id', $category_id)
                                      ->sum('max_attemt_q'); // Ensure the correct column name
    
        $addedQ = QuestionManagement::where('course_id', $course_id)
                                    ->where('category_id', $category_id)
                                    ->count(); // Count of added questions
    
        return response()->json([
            'max_attempt_q_sum' => $maxAttemptQSum,
            'added_q' => $addedQ
        ]);
    }
    


    
}

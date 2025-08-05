<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyExamManagementRequest;
use App\Http\Requests\StoreExamManagementRequest;
use App\Http\Requests\UpdateExamManagementRequest;
use App\Models\CategoryManagement;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\ExamManagement;
use App\Models\QuestionManagement;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ExamManagementController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;



    // public function index(Request $request)
    // {
    //     abort_if(Gate::denies('exam_management_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    //     if ($request->ajax()) {
    //         $query = ExamManagement::with(['course'])->select(sprintf('%s.*', (new ExamManagement)->table))->get();
    //         $total = $query->count();

    //         $table = DataTables::of($query)
    //             ->addColumn('sno', function ($row) use (&$total) {
    //                 return $total--;
    //             })
    //             ->addColumn('placeholder', '&nbsp;')
    //             ->addColumn('actions', '&nbsp;');

    //         $table->editColumn('actions', function ($row) {
    //             $viewGate = 'exam_management_show';
    //             $editGate = 'exam_management_edit';
    //             $deleteGate = 'exam_management_delete';
    //             $crudRoutePart = 'exam-managements';

    //             return view('partials.datatablesActions', compact(
    //                 'viewGate',
    //                 'editGate',
    //                 'deleteGate',
    //                 'crudRoutePart',
    //                 'row'
    //             ));
    //         });

    //         $table->editColumn('id', fn($row) => $row->id ?: '');
    //         $table->addColumn('course_course_name', fn($row) => $row->course ? $row->course->course_name : '');
    //         $table->editColumn('test_type', fn($row) => $row->test_type ?: '');
    //         $table->editColumn('exam_name', fn($row) => $row->exam_name ?: '');
    //         $table->editColumn('start_time', fn($row) => $row->start_time ?: '');
    //         $table->editColumn('end_time', fn($row) => $row->end_time ?: '');
    //         $table->editColumn('status', fn($row) => $row->status ? ExamManagement::STATUS_SELECT[$row->status] : '');

    //         $table->addColumn('time_status', function ($row) {
    //             $colors = [
    //                 'Upcoming' => '#007bff',
    //                 'Ongoing'  => '#28a745',
    //                 'Over'     => '#dc3545',
    //                 'Unknown'  => '#6c757d',
    //             ];

    //             $color = $colors[$row->time_status] ?? '#6c757d';

    //             return '<span style="background-color: ' . $color . '; color: #fff; padding: 5px 10px; border-radius: 5px; font-weight: bold;">'
    //                 . $row->time_status . '</span>';
    //         });

    //         $table->rawColumns(['actions', 'placeholder', 'course', 'time_status']);

    //         return $table->make(true);
    //     }

    //     $examManagements = ExamManagement::with('course')->get();

    //     $examManagements->map(function ($exam) {
    //         $categoryIds = CourseCategory::where('course_id', $exam->course_id)->pluck('category_id');
    //         $categoryNames = CategoryManagement::whereIn('id', $categoryIds)->pluck('name')->toArray();
    //         $exam->category_names = $categoryNames;
    //         return $exam;
    //     });

    //     return view('admin.examManagements.index', compact('examManagements'));
    // }

    public function index(Request $request)
    {
        abort_if(Gate::denies('exam_management_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = ExamManagement::with(['course'])->select(sprintf('%s.*', (new ExamManagement)->table));
            $total = $query->count();

            $table = DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('sno', function ($row) use (&$total) {
                    return $total--;
                })
                ->addColumn('placeholder', '&nbsp;')
                ->addColumn('actions', function ($row) {
                    $viewUrl       = route('admin.exam-managements.show', $row->id);
                    $editUrl       = route('admin.exam-managements.edit', $row->id);
                    $resultsUrl    = route('admin.result-managements.index', $row->id);
                    $deleteUrl     = route('admin.exam-managements.destroy', $row->id);
                    $addQuestions  = route('admin.add-questions', \Str::slug($row->exam_name, '-'));
                    $downloadPdf   = route('admin.key-sheet', [$row->id, $row->course_id]);

                    return '
                          <a href="' . $viewUrl . '" class="btn btn-sm btn-success">View</a>
                        <a href="' . $editUrl . '" class="btn btn-sm btn-info">Edit</a>
                        <a href="' . $resultsUrl . '" class="btn btn-sm btn-warning">Results</a>

                        <form action="' . $deleteUrl . '" method="POST" style="display: inline-block;" onsubmit="return confirm(\'' . trans('global.areYouSure') . '\');">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>

                        <a href="' . $addQuestions . '" class="btn btn-sm btn-primary">Add Questions</a>
                        <a href="' . $downloadPdf . '" class="btn btn-sm btn-dark">Download Key PDF</a>
                    ';
                });

            $table->editColumn('id', fn($row) => $row->id ?: '');
            $table->addColumn('course_course_name', fn($row) => $row->course ? $row->course->course_name : '');
            $table->editColumn('exam_name', fn($row) => $row->exam_name ?: '');
            $table->editColumn('start_date', fn($row) => $row->start_date ?: '');
            $table->editColumn('start_time', fn($row) => $row->start_time ?: '');
            $table->editColumn('end_time', fn($row) => $row->end_time ?: '');
            $table->editColumn('status', fn($row) => $row->status ? ExamManagement::STATUS_SELECT[$row->status] : '');

            $table->addColumn('category_names', function ($row) {
                $categoryIds = CourseCategory::where('course_id', $row->course_id)->pluck('category_id');
                $categoryNames = CategoryManagement::whereIn('id', $categoryIds)->pluck('name')->toArray();
                return implode(', ', $categoryNames);
            });

            $table->addColumn('time_status', function ($row) {
                $colors = [
                    'Upcoming' => '#007bff',
                    'Ongoing'  => '#28a745',
                    'Over'     => '#dc3545',
                    'Unknown'  => '#6c757d',
                ];
                $color = $colors[$row->time_status] ?? '#6c757d';

                return '<span style="background-color: ' . $color . '; color: #fff; padding: 5px 10px; border-radius: 5px; font-weight: bold;">'
                    . $row->time_status . '</span>';
            });

            $table->rawColumns(['actions', 'placeholder', 'time_status']);

            return $table->make(true);
        }

        // Non-AJAX fallback view
        $examManagements = ExamManagement::with('course')->get();

        $examManagements->map(function ($exam) {
            $categoryIds = CourseCategory::where('course_id', $exam->course_id)->pluck('category_id');
            $categoryNames = CategoryManagement::whereIn('id', $categoryIds)->pluck('name')->toArray();
            $exam->category_names = $categoryNames;
            return $exam;
        });

        return view('admin.examManagements.index', compact('examManagements'));
    }



   // Generate random exam_id (e.g., EXAM-48321)



    public function create()
    {
        abort_if(Gate::denies('exam_management_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('course_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $randomExamId =  strtoupper(Str::random(7)) . rand(1000, 9999);

        return view('admin.examManagements.create', compact('courses','randomExamId'));
    }

    public function store(StoreExamManagementRequest $request)
    {
        $examManagement = ExamManagement::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $examManagement->id]);
        }

        return redirect()->route('admin.exam-managements.index');
    }

    public function edit(ExamManagement $examManagement)
{
    abort_if(Gate::denies('exam_management_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    $courses = Course::pluck('course_name', 'id')->prepend(trans('global.pleaseSelect'), '');
    $examManagement->load('course');

    return view('admin.examManagements.edit', compact('courses', 'examManagement'));
}


public function update(UpdateExamManagementRequest $request, ExamManagement $examManagement)
{
    $examManagement->update($request->all());

    if ($media = $request->input('ck-media', false)) {
        Media::whereIn('id', $media)->update(['model_id' => $examManagement->id]);
    }

    return redirect()->route('admin.exam-managements.index');
}


    public function show(ExamManagement $examManagement)
    {
        abort_if(Gate::denies('exam_management_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $examManagement->load('course');

        return view('admin.examManagements.show', compact('examManagement'));
    }

    public function destroy(ExamManagement $examManagement)
    {
        abort_if(Gate::denies('exam_management_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $examManagement->delete();

        return back();
    }

    public function massDestroy(MassDestroyExamManagementRequest $request)
    {
        $examManagements = ExamManagement::find(request('ids'));

        foreach ($examManagements as $examManagement) {
            $examManagement->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('exam_management_create') && Gate::denies('exam_management_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new ExamManagement();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }




public function KeySheet($id, $course_id)
{
    $exam = ExamManagement::where('id', $id)
                ->where('course_id', $course_id)
                ->first();

    if (!$exam) {
        abort(404, 'Exam not found');
    }

    $questions = QuestionManagement::where('exam_id', $id)
                    ->where('course_id', $course_id)
                    ->get();

    $setting = Setting::latest()->first();

    $pdf = Pdf::loadView('frontend.key-sheet', compact('exam', 'questions', 'setting'))
              ->setPaper('a4', 'portrait');

    return $pdf->download('KeySheet_'.$exam->exam_name.'.pdf');
}

}

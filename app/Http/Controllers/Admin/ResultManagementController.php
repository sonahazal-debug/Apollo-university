<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyResultManagementRequest;
use App\Http\Requests\StoreResultManagementRequest;
use App\Http\Requests\UpdateResultManagementRequest;
use App\Models\ExamManagement;
use App\Models\ResultManagement;
use App\Models\Setting;
use App\Models\Student;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ResultManagementController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
{
    $query = ResultManagement::with(['student', 'course', 'exam']);

    if ($request->has('exam_id') && $request->exam_id != '') {
        $query->where('exam_id', $request->exam_id);
    }

    $resultManagements = $query->orderByDesc('score')->get();

    $setting = Setting::latest()->first();

    $sorted = $resultManagements->sortByDesc('score')->values();

    $currentRank = 1;
    foreach ($sorted as $key => $ranked) {
        if ($key > 0 && $ranked->score == $sorted[$key - 1]->score) {
            $ranked->rank = $sorted[$key - 1]->rank;
        } else {
            $ranked->rank = $currentRank;
        }
        $currentRank++;
    }

    // Fetch all exams for the dropdown
    $exams = ExamManagement::pluck('exam_name', 'id');

    return view('admin.resultManagements.index', compact('resultManagements', 'setting', 'exams'));
}

    



    public function create()
    {
        abort_if(Gate::denies('result_management_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $students = Student::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.resultManagements.create', compact('students'));
    }

    public function store(StoreResultManagementRequest $request)
    {
        $resultManagement = ResultManagement::create($request->all());

        return redirect()->route('admin.result-managements.index');
    }

    public function edit(ResultManagement $resultManagement)
    {
        abort_if(Gate::denies('result_management_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $students = Student::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $resultManagement->load('student');

        return view('admin.resultManagements.edit', compact('resultManagement', 'students'));
    }

    public function update(UpdateResultManagementRequest $request, ResultManagement $resultManagement)
    {
        $resultManagement->update($request->all());

        return redirect()->route('admin.result-managements.index');
    }

    public function show(ResultManagement $resultManagement)
    {
        abort_if(Gate::denies('result_management_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resultManagement->load('student');

        return view('admin.resultManagements.show', compact('resultManagement'));
    }

    public function destroy(ResultManagement $resultManagement)
    {
        abort_if(Gate::denies('result_management_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resultManagement->delete();

        return back();
    }

    public function massDestroy(MassDestroyResultManagementRequest $request)
    {
        $resultManagements = ResultManagement::find(request('ids'));

        foreach ($resultManagements as $resultManagement) {
            $resultManagement->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

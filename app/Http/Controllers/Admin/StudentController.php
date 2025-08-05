<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyStudentRequest;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Student;
use Gate;
use Illuminate\Http\Request;
use Str;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class StudentController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
{
    abort_if(Gate::denies('student_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    if ($request->ajax()) {
        $query = Student::query()->with('studentExams')->select(sprintf('%s.*', (new Student)->table));

        $students = $query->get();
        $total = $students->count();

        $table = Datatables::of($students)
            ->addColumn('sno', function ($row) use (&$total) {
                return $total--;
            })
            ->addColumn('placeholder', '&nbsp;')
            ->addColumn('actions', '&nbsp;');

        $table->editColumn('actions', function ($row) {
            $viewGate      = 'student_show';
            $editGate      = 'student_edit';
            $deleteGate    = 'student_delete';
            $crudRoutePart = 'students';

            return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
        });

        $table->editColumn('id', fn($row) => $row->id ?? '');
        $table->editColumn('name', fn($row) => $row->name ?? '');
        $table->editColumn('phone', fn($row) => $row->phone ?? '');
        $table->editColumn('alternate_phone', fn($row) => $row->alternate_phone ?? '');
        $table->editColumn('email', fn($row) => $row->email ?? '');
        $table->editColumn('college', fn($row) => $row->college ?? '');
        $table->editColumn('course', fn($row) => $row->course ?? '');

        $table->addColumn('exams', function ($row) {
            $examIds = $row->studentExams->pluck('exam_id')->unique();
            $examNames = \App\Models\ExamManagement::whereIn('id', $examIds)->pluck('exam_name')->toArray();
            return implode(', ', $examNames);
        });

        $table->rawColumns(['actions', 'placeholder']);

        return $table->make(true);
    }

    return view('admin.students.index');
}

    public function create()
    {
        abort_if(Gate::denies('student_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');


      $studentId = 'STU' . strtoupper(Str::random(7)); // e.g., STU4A7T2K

       return view('admin.students.create', compact('studentId'));
    }

    public function store(StoreStudentRequest $request)
    {
        $student = Student::create($request->all());

        return redirect()->route('admin.students.index');
    }

    public function edit(Student $student)
    {
        abort_if(Gate::denies('student_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.students.edit', compact('student'));
    }

    public function update(UpdateStudentRequest $request, Student $student)
    {
        $student->update($request->all());

        return redirect()->route('admin.students.index');
    }

    public function show(Student $student)
    {
        abort_if(Gate::denies('student_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $student->load('studentExams.exam'); // Load related exams via studentExams
        return view('admin.students.show', compact('student'));
    }

    public function destroy(Student $student)
    {
        abort_if(Gate::denies('student_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $student->delete();

        return back();
    }

    public function massDestroy(MassDestroyStudentRequest $request)
    {
        $students = Student::find(request('ids'));

        foreach ($students as $student) {
            $student->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

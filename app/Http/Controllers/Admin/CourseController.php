<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyCourseRequest;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\CategoryManagement;
use App\Models\Course;
use App\Models\CourseCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CourseController extends Controller
{
    use CsvImportTrait;

    // public function index(Request $request)
    // {
    //     abort_if(Gate::denies('course_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    //     if ($request->ajax()) {
    //         $query = Course::with(['category'])->select(sprintf('%s.*', (new Course)->table));
    //         $table = Datatables::of($query);

    //         $table->addColumn('placeholder', '&nbsp;');
    //         $table->addColumn('actions', '&nbsp;');

    //         $table->editColumn('actions', function ($row) {
    //             $viewGate      = 'course_show';
    //             $editGate      = 'course_edit';
    //             $deleteGate    = 'course_delete';
    //             $crudRoutePart = 'courses';

    //             return view('partials.datatablesActions', compact(
    //                 'viewGate',
    //                 'editGate',
    //                 'deleteGate',
    //                 'crudRoutePart',
    //                 'row'
    //             ));
    //         });

    //         $table->editColumn('id', function ($row) {
    //             return $row->id ? $row->id : '';
    //         });
    //         $table->editColumn('course_name', function ($row) {
    //             return $row->course_name ? $row->course_name : '';
    //         });
    //         $table->addColumn('category_name', function ($row) {
    //             return $row->category ? $row->category->name : '';
    //         });

    //         $table->editColumn('image', function ($row) {
    //             return $row->image ? '<img width="100px" src="'.asset('storage/'.trim($row->image, '/')).'">' : '';
    //         });

    //         $table->editColumn('status', function ($row) {
    //             return $row->status ? Course::STATUS_SELECT[$row->status] : '';
    //         });

    //         $table->rawColumns(['actions', 'placeholder', 'category','image']);

    //         return $table->make(true);
    //     }

    //     return view('admin.courses.index');
    // }

    public function index(Request $request)
    {
        abort_if(Gate::denies('course_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Course::with(['category'])->select(sprintf('%s.*', (new Course)->table));
            $total = $query->count(); // Get total records

            $table = Datatables::of($query)
                ->addColumn('sno', function ($row) use (&$total) {
                    return $total--; // Decrementing gives reverse order
                });

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'course_show';
                $editGate = 'course_edit';
                $deleteGate = 'course_delete';
                $crudRoutePart = 'courses';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', fn($row) => $row->id);
            $table->editColumn('course_name', fn($row) => $row->course_name ?? '');
            $table->addColumn('category_name', fn($row) => $row->category->name ?? '');
            $table->editColumn('image', fn($row) => $row->image ? '<img width="100px" src="' . asset('storage/' . trim($row->image, '/')) . '">' : '');
            $table->editColumn('status', fn($row) => $row->status ? Course::STATUS_SELECT[$row->status] : '');

            $table->rawColumns(['actions', 'placeholder', 'image']);

            return $table->make(true);
        }


        return view('admin.courses.index');
    }


    public function create()
    {
        abort_if(Gate::denies('course_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = CategoryManagement::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.courses.create', compact('categories'));
    }

    public function store(StoreCourseRequest $request)
{
    // Create Course

    $course = new Course();
        $course->course_name = $request->course_name;
        $course->status = $request->status;

        if ($request->hasFile('image')) {
            $imgPath = $request->file('image')->store('uploads', 'public');
            $course->image = $imgPath;
        }

        $course->save();



    // Save multiple categories
    if ($request->has('category_id')) {
        foreach ($request->category_id as $categoryId) {
            $category = CategoryManagement::find($categoryId);
            if ($category) {
                CourseCategory::create([
                    'course_id'     => $course->id,
                    'category_id'   => $categoryId, // Assuming category name exists
                ]);
            }
        }
    }

    return redirect()->route('admin.courses.index');
}


public function edit(Course $course)
{
    abort_if(Gate::denies('course_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    $categories = CategoryManagement::pluck('name', 'id');
    $course->load('courseCategories');

    return view('admin.courses.edit', compact('categories', 'course'));
}


public function update(UpdateCourseRequest $request, Course $course)
{
    // Update basic fields
    $course->course_name = $request->course_name;
    $course->status = $request->status;

    // Handle image replacement
    if ($request->hasFile('image')) {
        // Optional: delete old image
        if ($course->image && \Storage::disk('public')->exists($course->image)) {
            \Storage::disk('public')->delete($course->image);
        }

        $course->image = $request->file('image')->store('uploads', 'public');
    }

    $course->save();

    // Sync categories
    $course->courseCategories()->delete(); // Clear old categories

    if ($request->has('category_id')) {
        foreach ($request->category_id as $categoryId) {
            CourseCategory::create([
                'course_id'   => $course->id,
                'category_id' => $categoryId,
            ]);
        }
    }

    return redirect()->route('admin.courses.index');
}


    // public function show(Course $course)
    // {
    //     abort_if(Gate::denies('course_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    //     $course->load('category');

    //     return view('admin.courses.show', compact('course'));
    // }

    public function show(Course $course)
{
    abort_if(Gate::denies('course_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    $course->load('category');

    // Temporary - see if category is loading

    return view('admin.courses.show', compact('course'));
}

    public function destroy(Course $course)
    {
        abort_if(Gate::denies('course_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $course->delete();

        return back();
    }

    public function massDestroy(MassDestroyCourseRequest $request)
    {
        $courses = Course::find(request('ids'));

        foreach ($courses as $course) {
            $course->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCategoryManagementRequest;
use App\Http\Requests\StoreCategoryManagementRequest;
use App\Http\Requests\UpdateCategoryManagementRequest;
use App\Models\CategoryManagement;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CategoryManagementController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    // public function index(Request $request)
    // {
    //     abort_if(Gate::denies('category_management_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    //     if ($request->ajax()) {
    //         $query = CategoryManagement::query()->select(sprintf('%s.*', (new CategoryManagement)->table));
    //         $table = Datatables::of($query);

    //         $table->addColumn('placeholder', '&nbsp;');
    //         $table->addColumn('actions', '&nbsp;');

    //         $table->editColumn('actions', function ($row) {
    //             $viewGate      = 'category_management_show';
    //             $editGate      = 'category_management_edit';
    //             $deleteGate    = 'category_management_delete';
    //             $crudRoutePart = 'category-managements';

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
    //         $table->editColumn('name', function ($row) {
    //             return $row->name ? $row->name : '';
    //         });
    //         $table->editColumn('status', function ($row) {
    //             return $row->status ? CategoryManagement::STATUS_SELECT[$row->status] : '';
    //         });

    //         $table->rawColumns(['actions', 'placeholder']);

    //         return $table->make(true);
    //     }

    //     return view('admin.categoryManagements.index');
    // }


    public function index(Request $request)
{
    abort_if(Gate::denies('category_management_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    if ($request->ajax()) {
        $query = CategoryManagement::query()
            ->select(sprintf('%s.*', (new CategoryManagement)->table))
            ->orderByDesc('id'); // Ensure latest first

        // Get total records count for reverse index calculation
        $total = $query->count();

        $table = Datatables::of($query)
            ->addColumn('id', function ($row) use (&$total) {
                return $total--; // This will count down like S.No
            });

        $table->addColumn('placeholder', '&nbsp;');
        $table->addColumn('actions', '&nbsp;');

        $table->editColumn('actions', function ($row) {
            $viewGate      = 'category_management_show';
            $editGate      = 'category_management_edit';
            $deleteGate    = 'category_management_delete';
            $crudRoutePart = 'category-managements';

            return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
        });

        $table->editColumn('name', fn($row) => $row->name ?? '');
        $table->editColumn('status', fn($row) => $row->status ? CategoryManagement::STATUS_SELECT[$row->status] : '');

        $table->rawColumns(['actions', 'placeholder']);

        return $table->make(true);
    }

    return view('admin.categoryManagements.index');
}



    public function create()
    {
        abort_if(Gate::denies('category_management_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.categoryManagements.create');
    }

    public function store(StoreCategoryManagementRequest $request)
    {
        $categoryManagement = CategoryManagement::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $categoryManagement->id]);
        }

        return redirect()->route('admin.category-managements.index');
    }

    public function edit(CategoryManagement $categoryManagement)
    {
        abort_if(Gate::denies('category_management_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.categoryManagements.edit', compact('categoryManagement'));
    }

    public function update(UpdateCategoryManagementRequest $request, CategoryManagement $categoryManagement)
    {
        $categoryManagement->update($request->all());

        return redirect()->route('admin.category-managements.index');
    }

    public function show(CategoryManagement $categoryManagement)
    {
        abort_if(Gate::denies('category_management_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.categoryManagements.show', compact('categoryManagement'));
    }

    public function destroy(CategoryManagement $categoryManagement)
    {
        abort_if(Gate::denies('category_management_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categoryManagement->delete();

        return back();
    }

    public function massDestroy(MassDestroyCategoryManagementRequest $request)
    {
        $categoryManagements = CategoryManagement::find(request('ids'));

        foreach ($categoryManagements as $categoryManagement) {
            $categoryManagement->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('category_management_create') && Gate::denies('category_management_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new CategoryManagement();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}

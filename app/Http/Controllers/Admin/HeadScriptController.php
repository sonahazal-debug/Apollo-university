<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyHeadScriptRequest;
use App\Http\Requests\StoreHeadScriptRequest;
use App\Http\Requests\UpdateHeadScriptRequest;
use App\Models\HeadScript;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class HeadScriptController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('head_script_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = HeadScript::query()->select(sprintf('%s.*', (new HeadScript)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'head_script_show';
                $editGate      = 'head_script_edit';
                $deleteGate    = 'head_script_delete';
                $crudRoutePart = 'head-scripts';

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
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('script', function ($row) {
                return $row->script ? $row->script : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.headScripts.index');
    }

    public function create()
    {
        abort_if(Gate::denies('head_script_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.headScripts.create');
    }

    public function store(StoreHeadScriptRequest $request)
    {
        $headScript = HeadScript::create($request->all());

        return redirect()->route('admin.head-scripts.index');
    }

    public function edit(HeadScript $headScript)
    {
        abort_if(Gate::denies('head_script_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.headScripts.edit', compact('headScript'));
    }

    public function update(UpdateHeadScriptRequest $request, HeadScript $headScript)
    {
        $headScript->update($request->all());

        return redirect()->route('admin.head-scripts.index');
    }

    public function show(HeadScript $headScript)
    {
        abort_if(Gate::denies('head_script_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.headScripts.show', compact('headScript'));
    }

    public function destroy(HeadScript $headScript)
    {
        abort_if(Gate::denies('head_script_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $headScript->delete();

        return back();
    }

    public function massDestroy(MassDestroyHeadScriptRequest $request)
    {
        $headScripts = HeadScript::find(request('ids'));

        foreach ($headScripts as $headScript) {
            $headScript->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

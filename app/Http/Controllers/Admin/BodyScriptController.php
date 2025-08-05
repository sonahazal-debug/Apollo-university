<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyBodyScriptRequest;
use App\Http\Requests\StoreBodyScriptRequest;
use App\Http\Requests\UpdateBodyScriptRequest;
use App\Models\BodyScript;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class BodyScriptController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('body_script_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = BodyScript::query()->select(sprintf('%s.*', (new BodyScript)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'body_script_show';
                $editGate      = 'body_script_edit';
                $deleteGate    = 'body_script_delete';
                $crudRoutePart = 'body-scripts';

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

        return view('admin.bodyScripts.index');
    }

    public function create()
    {
        abort_if(Gate::denies('body_script_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.bodyScripts.create');
    }

    public function store(StoreBodyScriptRequest $request)
    {
        $bodyScript = BodyScript::create($request->all());

        return redirect()->route('admin.body-scripts.index');
    }

    public function edit(BodyScript $bodyScript)
    {
        abort_if(Gate::denies('body_script_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.bodyScripts.edit', compact('bodyScript'));
    }

    public function update(UpdateBodyScriptRequest $request, BodyScript $bodyScript)
    {
        $bodyScript->update($request->all());

        return redirect()->route('admin.body-scripts.index');
    }

    public function show(BodyScript $bodyScript)
    {
        abort_if(Gate::denies('body_script_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.bodyScripts.show', compact('bodyScript'));
    }

    public function destroy(BodyScript $bodyScript)
    {
        abort_if(Gate::denies('body_script_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bodyScript->delete();

        return back();
    }

    public function massDestroy(MassDestroyBodyScriptRequest $request)
    {
        $bodyScripts = BodyScript::find(request('ids'));

        foreach ($bodyScripts as $bodyScript) {
            $bodyScript->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

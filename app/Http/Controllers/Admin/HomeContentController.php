<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyHomeContentRequest;
use App\Http\Requests\StoreHomeContentRequest;
use App\Http\Requests\UpdateHomeContentRequest;
use App\Models\HomeContent;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class HomeContentController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('home_content_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = HomeContent::query()->select(sprintf('%s.*', (new HomeContent)->table));
            $total = $query->count(); // total rows

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->addColumn('sno', function () use (&$total) {
                return $total--;
            });

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'home_content_show';
                $editGate      = 'home_content_edit';
                $deleteGate    = 'home_content_delete';
                $crudRoutePart = 'home-contents';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('image', function ($row) {
                return $row->image ? $row->image : '';
            });

            $table->editColumn('content', function ($row) {
                return $row->content ? $row->content : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }


        return view('admin.homeContents.index');
    }

    public function create()
    {
        abort_if(Gate::denies('home_content_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.homeContents.create');
    }

    public function store(StoreHomeContentRequest $request)
    {
        $homeContent = HomeContent::create($request->all());

        // if ($request->hasFile('video')) {
        //     $homeContent = $request->file('video');
        //     $videoName = time() . '.' . $video->getClientOriginalExtension();
        //     $video->move(public_path('uploads/videos'), $videoName);

        //     // Save the video path to DB if needed:
        //         $homeContent->video = 'uploads/videos/' . $videoName;
        //         $homeContent->save();
        // }


        return redirect()->route('admin.home-contents.index');
    }

    public function edit(HomeContent $homeContent)
    {
        abort_if(Gate::denies('home_content_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.homeContents.edit', compact('homeContent'));
    }


    public function update(UpdateHomeContentRequest $request, HomeContent $homeContent)
{
    // Handle video upload if a new video is provided
    if ($request->hasFile('video')) {
        // Delete old video if exists
        if ($homeContent->video && file_exists(public_path($homeContent->video))) {
            unlink(public_path($homeContent->video));
        }

        // Store new video
        $video = $request->file('video');
        $videoName = time() . '.' . $video->getClientOriginalExtension();
        $video->move(public_path('uploads/videos'), $videoName);
        $homeContent->video = 'uploads/videos/' . $videoName;
    }

    // Update other fields
    $homeContent->fill($request->except('video'))->save();

    return redirect()->route('admin.home-contents.index')->with('success', 'Home content updated successfully!');
}


    public function show(HomeContent $homeContent)
    {
        abort_if(Gate::denies('home_content_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.homeContents.show', compact('homeContent'));
    }

    public function destroy(HomeContent $homeContent)
    {
        abort_if(Gate::denies('home_content_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $homeContent->delete();

        return back();
    }

    public function massDestroy(MassDestroyHomeContentRequest $request)
    {
        $homeContents = HomeContent::find(request('ids'));

        foreach ($homeContents as $homeContent) {
            $homeContent->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

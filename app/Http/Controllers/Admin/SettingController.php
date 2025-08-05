<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroySettingRequest;
use App\Http\Requests\StoreSettingRequest;
use App\Http\Requests\UpdateSettingRequest;
use App\Models\Setting;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SettingController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('setting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Setting::query()->select(sprintf('%s.*', (new Setting)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'setting_show';
                $editGate = 'setting_edit';
                $deleteGate = 'setting_delete';
                $crudRoutePart = 'settings';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('logo', function ($row) {
                return $row->logo ? '<img width="100px" src="'.asset('storage/'.trim($row->logo, '/')).'">' : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'logo']);

            return $table->make(true);
        }

        return view('admin.settings.index');
    }

    public function create()
    {
        abort_if(Gate::denies('setting_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.settings.create');
    }

    public function store(StoreSettingRequest $request)
    {
        $setting = Setting::create($request->all());

        if ($request->hasFile('logo')) {
            $imgPath = $request->file('logo')->store('uploads/', 'public');
            $setting->logo = $imgPath;
        }

        if ($request->hasFile('footer_logo')) {
            $imgPath = $request->file('footer_logo')->store('uploads/', 'public');
            $setting->footer_logo = $imgPath;
        }

        if ($request->hasFile('breadcrumb_image')) {
            $imgPath = $request->file('breadcrumb_image')->store('uploads/', 'public');
            $setting->breadcrumb_image = $imgPath;
        }

        $setting->save();

        return redirect()->route('admin.settings.index');
    }

    public function edit(Setting $setting)
    {
        abort_if(Gate::denies('setting_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.settings.edit', compact('setting'));
    }

    public function update(UpdateSettingRequest $request, Setting $setting)
    {
        //dd($request);
        $setting->update($request->all());

        if ($request->hasFile('logo')) {
            if ($setting->logo && Storage::disk('public')->exists($setting->logo)) {
                Storage::disk('public')->delete($setting->logo);
            }
            $imgPath = $request->file('logo')->store('uploads/', 'public');
            $setting->logo = $imgPath;
        }

        // if ($request->hasFile('footer_logo')) {
        //     if ($setting->footer_logo && Storage::disk('public')->exists($setting->footer_logo)) {
        //         Storage::disk('public')->delete($setting->footer_logo);
        //     }
        //     $imgPath = $request->file('footer_logo')->store('uploads/', 'public');
        //     $setting->footer_logo = $imgPath;
        // }

        if ($request->hasFile('breadcrumb_image')) {
            if ($setting->breadcrumb_image && Storage::disk('public')->exists($setting->breadcrumb_image)) {
                Storage::disk('public')->delete($setting->breadcrumb_image);
            }
            $imgPath = $request->file('breadcrumb_image')->store('uploads/', 'public');
            $setting->breadcrumb_image = $imgPath;
        }

        $setting->save();

        return redirect()->route('admin.settings.index');
    }

    public function show(Setting $setting)
    {
        abort_if(Gate::denies('setting_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.settings.show', compact('setting'));
    }

    public function destroy(Setting $setting)
    {
        abort_if(Gate::denies('setting_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($setting->logo && Storage::disk('public')->exists($setting->logo)) {
            Storage::disk('public')->delete($setting->logo);
        }

        if ($setting->footer_logo && Storage::disk('public')->exists($setting->footer_logo)) {
            Storage::disk('public')->delete($setting->footer_logo);
        }

        if ($setting->breadcrumb_image && Storage::disk('public')->exists($setting->breadcrumb_image)) {
            Storage::disk('public')->delete($setting->breadcrumb_image);
        }

        $setting->delete();

        return back();
    }

    public function massDestroy(MassDestroySettingRequest $request)
    {
        $settings = Setting::whereIn('id', request('ids'))->get();

        foreach ($settings as $setting) {
            if ($setting->logo && Storage::disk('public')->exists($setting->logo)) {
                Storage::disk('public')->delete($setting->logo);
            }
            if ($setting->footer_logo && Storage::disk('public')->exists($setting->footer_logo)) {
                Storage::disk('public')->delete($setting->footer_logo);
            }
            if ($setting->breadcrumb_image && Storage::disk('public')->exists($setting->breadcrumb_image)) {
                Storage::disk('public')->delete($setting->breadcrumb_image);
            }
            $setting->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
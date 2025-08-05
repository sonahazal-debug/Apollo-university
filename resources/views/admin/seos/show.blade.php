@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.seo.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.seos.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.seo.fields.id') }}
                        </th>
                        <td>
                            {{ $seo->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.seo.fields.title') }}
                        </th>
                        <td>
                            {{ $seo->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.seo.fields.description') }}
                        </th>
                        <td>
                            {!! $seo->description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.seo.fields.keywords') }}
                        </th>
                        <td>
                            {{ $seo->keywords }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.seos.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
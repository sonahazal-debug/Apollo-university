@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.categoryManagement.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.category-managements.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.categoryManagement.fields.id') }}
                        </th>
                        <td>
                            {{ $categoryManagement->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.categoryManagement.fields.name') }}
                        </th>
                        <td>
                            {{ $categoryManagement->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.categoryManagement.fields.description') }}
                        </th>
                        <td>
                            {!! $categoryManagement->description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.categoryManagement.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\CategoryManagement::STATUS_SELECT[$categoryManagement->status] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.category-managements.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
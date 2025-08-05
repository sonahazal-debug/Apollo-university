@extends('layouts.admin')
@section('content')
@can('course_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success mb-2" href="{{ route('admin.courses.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.course.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.course.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Course">
            <thead>
                <tr>
                    <th width="10"></th>
                    <th>{{ __('S.No') }}</th> {{-- ✅ Changed from ID to S.No --}}
                    <th>{{ trans('cruds.course.fields.course_name') }}</th>
                    <th>{{ __('Image') }}</th>
                    <th>{{ trans('cruds.course.fields.status') }}</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script>
$(function () {
    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

    @can('course_delete')
    let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
    let deleteButton = {
        text: deleteButtonTrans,
        url: "{{ route('admin.courses.massDestroy') }}",
        className: 'btn-danger',
        action: function (e, dt, node, config) {
            let ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
                return entry.id
            });

            if (ids.length === 0) {
                alert('{{ trans('global.datatables.zero_selected') }}');
                return
            }

            if (confirm('{{ trans('global.areYouSure') }}')) {
                $.ajax({
                    headers: { 'x-csrf-token': _token },
                    method: 'POST',
                    url: config.url,
                    data: { ids: ids, _method: 'DELETE' }
                }).done(function () { location.reload() })
            }
        }
    }
    dtButtons.push(deleteButton)
    @endcan

    let dtOverrideGlobals = {
        buttons: dtButtons,
        processing: true,
        serverSide: true,
        retrieve: true,
        aaSorting: [],
        ajax: "{{ route('admin.courses.index') }}",
        columns: [
    { data: 'placeholder', name: 'placeholder' },
    { data: 'sno', name: 'sno', orderable: false, searchable: false }, // ✅ Reverse S.No
    { data: 'course_name', name: 'course_name' },
    { data: 'image', name: 'image' },
    { data: 'status', name: 'status' },
    { data: 'actions', name: '{{ trans('global.actions') }}' }
],

        orderCellsTop: true,
        order: [[0, 'desc']], // This keeps newest first
        pageLength: 100,
        select: {
            style: 'multi+shift',
            selector: 'td:first-child'
        }
    };

    let table = $('.datatable-Course').DataTable(dtOverrideGlobals)

    $('a[data-toggle="tab"]').on('shown.bs.tab click', function () {
        $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
    })
})
</script>
@endsection

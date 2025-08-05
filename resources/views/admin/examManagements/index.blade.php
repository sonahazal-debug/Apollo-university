@extends('layouts.admin')
@section('content')
@can('exam_management_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success mb-2" href="{{ route('admin.exam-managements.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.examManagement.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.examManagement.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped table-hover ajaxTable datatable datatable-ExamManagement">
            <thead>
                <tr>
                    <th width="10"></th>
                    <th>{{ __('S.No') }}</th>
                    <th>{{ trans('cruds.examManagement.fields.course') }}</th>
                    <th>{{ trans('Exam Id') }}</th>
                    <th>{{ trans('Cateogies') }}</th>
                    <th>{{ trans('cruds.examManagement.fields.exam_name') }}</th>
                    <th>{{ trans('cruds.examManagement.fields.start_date') }}</th>
                    <th>{{ trans('cruds.examManagement.fields.start_time') }}</th>
                    <th>{{ trans('cruds.examManagement.fields.end_time') }}</th>
                    <th>{{ trans('Exam Status ') }}</th>
                    <th>{{ trans('cruds.examManagement.fields.status') }}</th>
                    <th>Actions</th>
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
    let _token = '{{ csrf_token() }}';

    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);

    @can('exam_management_delete')
    let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
    let deleteButton = {
      text: deleteButtonTrans,
      url: "{{ route('admin.exam-managements.massDestroy') }}",
      className: 'btn-danger',
      action: function (e, dt, node, config) {
        var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id;
        });

        if (ids.length === 0) {
          alert('{{ trans('global.datatables.zero_selected') }}');
          return;
        }

        if (confirm('{{ trans('global.areYouSure') }}')) {
          $.ajax({
            headers: { 'x-csrf-token': _token },
            method: 'POST',
            url: config.url,
            data: { ids: ids, _method: 'DELETE' }
          }).done(function () {
            location.reload();
          });
        }
      }
    };
    dtButtons.push(deleteButton);
    @endcan

    let table = $('.datatable-ExamManagement').DataTable({
      processing: true,
      serverSide: true,
      retrieve: true,
      ajax: "{{ route('admin.exam-managements.index') }}",
      rowId: 'id',
      columns: [
        { data: null, defaultContent: '', orderable: false, searchable: false },
        { data: 'sno', name: 'sno' },
        { data: 'course_course_name', name: 'course.course_name' },
        { data: 'id', name: 'id' },
        { data: 'category_names', name: 'category_names', orderable: false, searchable: false },
        { data: 'exam_name', name: 'exam_name' },
        { data: 'start_date', name: 'start_date' },
        { data: 'start_time', name: 'start_time' },
        { data: 'end_time', name: 'end_time' },
        { data: 'time_status', name: 'time_status', orderable: false, searchable: false },
        { data: 'status', name: 'status' },
        {
          data: 'actions',
          name: 'actions',
          orderable: false,
          searchable: false,
          render: function (data, type, row) {
            const viewUrl = `/admin/exam-managements/${row.id}`;
            const editUrl = `/admin/exam-managements/${row.id}/edit`;
            const resultsUrl = `/admin/result-managements/${row.id}`;
            const deleteUrl = `/admin/exam-managements/${row.id}`;
            const addQuestionsUrl = `/admin/add-questions/${slugify(row.exam_name)}`;
            const keySheetUrl = `/admin/key-sheet/${row.id}/${row.course_id}`;

            return `
              <a href="${viewUrl}" class="btn btn-sm btn-secondary">View</a>
              <a href="${editUrl}" class="btn btn-sm btn-info">Edit</a>
              <a href="${resultsUrl}" class="btn btn-sm btn-warning">Results</a>
              <form action="${deleteUrl}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?');">
                  <input type="hidden" name="_token" value="${_token}">
                  <input type="hidden" name="_method" value="DELETE">
                  <button type="submit" class="btn btn-sm btn-danger">Delete</button>
              </form>
              <a href="${addQuestionsUrl}" class="btn btn-sm btn-primary">Add Questions</a>
              <a href="${keySheetUrl}" class="btn btn-sm btn-dark">Download Key PDF</a>
            `;
          }
        },
      ],
      select: {
        style: 'multi+shift',
        selector: 'td:first-child'
      },
      columnDefs: [
        {
          targets: 0,
          className: 'select-checkbox',
          orderable: false
        },
        {
          targets: -1,
          orderable: false
        }
      ],
      order: [[1, 'desc']],
      pageLength: 25,
      dom: 'lBfrtip',
      buttons: dtButtons
    });

    table.buttons().container().appendTo('.card-body .dt-buttons');

    $('a[data-toggle="tab"]').on('shown.bs.tab click', function (e) {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
    });

    // Slugify utility for URLs
    function slugify(text) {
      return text.toString().toLowerCase()
        .replace(/\s+/g, '-')
        .replace(/[^؀-ۿ\w\-]+/g, '')
        .replace(/\-\-+/g, '-')
        .replace(/^-+/, '')
        .replace(/-+$/, '');
    }
  });
</script>
@endsection

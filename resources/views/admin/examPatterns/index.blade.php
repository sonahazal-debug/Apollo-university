@extends('layouts.admin')
@section('content')
@can('exam_pattern_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success mb-2" href="{{ route('admin.exam-patterns.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.examPattern.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.examPattern.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped table-hover ajaxTable datatable datatable-ExamPattern">
            <thead>
                <tr>
                    <th width="10">
                        {{-- <input type="checkbox" id="select-all" /> --}}
                    </th>
                    <th>{{ __('S.No') }}</th>
                    <th>{{ trans('cruds.examPattern.fields.course') }}</th>
                    <th>{{ trans('Categories') }}</th>
                    <th>{{ trans('cruds.examPattern.fields.correct_mark') }}</th>
                    <th>{{ trans('cruds.examPattern.fields.negative_mark') }}</th>
                    <th>{{ trans('cruds.examPattern.fields.max_attemt_q') }}</th>
                    <th>{{ trans('Pass %') }}</th>
                    <th>{{ trans('Pass Marks') }}</th>
                    <th>{{ trans('cruds.examPattern.fields.status') }}</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($examPatterns as $examPattern)
                    <tr data-entry-id="{{ $examPattern->id }}" id="{{ $examPattern->id }}">
                        <td></td>
                        <td></td> {{-- S.No will be populated by DataTable --}}
                        <td>{{ $examPattern->course?->course_name }}</td>
                        <td>{{ $examPattern->examCategory->pluck('category.name')->filter()->implode(', ') }}</td>
                        <td>{{ $examPattern->examCategory->sum('correct_mark') }}</td>
                        <td>{{ $examPattern->examCategory->sum('negative_mark') }}</td>
                        <td>{{ $examPattern->examCategory->sum('max_attemt_q') }}</td>
                        <td>{{ $examPattern->pass_perc }}</td>
                        <td>{{ $examPattern->pass_mark }}</td>
                        <td>{{ $examPattern->status }}</td>
                        <td>
                            <a href="{{ route('admin.exam-patterns.edit', $examPattern->id) }}" class="btn btn-sm btn-primary">
                                {{ trans('global.edit') }}
                            </a>
                            <a href="{{ route('admin.exam-patterns.show', $examPattern->id) }}" class="btn btn-sm btn-warning">
                                {{ trans('global.show') }}
                            </a>
                            <form action="{{ route('admin.exam-patterns.destroy', $examPattern->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ trans('global.areYouSure') }}')">
                                    {{ trans('global.delete') }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
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

    @can('exam_pattern_delete')
    let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
    let deleteButton = {
      text: deleteButtonTrans,
      url: "{{ route('admin.exam-patterns.massDestroy') }}",
      className: 'btn-danger',
      action: function (e, dt, node, config) {
        let ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
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

    let table = $('.datatable-ExamPattern').DataTable({
      processing: true,
      serverSide: false,
      responsive: true,
      retrieve: true,
      rowId: 'id',
      select: {
        style: 'multi+shift',
        selector: 'td:first-child'
      },
      columnDefs: [
        { targets: 0, className: 'select-checkbox', orderable: false },
        { targets: -1, orderable: false }
      ],
      order: [[2, 'desc']],
      pageLength: 25,
      dom: 'lBfrtip',
      buttons: dtButtons,
      drawCallback: function (settings) {
        let api = this.api();
        let startIndex = api.page.info().start;
        api.column(1, { page: 'current' }).nodes().each(function (cell, i) {
          cell.innerHTML = startIndex + i + 1;
        });
      }
    });


     // Insert descending S.No
     table.on('draw.dt', function () {
        let pageInfo = table.page.info();
        let count = pageInfo.recordsDisplay - (pageInfo.page * pageInfo.length);
        table.column(1, { page: 'current' }).nodes().each(function (cell, i) {
            cell.innerHTML = count - i;
        });
    });
    table.buttons().container().appendTo('.card-body .dt-buttons');

    $('#select-all').on('click', function () {
      if (this.checked) {
        table.rows().select();
      } else {
        table.rows().deselect();
      }
    });

    $('a[data-toggle="tab"]').on('shown.bs.tab click', function (e) {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
    });
  });
</script>
@endsection

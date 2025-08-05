@extends('layouts.admin')
@section('content')
@can('result_management_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-">
            <h4>{{ $setting->business_name ?? 'Business Name' }}</h4>
        </div>

        <div class="col-lg-4">
            <form method="GET" action="{{ route('admin.result-managements.index') }}" class="form-inline mb-3">
                <div class="form-group">
                    <label for="exam_id" class="mr-2">Select Exam:</label>
                    <select name="exam_id" id="exam_id" class="form-control" onchange="this.form.submit()">
                        <option value="">-- All Exams --</option>
                        @foreach($exams as $id => $name)
                            <option value="{{ $id }}" {{ request('exam_id') == $id ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.resultManagement.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped table-hover ajaxTable datatable datatable-ResultManagement">
            <thead>
                <tr>
                    <th style="width: 10px;">
                        <input type="checkbox" id="select-all">
                    </th>
                    <th style="font-size:11px">S.No</th>
                    <th style="font-size:11px">{{ trans('Course') }}</th>
                    <th style="font-size:11px">{{ trans('Exam') }}</th>
                    <th style="font-size:11px">{{ trans('cruds.resultManagement.fields.student') }}</th>
                    <th style="font-size:11px">{{ trans('Student Id') }}</th>
                    <th style="font-size:11px">{{ trans('cruds.resultManagement.fields.total_questions') }}</th>
                    <th style="font-size:11px">{{ trans('cruds.resultManagement.fields.total_attempted') }}</th>
                    <th style="font-size:11px">{{ trans('Not Attempt') }}</th>
                    <th style="font-size:11px">{{ trans('cruds.resultManagement.fields.total_correct') }}</th>
                    <th style="font-size:11px">{{ trans('cruds.resultManagement.fields.total_wrong') }}</th>
                    <th style="font-size:11px">{{ trans('cruds.resultManagement.fields.score') }}</th>
                    <th style="font-size:11px">{{ trans('Percentage') }}</th>
                    <th style="font-size:11px">{{ trans('Status') }}</th>
                    <th style="font-size:11px">{{ trans('cruds.resultManagement.fields.rank') }}</th>
                    <th style="font-size:11px">{{ trans('Exam Date') }}</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @php $sno = $resultManagements->count(); @endphp
                @foreach($resultManagements as $result)
                    <tr data-entry-id="{{ $result->id }}">
                        <td>
                            <input type="checkbox" class="select-checkbox" name="ids[]" value="{{ $result->id }}">
                        </td>
                        <td style="font-size:11px">{{ $sno-- }}</td>
                        <td style="font-size:11px">{{ $result->course->course_name ?? '' }}</td>
                        <td style="font-size:11px">{{ $result->exam->exam_name ?? '' }}</td>
                        <td style="font-size:11px">{{ $result->student->name ?? '' }}</td>
                        <td style="font-size:11px">{{ $result->student_code ?? '' }}</td>
                        <td>{{ $result->total_questions }}</td>
                        <td>{{ $result->total_attempted }}</td>
                        <td>{{ $result->not_attempted }}</td>
                        <td>{{ $result->total_correct }}</td>
                        <td>{{ $result->total_wrong }}</td>
                        <td>{{ $result->score }}</td>
                        <td>{{ $result->percentage }}</td>
                        <td>{{ $result->status }}</td>
                        <td>{{ $result->rank ?? '-' }}</td>
                        <td>{{ $result->created_at ? $result->created_at->format('d M Y') : '' }}</td>
                        <td>
                            <a href="{{ route('admin.result-managements.edit', $result->id) }}" class="btn btn-sm btn-primary">
                                {{ trans('global.edit') }}
                            </a>
                            <a href="{{ route('admin.result-managements.show', $result->id) }}" class="btn btn-sm btn-warning">
                                {{ trans('global.show') }}
                            </a>
                            <form action="{{ route('admin.result-managements.destroy', $result->id) }}" method="POST" style="display: inline-block;">
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

        @can('result_management_delete')
        let deleteButton = {
            text: '{{ trans('global.datatables.delete') }}',
            className: 'btn-danger',
            action: function (e, dt, node, config) {
                let ids = $.map(dt.rows('.selected').nodes(), function (entry) {
                    return $(entry).data('entry-id');
                });

                if (ids.length === 0) {
                    alert('{{ trans('global.datatables.zero_selected') }}');
                    return;
                }

                if (confirm('{{ trans('global.areYouSure') }}')) {
                    $.ajax({
                        headers: { 'x-csrf-token': _token },
                        method: 'POST',
                        url: "{{ route('admin.result-managements.massDestroy') }}",
                        data: { ids: ids, _method: 'DELETE' }
                    }).done(function () { location.reload(); });
                }
            }
        };
        dtButtons.push(deleteButton);
        @endcan

        let table = $('.datatable-ResultManagement').DataTable({
            orderCellsTop: true,
            order: [[1, 'desc']],
            pageLength: 25,
            buttons: dtButtons,
            columnDefs: [
                { orderable: false, targets: 0 }
            ]
        });

        // Handle checkbox change
        $('.datatable-ResultManagement tbody').on('change', 'input.select-checkbox', function () {
            let $row = $(this).closest('tr');
            if (this.checked) {
                $row.addClass('selected');
            } else {
                $row.removeClass('selected');
            }
        });

        // Select all toggle
        $('#select-all').on('click', function () {
            let checked = $(this).is(':checked');
            $('input.select-checkbox').each(function () {
                this.checked = checked;
                $(this).trigger('change');
            });
        });
    });
</script>
@endsection

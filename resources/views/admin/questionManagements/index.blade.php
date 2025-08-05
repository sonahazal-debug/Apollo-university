@extends('layouts.admin')
@section('content')
@can('question_management_create')
    {{-- <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.question-managements.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.questionManagement.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'QuestionManagement', 'route' => 'admin.question-managements.parseCsvImport'])
        </div>
    </div> --}}
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.questionManagement.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="alert alert-info">
        <strong>Exam Name:</strong> {{ $exam->exam_name }}
    </div>

    
    <div class="form-group mt-3 container">
        
      <h5>total Q uploaded :  @if(isset($exam))
         ({{ \App\Models\QuestionManagement::where('exam_id', $exam->id)->count() }})
     @endif  </h5>
     </div>

     <div>
      <a href="{{ route('admin.add-questions', Str::slug($exam->exam_name, '-')) }}" class="btn btn-info">Back to add quesions</a>
     </div>

   
  
    

    <div class="card-body">
        <table class="table table-bordered table-striped table-hover ajaxTable datatable datatable-QuestionManagement">
            <thead>
                <tr>
                    <th width="10"></th>
                    <th>{{ trans('cruds.questionManagement.fields.id') }}</th>
                    <th>{{ trans('cruds.questionManagement.fields.category') }}</th>
                   
          
                    <th>{{ trans('cruds.questionManagement.fields.question') }}</th>
                    <th>{{ trans('Options') }}</th>
                    <th>{{ trans('cruds.questionManagement.fields.answer') }}</th>
              
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($questions as $question)
                    <tr data-entry-id="{{ $question->id }}">
                        <td></td>
                        <td>{{ $question->id }}</td>
                        <td>{{ $question->category ? $question->category->name : '' }}</td>
                
                        <td>{!! $question->question !!}</td>

                        <td>
                            {{ implode(', ', array_filter(array_map('strip_tags', [$question->option_1, $question->option_2, $question->option_3, $question->option_4]))) }}
                        </td>
                        
            
                     
                        <td>{{ $question->answer }}</td>
                    
                        <td>
                            <a href="{{ route('admin.question-managements.edit', $question->id) }}" class="btn btn-sm btn-primary">
                                {{ trans('global.edit') }}
                            </a>
                            <a href="{{ route('admin.question-managements.show', $question->id) }}" class="btn btn-sm btn-warning">
                                {{ trans('global.show') }}
                            </a>
                            <form action="{{ route('admin.question-managements.destroy', $question->id) }}" method="POST" style="display: inline-block;">
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

    @can('question_management_delete')
    let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
    let deleteButton = {
      text: deleteButtonTrans,
      url: "{{ route('admin.question-managements.massDestroy') }}",
      className: 'btn-danger delete-selected',
      action: function (e, dt, node, config) {
        let ids = $.map($('.select-checkbox:checked'), function (checkbox) {
          return $(checkbox).val();
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
          }).done(function () { location.reload() });
        }
      }
    };
    dtButtons.push(deleteButton);
    @endcan

    let table = $('.datatable-QuestionManagement').DataTable({
      processing: true,
      serverSide: false,
      responsive: true,
      orderCellsTop: true,
      order: [[1, 'desc']],
      pageLength: 25,
      dom: 'lBfrtip',
      buttons: dtButtons
    });

    table.buttons().container().appendTo('.card-body .dt-buttons');

    $('#select-all').on('click', function () {
      $('.select-checkbox').prop('checked', this.checked);
    });

    $('.select-checkbox').on('click', function () {
      if (!$(this).prop('checked')) {
        $('#select-all').prop('checked', false);
      }
    });

    $('a[data-toggle="tab"]').on('shown.bs.tab click', function (e) {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
    });
  });
</script>
@endsection
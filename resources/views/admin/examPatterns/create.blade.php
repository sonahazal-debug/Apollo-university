@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h3>
            {{ trans('global.create') }} {{ trans('cruds.examPattern.title_singular') }}
        </h3>
        
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.exam-patterns.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <!-- Select Course -->
                <div class="form-group col-12">
                    <label for="course_id" class="text-primary" style="font-weight:650;" >{{ trans('cruds.examPattern.fields.course') }}</label>
                    <select class="form-control select2" name="course_id" id="course_id">
                        <option value="">Select Course</option>
                        @foreach($courses as $id => $entry)
                            <option value="{{ $id }}">{{ $entry }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Dynamic Categories Section -->
                <div id="categories-container">
                    <!-- Categories and tables will be inserted here dynamically -->
                </div>

                <div class="form-group col-12">
                    <label for="pass_perc" class="text-primary" style="font-weight:650;" >Pass % </label>
                    <input class="form-control {{ $errors->has('pass_perc') ? 'is-invalid' : '' }}" type="text" name="pass_perc" id="pass_perc" value="{{ old('pass_perc', '') }}">
                    @if($errors->has('pass_perc'))
                        <div class="invalid-feedback">
                            {{ $errors->first('pass_perc') }}
                        </div>
                    @endif
                </div>

                <div class="form-group col-12">
                    <label for="pass_mark" class="text-primary" style="font-weight:650;" >Pass Marks</label>
                    <input class="form-control {{ $errors->has('pass_mark') ? 'is-invalid' : '' }}" type="text" name="pass_mark" id="pass_mark" value="{{ old('pass_mark', '') }}">
                    @if($errors->has('status'))
                        <div class="invalid-feedback">
                            {{ $errors->first('pass_mark') }}
                        </div>
                    @endif
                </div>

                <!-- Status Select Field -->
                <div class="form-group col-12">
                    <label for="status" class="text-primary" style="font-weight:650;" >Status</label>
                    <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @if($errors->has('status'))
                        <div class="invalid-feedback">
                            {{ $errors->first('status') }}
                        </div>
                    @endif
                </div>
            </div>
           
       

            
<!-- Add Cancel Button -->
        <div class="form-group">
            <button class="btn btn-danger" type="submit">
                {{ trans('global.save') }}
            </button>
            <button type="button" class="btn btn-secondary" id="cancel-button">
                Cancel
            </button>
        </div>
        </form>
    </div>
</div>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    $(document).ready(function() {
        // Store initial form state
        let initialFormState = $('form').html();

        // Fetch categories dynamically based on selected course
        $('#course_id').change(function() {
            let courseId = $(this).val();
            if (courseId) {
                $.ajax({
                    url: "{{ route('admin.get-course-categories') }}",
                    type: "GET",
                    data: { course_id: courseId },
                    success: function(response) {
    $('#categories-container').html(''); // Clear previous categories
    if (response.categories.length > 0) {
        response.categories.forEach(function(category) {
            let categoryTable = `
                <div class="container mt-4">
                    <h5>${category.name}</h5>
                    <table class="table table-bordered" data-category-id="${category.id}">
                        <thead>
                            <tr>
                              
                                <th>Pattern</th>
                                <th>Max Attempt Q.</th>
                            
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                
                                <td>
                                    <div class="pattern-box">
                                        <div class="pattern-rows">
                                            <div class="pattern-row">
                                                 <div class="row">

                                                <div class="form-group col-3">
                                                    <label for="from_${category.id}" class="text-primary" style="font-weight:650;" >From</label>
                                                    <input type="text" id="from_${category.id}" name="from[${category.id}][0]" class="form-control" placeholder="From">
                                                </div>
                                                <div class="form-group col-3">
                                                    <label for="to_${category.id}" class="text-primary" style="font-weight:650;" >To</label>
                                                    <input type="text" id="to_${category.id}" name="to[${category.id}][0]" class="form-control" placeholder="To">
                                                </div>
                                                <div class="form-group col-3">
                                                    <label for="correct_mark_${category.id}" class="text-primary" style="font-weight:650;" >Correct Mark</label>
                                                    <input type="text" id="correct_mark_${category.id}" name="correct_mark[${category.id}][0]" class="form-control" placeholder="Correct Mark">
                                                </div>
                                                <div class="form-group col-3">
                                                    <label for="negative_mark_${category.id}" class="text-primary" style="font-weight:650;" >Negative Mark</label>
                                                    <input type="text" id="negative_mark_${category.id}" name="negative_mark[${category.id}][0]" class="form-control" placeholder="Negative Mark">
                                                </div>
                                                 </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                  <div class="form-group ">
                                    <label for="max_attemt_q_${category.id}" class="text-primary" style="font-weight:650;" >Max Attempt</label>
                                    <input type="text" id="max_attemt_q_${category.id}" name="max_attemt_q[${category.id}]" class="form-control" placeholder="Max Attempt">
                                     </div>
                                </td>
                                
                            </tr>
                        </tbody>
                    </table>
                </div>
            `;
            $('#categories-container').append(categoryTable);
        });
    } else {
        $('#categories-container').html('<p>No categories found for this course.</p>');
    }
}

                });
            } else {
                $('#categories-container').html('');
            }
        });

        // Add new row when clicking "+"
      

        // Remove row when clicking "X"
   

        // Cancel button: Completely reset the form
        // Cancel button: Completely reset the form
$('#cancel-button').click(function() {
    $('form')[0].reset(); // Reset all input fields, including Course & Status
    $('#categories-container').html(''); // Remove all dynamic elements
});

    });
</script>


@endsection

{{-- 
<td>
    <label for="number_of_questions_${category.id}">Number of Questions</label>
    <input type="text" id="number_of_questions_${category.id}" name="number_of_questions[${category.id}]" class="form-control" placeholder="No. of Questions">
</td> --}}
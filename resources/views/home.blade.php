@extends('layouts.admin')
@section('content')
 <script src="https://kit.fontawesome.com/a46f18e48c.js" crossorigin="anonymous"></script>
<style>
    .d-flex,
   .info-box {
       display: flex !important
   }
      
   .info-box-icon>img {
       max-width: 100%
   }
   
   .info-box-content {
       padding: 5px 10px;
       flex: 1
   }
   
   .info-box-number {
       display: block;
       font-weight: 700
   }
   
   .info-box {
       box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
       border-radius: .25rem;
       padding: .5rem;
       min-height: 70px;
       background: #fff
   }
   
   .info-box .progress {
       background-color: rgba(0, 0, 0, .125);
       margin: 5px 0;
       height: 2px
   }
   
   .info-box .progress .progress-bar {
       background-color: #fff
   }
   
   .info-box-icon {
       border-radius: .25rem;
       display: block;
       width: 70px;
       text-align: center;
       font-size: 30px
   }
   
   .info-box-text,
   .progress-description {
       display: block;
       white-space: nowrap;
       overflow: hidden;
       text-overflow: ellipsis;
       font-size: 18px;
   }

   .count-size{
    font-size:20px;
   }   
   </style>
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Dashboard
                </div>
              <div class="card-body">
                
                <div class="row mx-2">
                    <!-- Today Orders -->
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="info-box mb-3 d-flex">
                            <span class="info-box-icon bg-primary elevation-1 " style="color: #fff">
                                <i class="fa-solid fa-user-graduate mt-3"></i>      

                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Students/Today  Registered</span>
                                <span class="info-box-number count-size" >{{ App\Models\Student::whereDate('created_at', today())->count() }}</span>

                            </div>
                        </div>
                    </div>
                
                   
                
                    <!-- Today Subscription -->
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="info-box mb-3 d-flex">
                            <span class="info-box-icon bg-success elevation-1" style="color: #fff">
                                <i class="fa-solid fa-book-open-reader mt-3"></i> 
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Students/This Month Registered</span>
                                <span class="info-box-number count-size"> 
                                    {{ App\Models\Student::whereMonth('created_at', now()->month)
                                    ->whereYear('created_at', now()->year)
                                    ->count() }}</span>

                               
                            </div>
                        </div>
                        {{-- {{ App\Models\Service::whereDate('created_at', today())->count() }} --}}
                    </div>
                
                
                    <!-- Total Subscription -->
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="info-box mb-3 d-flex">
                            <span class="info-box-icon bg-info elevation-1" style="color: #fff">
                                <i class="fa-solid fa-user-group mt-3"></i>        
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text"> Students/Total Registered</span>
                                <span class="info-box-number count-size">{{ App\Models\Student::count() }}</span>
                            </div>
                        </div>
                    </div>
                
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="info-box mb-3 d-flex">
                            <span class="info-box-icon bg-danger elevation-1" style="color: #fff">
                                
                                <i class="fa-solid fa-clipboard-question mt-3"></i>   
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Today Exams</span>
                                <span class="info-box-number count-size">{{ App\Models\ExamManagement::whereDate('created_at', today())->count() }}</span>

                            </div>
                        </div>
                    </div>
                
                   
                
                    <!-- Today Subscription -->
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="info-box mb-3 d-flex">
                            <span class="info-box-icon bg-warning elevation-1" style="color: #fff">
                                <i class="fa-solid fa-file-pen mt-3"></i>   
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">This Month Exams</span>
                                <span class="info-box-number count-size"> 
                                    {{ App\Models\ExamManagement::whereMonth('created_at', now()->month)
                                    ->whereYear('created_at', now()->year)
                                    ->count() }}</span>

                               
                            </div>
                        </div>
                        {{-- {{ App\Models\Service::whereDate('created_at', today())->count() }} --}}
                    </div>
                
                
                    <!-- Total Subscription -->
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="info-box mb-3 d-flex">
                            <span class="info-box-icon bg-dark elevation-1" style="color: #fff">
                                <i class="fa-solid fa-pen-nib mt-3"></i>         
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Exams</span>
                                <span class="info-box-number count-size">{{ App\Models\ExamManagement::count() }}</span>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="info-box mb-3 d-flex">
                            <span class="info-box-icon bg-info elevation-1" style="color: #fff">
                                <i class="fa-solid fa-pencil mt-3"></i>     
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Courses</span>
                                <span class="info-box-number count-size" >{{ App\Models\Course::count() }}</span>
                            </div>
                        </div>
                    </div>

                    
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="info-box mb-3 d-flex">
                            <span class="info-box-icon bg-danger elevation-1" style="color: #fff">
                                <i class="fa-solid fa-table-columns mt-3"></i> 
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Category/Sections</span>
                                <span class="info-box-number count-size">{{ App\Models\CategoryManagement::count() }}</span>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="info-box mb-3 d-flex">
                            <span class="info-box-icon bg-success elevation-1" style="color: #fff">
                                <i class="fa-solid fa-users mt-3"></i>        
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">No.of Staff Users</span>
                                <span class="info-box-number count-size">{{ App\Models\User::count() }}</span>
                            </div>
                        </div>
                    </div>
                   
              </div>
            </div>
        </div>
    </div>

</div>



@php
$examDatas = \App\Models\ExamManagement::orderByDesc('created_at')->paginate(10);



$latestExam = \App\Models\ExamManagement::latest()->first(); // Assuming created_at determines recent

$resultManagements = collect();

if ($latestExam) {
    // Get top 10 ranked students for the latest exam
    $resultManagements = \App\Models\ResultManagement::withTrashed()->with(['student', 'course', 'exam'])
    ->where('exam_id', $latestExam->id)
    ->orderByDesc('score')
    ->take(10)
    ->get();


    // Assign ranks with tie handling
    $sorted = $resultManagements->sortByDesc('score')->values();
    $currentRank = 1;

    foreach ($sorted as $key => $ranked) {
        if ($key > 0 && $ranked->score == $sorted[$key - 1]->score) {
            $ranked->rank = $sorted[$key - 1]->rank;
        } else {
            $ranked->rank = $currentRank;
        }
        $currentRank++;
    }

    $resultManagements = $sorted;
}

// For dropdown (optional)
$exams = \App\Models\ExamManagement::pluck('exam_name', 'id');


@endphp


    <div class="row">
        <div class="col-6">
            <div class="card">
               

                <table class="table table-bordered mb-0" style="table-layout: fixed; width: 100%;">
                    <colgroup>
                        <col style="width: 10%;">   <!-- Sl no -->
                        <col style="width: 40%;">   <!-- Exam Name -->
                        <col style="width: 25%;">   <!-- Exam Date -->
                        <col style="width: 25%;">   <!-- Status -->
                    </colgroup>
                
                    <thead>
                        <tr>
                            <th colspan="4" class="text-center fw-semibold" style="font-size: 18px;">Exams Summary</th>
                        </tr>
                        <tr>
                            <th scope="col" class="text-center">Sl no.</th>
                            <th scope="col">Exam Name</th>
                            <th scope="col" class="text-center">Exam Date</th>
                            <th scope="col" class="text-center">Exam Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($examDatas as $exm)
                            <tr>
                                <td class="text-center">{{ $loop->iteration + ($examDatas->currentPage() - 1) * $examDatas->perPage() }}</td>
                                <td>{{ $exm->exam_name }}</td>
                                <td class="text-center">{{ $exm->created_at->format('d-m-Y') }}</td>
                                <td class="text-center">{{ $exm->status }}</td>
                            </tr>
                        @endforeach
                
                        {{-- Empty rows to maintain height --}}
                        @for ($i = $examDatas->count(); $i < 10; $i++)
                            <tr>
                                <td colspan="4">&nbsp;</td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
                
        
                {{-- Pagination --}}
                <div class="p-2">
                    {{ $examDatas->links() }}
                </div>
            </div>
        </div>
        

        <div class="col-6">
            <div class="card">
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th colspan="6" class="text-center" style="font-size: 18px;">Latest Exam Result ( Top 10 )</th>
                        </tr>
                        
                        <tr>
                            <th scope="col">Sl no.</th>
                            <th scope="col">Exam Name</th>
                            <th scope="col">Exam Date</th>
                            <th scope="col">Student Name</th>
                            <th scope="col">Student Id</th>
                            <th scope="col">Rank</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($resultManagements as $result)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $result->exam->exam_name ?? '' }}</td>
                                <td>{{ $result->created_at->format('d-m-Y') ?? '' }}</td>
                                <td>{{ $result->student->name ?? '' }}</td>
                                <td>{{ $result->student_code ?? '' }}</td>
                                <td>{{ $result->rank ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-danger">No results found for the latest exam.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    
                </table>
            </div>
        </div>
        
 
   </div>
@endsection
@section('scripts')
@parent

@endsection
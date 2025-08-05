@extends('frontend.layouts.master')

@section('content')


<main class="main">

   

    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials section">

      <div class="container">

        <h3 class="snameheading mb-5">Student Name : <span class="sname text-success"> {{$student->name}}</span></h3>

        {{-- <h5>stu id : {{$student->id}}</h5> --}}

        <div class="row gy-4">

 
            @foreach($exams as $exam)

           
            <div class="col-lg-5 mt-3" data-aos="fade-up" data-aos-delay="300">
                <div class="testimonial-item">
               
                    <h3 class="mt-2"><span class="">Exam Name</span> : <span class="text-primary">{{ $exam->exam_name }}</span></h3>
                    <h4 class="mt-2"><span class="text-black">Start Date</span> : {{ $exam->start_date }}</h4>
                    <h4 class="mt-2"><span class="text-black">Start Time</span> : {{ $exam->start_time }}</h4>
                    <h4 class="mt-2"><span class="text-black">End Time</span> : {{ $exam->end_time }}</h4>
        
                    <h4 class="mt-2">
                        <span class="text-black">Status</span> : 
                        <span class="badge bg-{{ $exam->status == 'Upcoming' ? 'primary' : ($exam->status == 'Ongoing' ? 'success' : 'danger') }}">
                            {{ $exam->status }}
                        </span>
                    </h4>
        
                    {{-- Countdown Timer --}}
                    @if ($exam->status == 'Upcoming')
                        <h4 class="mt-2">
                            <span class="text-black">Exam Starts In</span> : 
                            <span id="countdown-{{ $exam->id }}"></span>
                        </h4>
                        <script>
                            function startCountdown{{ $exam->id }}() {
                                let examStartTime = new Date("{{ $exam->countdown_time }}").getTime();
                                let timer = setInterval(function() {
                                    let now = new Date().getTime();
                                    let timeLeft = examStartTime - now;
        
                                    if (timeLeft <= 0) {
                                        clearInterval(timer);
                                        document.getElementById("countdown-{{ $exam->id }}").innerHTML = `<a href="" class="btn btn-success">Start Now</a>`;
                                    } else {
                                        let days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                                        let hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                        let minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                                        let seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
                                        document.getElementById("countdown-{{ $exam->id }}").innerHTML = 
                                            days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
                                    }
                                }, 1000);
                            }
                            startCountdown{{ $exam->id }}();
                        </script>
                    @elseif ($exam->status == 'Ongoing')
                        <h4 class="mt-2"><span class="text-black">Exam is Live</span> : 

                      
                            {{-- model --}}

                                                        <!-- Button trigger modal -->
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalLong">
                                start now
                            </button>

                            <!-- Button trigger modal -->

                            
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                            
                                  <!-- Modal Header -->
                                  <div class="modal-header position-relative d-flex justify-content-between align-items-center w-100">
                                    <div class="text-start">
                                      <h5 class="modal-title mb-0 fw-semibold text-dark">{{ $exam->exam_name }}</h5>
                                    </div>
                                    <div class="position-absolute top-50 start-50 translate-middle">
                                      <h5 class="modal-title mb-0 fw-semibold text-dark">Instructions</h5>
                                    </div>
                                    <div class="text-end">
                                      <button type="button" class="close text-dark fw-semibold" data-dismiss="modal" aria-label="Close" style="opacity:1;">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                  </div>
                            
                                  <!-- Modal Body with Scroll -->
                                  <div class="modal-body fw-semibold text-dark" style="max-height: 300px; overflow-y: auto;">
                                    {!! $setting->instruct_content !!}
                                  </div>
                            
                                  <!-- Modal Footer -->
                                  <div class="modal-footer d-flex flex-column align-items-center" style="background-color: aquamarine;">
                                    <div class="form-check mb-2">
                                      <input class="form-check-input" type="checkbox" id="instructionCheckbox">
                                      <label class="form-check-label fw-semibold text-dark" for="instructionCheckbox">
                                        I have read and understood the instructions given above.
                                      </label>
                                    </div>
                                    <a href="{{ route('exam-page', ['course_id' => $exam->course_id, 'exam_name' => $exam->exam_name, 'exam_id' => $exam->id, 'student_id' => $student->id]) }}" 
                                       class="btn btn-success mt-2 fw-semibold" 
                                       id="proceedExamBtn" 
                                       style="display: none;">
                                      Start Now
                                    </a>
                                  </div>
                            
                                </div>
                              </div>
                            </div>
                            

                            {{-- model --}}



                        </h4>
                          
                    @else
                        <h4 class="mt-2"><span class="text-danger">Exam was Over</span></h4>
                    @endif
                </div>

                {{-- 
              --}}

            </div>
        @endforeach


   
       
         <!-- End testimonial item -->

        </div>

      </div>

    </section>
    <!-- /Testimonials Section -->

  </main>


  <script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkbox = document.getElementById('instructionCheckbox');
        const startButton = document.getElementById('proceedExamBtn');

        checkbox.addEventListener('change', function () {
            if (checkbox.checked) {
                startButton.style.display = 'inline-block';
            } else {
                startButton.style.display = 'none';
            }
        });
    });
</script>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


@endsection






  

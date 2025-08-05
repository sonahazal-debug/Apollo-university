<!DOCTYPE html>
<html lang="en">


    <head>
        <meta charset="utf-8">
        <title>Exam Page</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">

        <meta name="csrf-token" content="{{ csrf_token() }}">




        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Saira:wght@500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Icon Font Stylesheet -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="lib/animate/animate.min.css" rel="stylesheet">
        <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

        <!-- Customized Bootstrap Stylesheet -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Template Stylesheet -->
       <!-- Bootstrap and Your Styles -->
<link href="{{ asset('exam-assets/exam/css-exam/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('exam-assets/exam/css-exam/style-exam.css') }}" rel="stylesheet">


<style>
        .btn-outline{
        background-color:rgb(99, 129, 237);
    }

.nav-link{
    padding: 0px !important;
}
.navbar-col1{
    line-height: 1 !important;
}
.navbar-col1 p{
    font-size: 14px;
    color: white;
    /* margin-bottom: 0 !important; */
}
.navbar-col1 a{
    font-size: 24px;
    font-weight: bold;
}
.exampage-sname{
    font-size: 13px !important;
    color: white;
    font-weight:normal !important;

}
.main-logo{
    flex-direction: column;
    align-items: start;
}
.main-logo:nth-child(1){
    font-weight: bold;
}

#external-submit{
    color:white !important;
}
.footer-row{
    display: flex;
    gap:80px;
}
.btn{
    font-size: 15px;
    font-weight:bold;
}
.footer-row-div{
    height: 37px;
    width: fit-content;
    align-content: center;
    /* background-color: white; */
    color:white;
}
.question-title{
    font-size: 20px;
    font-weight: bold;
}
.btn-warning{
    background-color: #eb7027 !important;
}

</style>

    </head>

    <body>





        <!-- Navbar Start -->
        <div class="container-fluid bg-primary sticky-container">
            <div class="">
                <nav class="navbar navbar-dark navbar-expand-lg py-0 sticky-navbar">
                    <div class="row py-3 g-3">
                        <div class="col-md-4 col-12">
                            <a href="index.html" class="navbar-brand main-logo">
                                {{-- <img src="img/of2onlogo.png" alt=""> --}}
                                <p>{{$setting->business_name}}</p>
                                <p class="exampage-sname">Student Name : <span>Name</span></p>
                                <p class="exampage-sname">Student ID : <span>ID</span></p>

                            </a>
                        </div>
                        <div class="col-md-4 col-6 navbar-col1">
                            <p class="pb-0">Exam Name</p>
                            <a class="nav-item nav-link">{{$exam->exam_name}}</a>
                        </div>
                        <div class="col-md-4 col-6 navbar-col2">




                            @if ($exam->status == 'active')

                            @php
                                $startDateTime = \Carbon\Carbon::parse($exam->start_date . ' ' . $exam->start_time)->format('Y-m-d H:i:s');
                                $endDateTime = \Carbon\Carbon::parse($exam->start_date . ' ' . $exam->end_time)->format('Y-m-d H:i:s');
                            @endphp

                            <h6 class="mt-2 text-white">
                                <span>Time Remaining</span> :
                                <span id="exam-timer-{{ $exam->id }}" style="background-color:rgb(175, 201, 8);padding:5px;"></span>
                            </h6>

                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    const startTime = new Date("{{ $startDateTime }}").getTime();
                                    const endTime = new Date("{{ $endDateTime }}").getTime();
                                    const timerId = "exam-timer-{{ $exam->id }}";

                                    function updateTimer() {
                                        const now = new Date().getTime();

                                        if (now < startTime) {
                                            document.getElementById(timerId).innerText = "Exam hasn't started yet";
                                        } else if (now >= startTime && now <= endTime) {
                                            const timeLeft = endTime - now;
                                            const hours = Math.floor((timeLeft / (1000 * 60 * 60)) % 24);
                                            const minutes = Math.floor((timeLeft / (1000 * 60)) % 60);
                                            const seconds = Math.floor((timeLeft / 1000) % 60);

                                            document.getElementById(timerId).innerText =
                                                ${hours}h ${minutes}m ${seconds}s;
                                        } else {
                                            clearInterval(timerInterval);
                                            document.getElementById(timerId).innerText = "Exam Ended";

                                            // ✅ Trigger #external-submit automatically
                                            const autoClick = document.getElementById('external-submit');
                                            if (autoClick) {
                                                autoClick.click();
                                            }
                                        }
                                    }

                                    const timerInterval = setInterval(updateTimer, 1000);
                                    updateTimer();
                                });
                            </script>

                        @endif





                        </div>
                    </div>

                </nav>
            </div>
        </div>
        <!-- Navbar End -->


                        {{-- <p>course id :{{$exam->course_id}}</p>

                        <p>stu id :{{$student->id}}</p>

                        <p>exam id :{{$examNameId}}</p> --}}
<!-- -----main content----------- -->
<div class="container-fluid main-content">
    <div class="row py-3 g-4 first-main-row">
        <!-- Left Side: Buttons & Questions -->
        <div class="col-md-8 first-col">

            <form action="{{route('finish-submit')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-12 gap-2" >
                        <div class="row">
                            <div class="col-8" >
                                @foreach ($categories as $cat)
                            <a class="btn btn-danger py-2 px-4 category-filter"
                            data-category-id="{{ $cat->id }}"
                            data-category-name="{{ $cat->name }}"
                            data-max-attempt="{{ $cat->max_attemt_q }}">
                                {{ $cat->name }}
                            </a>
                        @endforeach
                        <p class="pt-2">
                            if you want save & submit answer please click save & submit for every question
                        </p>

                            </div>

                            <div class="col-4">

                                {{-- <h5>Total Q : {{$savedQ}} / {{ $totalQ->sum('max_attemt_q') }} </h5> --}}

                                <h6>Total Answered: <span id="saved-count">0</span> / {{ $totalQ->sum('max_attemt_q') }} </h6>

                                <h6 >
                                    <strong id="selected-category-name"></strong> :
                                    <span>

                                        <span id="category-saved-count">0</span> /

                                        <span id="category-question-count">0</span>

                                    </span>

                                </h6>


                            </div>
                        </div>

                        <input type="hidden" name="student_id" value="{{$student->id}}">

                        <input type="hidden" name="course_id" value="{{$exam->course_id}}">

                        <input type="hidden" name="exam_id" value="{{$exam->id }}">

                    </div>

                </div>
                <hr>
                <!-- Second Row: Question & Marks -->



                <div class="row">
                    <div class="col-12">

                      {{-- Question container remains the same --}}
                      <div id="question-container">

                        @if (!empty($questionsByCategory))
                        @php
                            $globalIndex = 1;
                        @endphp

                        @foreach ($questionsByCategory as $categoryId => $questions)
                            @php $localIndex = 1; @endphp

                            @foreach ($questions as $q)
                                <div class="question-box"
                                    data-category-id="{{ $categoryId }}"
                                    data-global-index="{{ $globalIndex }}"
                                    data-local-q="{{ $localIndex }}"
                                    style="display:none">

                                    <h6>Question: <span id="question-number">{{ $globalIndex }}</span></h6>

                                    <input type="hidden" name="question_id" value="{{ $q->id }}">

                                    <p class="question-title"><strong>Q :</strong> {{ $q->question }}</p>

                                    {{-- Options --}}
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="option_{{ $q->id }}" value="option1">
                                        <label>A) {{ $q->option_1 }}</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="option_{{ $q->id }}" value="option2">
                                        <label>B) {{ $q->option_2 }}</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="option_{{ $q->id }}" value="option3">
                                        <label>C) {{ $q->option_3 }}</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="option_{{ $q->id }}" value="option4">
                                        <label>D) {{ $q->option_4 }}</label>
                                    </div>
                                </div>

                                @php
                                    $localIndex++;
                                    $globalIndex++;
                                @endphp
                            @endforeach
                        @endforeach
                    @else
                        <p>No questions available.</p>
                    @endif



                    </div>




{{-- Dynamic question numbers container --}}
                <div id="question-numbers" class="qstns gap-2 row"></div>


                    </div>

                </div>
            </form>
            <!-- First Row: Buttons -->



        </div>

        <!-- Right Side: Score Section -->
        <div class="col-md-4 ">
            <div class="score-buttons">
                <div class="score-number-text d-flex align-items-center gap-2">
                    <p class="score btn btn-primary m-0 px-2 py-1" id="not-visited-count">0</p>
                    <p>Not Visited</p>
                </div>
                <div class="score-number-text d-flex align-items-center gap-2">
                    <p class="score btn btn-danger m-0 px-2 py-1" id="not-answered-count">0</p>
                    <p>Not Answered</p>
                </div>
                <div class="score-number-text d-flex align-items-center gap-2">
                    <p class="score btn btn-success m-0 px-2 py-1" id="answered-count">0</p>
                    <p>Answered</p>
                </div>
            </div>

            <hr>


          {{-- right question buttons --}}
          <div class="qstns gap-2 row">
            @php
                $questionIndexByCategory = [];
            @endphp

            @foreach ($questionsByCategory as $categoryId => $questions)
                @foreach ($questions as $index => $q)
                    @php
                        $localIndex = ($questionIndexByCategory[$categoryId] ?? 0) + 1;
                        $questionIndexByCategory[$categoryId] = $localIndex;

                        // Check if answered
                        $isAnswered = in_array($q->id, $savedAnswers ?? []);
                        $btnClass = $isAnswered ? 'btn-success' : 'btn-primary';
                    @endphp

                    <div class="score-number-text col-1 question-btn-wrap"
                        data-category="{{ $categoryId }}"
                        style="display: none;">
                        <button class="score btn {{ $btnClass }} question-nav"
                            data-question-id="{{ $q->id }}"
                            data-local-q="{{ $localIndex }}"
                            data-category-id="{{ $categoryId }}">
                            {{ str_pad($localIndex, 2, '0', STR_PAD_LEFT) }}
                        </button>
                    </div>
                @endforeach
            @endforeach
        </div>


             {{-- right question buttons --}}


        </div>

    </div>
</div>
<!-- -----main content----------- -->

<footer class="footer-test py-3">
    <div class="row px-3 g-3">
        <div class="col-md-8  footer-row">

                    <!-- Previous Button -->
                    <div>

                            <div class="btn btn-primary py-1 px-2 " id="prev-footer-btn"><< Previous</div>

                <!-- Save & Next Button -->
                        <div class="btn btn-success py-1 px-2 text-white" id="save-next-footer-btn">Save & Next</div>

                        <!-- Next Button -->
                        <div class="btn btn-primary py-1 px-2 " id="next-footer-btn">Next >></div>

                        {{-- <button class=".delete-item">clikc</button> --}}

                    </div>
                    <div class="footer-row-div btn bg-danger">
                        <p >jhfwuoeyfowiudkadjapwudpoqwudwpiodjwpdpoqwdwpodu</p>
                    </div>
                </div>

            <div class="col-md-4">
                <button id="external-submit" type="button" class="btn btn-warning w-100 ">Finish & Submit</button>
            </div>



    </div>
</footer>



    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="lib/twentytwenty/jquery.event.move.js"></script>
    <script src="lib/twentytwenty/jquery.twentytwenty.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Template Javascript -->
        <!-- JS -->
<script src="{{ asset('exam-assets/exam/main-exam.js') }}"></script>

<script>
    $('#external-submit').on('click', function () {
        $('#examForm').submit();
    });
</script>




<script>


    $(document).ready(function () {


        let selectedAnswers = {
        student_id: $('input[name="student_id"]').val(),
        course_id: $('input[name="course_id"]').val(),
        exam_id: $('input[name="exam_id"]').val(),
        answers: {} // question_id => { option, category_id }
    };

        let currentCategory = null;
let currentQuestionIndex = 0;



function showQuestion(index) {
    $('.question-box').removeClass('active-question').hide();

    const selector = .question-box[data-category-id="${currentCategory}"][data-local-q="${index}"];
    const questionBox = $(selector);

    questionBox.addClass('active-question').show();

    $('#question-number').text(index.toString().padStart(2, '0'));

    restoreSavedOption(questionBox);

    const questionId = questionBox.find('input[name="question_id"]').val();
    const navButton = $(.question-nav[data-question-id="${questionId}"]);

    // ✅ Clear existing classes (optional)
    navButton.removeClass('btn-primary btn-success btn-danger');

    // ✅ Check if answered
    if (selectedAnswers.answers[questionId]) {
        navButton.addClass('btn-success'); // answered
    } else {
        navButton.addClass('btn-danger'); // visited but not answered
    }

    updateQuestionSummary(); // Update after each visit
}





// Show/hide previous/next buttons depending on question count
function updatePrevNextButtons() {
    const totalQuestions = $(.question-box[data-category-id="${currentCategory}"]).length;

    $('#prev-footer-btn').toggle(currentQuestionIndex > 1);
    $('#next-footer-btn').toggle(currentQuestionIndex < totalQuestions);
}


$('.category-filter').on('click', function () {
    $('.category-filter').removeClass('btn-primary').addClass('btn-danger');
    $(this).removeClass('btn-danger').addClass('btn-primary');

    currentCategory = $(this).data('category-id');
    let categoryName = $(this).data('category-name');
    let maxAttempt = $(this).data('max-attempt');
    currentQuestionIndex = 1;

    $('.question-btn-wrap').hide();
    $(.question-btn-wrap[data-category="${currentCategory}"]).show();

    showQuestion(currentQuestionIndex);

    // ✅ Count how many answers are saved for this category
    let savedCount = Object.values(selectedAnswers.answers).filter(answer => {
        return parseInt(answer.category_id) === parseInt(currentCategory);
    }).length;

    // ✅ Count how many total questions exist for this category (from DOM)
    let totalCategoryQuestions = $(.question-btn-wrap[data-category="${currentCategory}"]).length;

    // ✅ Update the UI
    $('#selected-category-name').text(categoryName);
    $('#category-saved-count').text(savedCount);
    $('#category-total-count').text(maxAttempt);
    $('#category-question-count').text(totalCategoryQuestions);
});


// Save & Next
// Save & Next
$('#submit-form').on('submit', function (e) {
    $('#answers-json').val(JSON.stringify(selectedAnswers));
});

$('#save-next-footer-btn').on('click', function () {
    let visibleQuestionBox = $('.question-box:visible');

if (visibleQuestionBox.length === 0) {
    alert('No question is visible to submit.');
    return;
}

let questionId = visibleQuestionBox.find('input[name="question_id"]').val();
let selectedOption = visibleQuestionBox.find('input[type="radio"]:checked').val();
let categoryId = visibleQuestionBox.data('category-id');

if (!selectedOption) {
    alert('Please select an option before submitting.');
    return;
}

// ✅ Save per-question answer and its category
selectedAnswers.answers[questionId] = {
    option: selectedOption,
    category_id: categoryId
};

// Update per-question button UI
$(.question-nav[data-question-id="${questionId}"])
    .removeClass('btn-primary btn-danger btn-secondary')
    .addClass('btn-success');

// ✅ Update total saved count
let savedCount = Object.keys(selectedAnswers.answers).length;
$('#saved-count').text(savedCount);

// ✅ Update saved count per category LIVE
let savedCategoryCount = Object.values(selectedAnswers.answers).filter(answer => {
    return parseInt(answer.category_id) === parseInt(currentCategory);
}).length;
$('#category-saved-count').text(savedCategoryCount);


        console.log('✅ Current saved data:', selectedAnswers);

        // Move to next question
       // Move to next question
let nextBox = visibleQuestionBox.nextAll(.question-box[data-category-id="${currentCategory}"]).first();

if (nextBox.length > 0) {
    visibleQuestionBox.hide();
    nextBox.show();

    currentQuestionIndex++;

    let nextQuestionOrder = nextBox.data('local-q');
    $('#question-number').text(nextQuestionOrder.toString().padStart(2, '0'));
    $('#current-question-number').val(nextQuestionOrder);

    restoreSavedOption(nextBox);
} else {
    // No more questions in current category
    let currentIndex = $('.category-filter').index($(.category-filter[data-category-id="${currentCategory}"]));
    let nextCategoryButton = $('.category-filter').eq(currentIndex + 1);

    if (nextCategoryButton.length > 0) {
        // ✅ Automatically go to the next subject without asking
        nextCategoryButton.trigger('click');
    } else {
        // ✅ All categories done – optionally do something silently
        console.log('✅ All questions in all categories completed.');
        // Optionally, redirect or show a custom message in the UI
    }
}





        updateQuestionSummary();
    });





    $('#external-submit').on('click', function () {
        let dataToSend = selectedAnswers;

        // Check if answers object is empty
        if (!selectedAnswers || Object.keys(selectedAnswers.answers || {}).length === 0) {
            dataToSend = {
                student_id: selectedAnswers.student_id,
                exam_id: selectedAnswers.exam_id,
                course_id: selectedAnswers.course_id,
                answers: {
                    0: {
                        question_id: null,
                        course_id: selectedAnswers.course_id,
                        category_id: null,
                        answer: '0'
                    }
                }
            };
        }

        $.ajax({
            url: '{{ route('finish-submit') }}',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            contentType: 'application/json',
            data: JSON.stringify(dataToSend),
            success: function (response) {
                console.log(response);
                window.location.href = '/finish-page/' + selectedAnswers.student_id + '/' + selectedAnswers.course_id + '/' + selectedAnswers.exam_id;

            }
        });
    });






// ✅ Reusable function to restore previously selected option
function restoreSavedOption(questionBox) {
        let questionId = questionBox.find('input[name="question_id"]').val();
        let saved = selectedAnswers.answers[questionId];
        if (saved) {
            questionBox.find(input[type="radio"][value="${saved.option}"]).prop('checked', true);
        }
    }


// Next button
// Next Button Logic
$('#next-footer-btn').on('click', function () {
    const totalQuestions = $(.question-box[data-category-id="${currentCategory}"]).length;

    if (currentQuestionIndex < totalQuestions) {
        currentQuestionIndex++;
        showQuestion(currentQuestionIndex);
    } else {
        alert('if you want to go next question click categories');
    }
});

// Previous Button Logic
$('#prev-footer-btn').on('click', function () {
    if (currentQuestionIndex > 1) {
        currentQuestionIndex--;
        showQuestion(currentQuestionIndex);
    } else {
        alert('This is the first question.');
    }
});


$('.question-nav').on('click', function () {
    const localQ = $(this).data('local-q');
    const categoryId = $(this).data('category-id');

    currentCategory = categoryId;
    currentQuestionIndex = localQ;

    $('.category-filter').removeClass('btn-success').addClass('btn-primary');
    $(.category-filter[data-category-id="${categoryId}"]).removeClass('btn-primary').addClass('btn-success');

    $('.question-btn-wrap').hide();
    $(.question-btn-wrap[data-category="${categoryId}"]).show();

    showQuestion(currentQuestionIndex);
    updateQuestionSummary();
});


function updateQuestionSummary() {
    const total = $('.question-nav').length;
    const answered = Object.keys(selectedAnswers.answers).length;

    let visited = 0;

    $('.question-nav').each(function () {
        const $this = $(this);
        if ($this.hasClass('btn-success') || $this.hasClass('btn-danger')) {
            visited++;
        }
    });

    const notVisited = total - visited;
    const notAnswered = total - answered;

    // Update the DOM
    $('#answered-count').text(answered);
    $('#not-answered-count').text(notAnswered);
    $('#not-visited-count').text(notVisited);
}



function highlightCurrentButton() {
    $('.question-nav').removeClass('btn-outline');
    $(.question-nav[data-category-id="${currentCategory}"][data-local-q="${currentQuestionIndex}"])
        .addClass('btn-outline');
}

$('#finish-submit-btn').on('click', function (e) {
    e.preventDefault();

    // Save final answers to the hidden input
    $('#answers-json').val(JSON.stringify(selectedAnswers));

    // Submit the form
    $('#final-submit-form').submit();
});


// Trigger first category click
$('.category-filter:first').trigger('click');


    });
    </script>

@if (session('show_exam_popup'))

<script>
    // Step 1: SweetAlert Confirmation
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            title: 'Ready to Start Exam?',
            text: "Click 'Start Exam' to begin in full-screen mode.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Start Exam',
            cancelButtonText: 'Cancel',
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
        }).then((result) => {
            if (result.isConfirmed) {
                launchFullScreen(document.documentElement);
                restrictKeys();
            } else {
                window.location.href = "{{ route('test-series') }}";
            }
        });
    });

    // Step 2: Fullscreen Function
    function launchFullScreen(element) {
        if (element.requestFullscreen) {
            element.requestFullscreen();
        } else if (element.mozRequestFullScreen) {
            element.mozRequestFullScreen();
        } else if (element.webkitRequestFullscreen) {
            element.webkitRequestFullscreen();
        } else if (element.msRequestFullscreen) {
            element.msRequestFullscreen();
        }
    }

    // Step 3: Block keys like ESC, F11, Ctrl+Shift+R
    function restrictKeys() {
        document.addEventListener("keydown", function (e) {
            if (e.key === "Escape" || e.key === "F11" || (e.ctrlKey && e.shiftKey && e.key === 'R') || e.key === "F5") {
                e.preventDefault();
            }
        });

        // Optional: Disable right-click
        document.addEventListener('contextmenu', function (e) {
            e.preventDefault();
        });
    }

    // Step 4: Detect if user exits fullscreen
    document.addEventListener('fullscreenchange', function () {
    if (!document.fullscreenElement) {
        Swal.fire({
            title: "You've exited fullscreen!",
            text: "You must stay in fullscreen during the exam.",
            icon: "warning",
            confirmButtonText: "Return to Fullscreen"
        }).then(() => {
            launchFullScreen(document.documentElement);
        });
    }
});

    </script>
@endif



    </body>

</html>
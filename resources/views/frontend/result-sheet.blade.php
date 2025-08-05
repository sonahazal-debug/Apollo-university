<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>result sheet</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">

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
        <link href="{{asset('exam-assets/exam/css-exam/bootstrap.min.css')}}" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="{{asset('exam-assets/exam/css-exam//style.css')}}" rel="stylesheet">
        <link href="{{asset('exam-assets/exam/css-exam//style1.css')}}" rel="stylesheet">


        <style>
            @media print {
                button, .btn {
                    display: none !important;
                }
            }
            </style>
               <style>

                .print-btn{
                    height: fit-content;
                }
                                .main-logo {
                                    height: 60px;
                                    display: flex;
                                    object-fit: fill;
                                    justify-content: center;
                                }
                
                
                  .top-bar{
                                background-color: #007aff;
                            }
                            .top-bar .container{
                
                                display: flex;
                                align-items:center;
                                justify-content: space-between;
                            }
                            .top-bar .container div{
                                align-items: center;
                            }
                            .top-bar .container div p {
                                    color: white;
                                    font-size: 18px;
                                    padding-bottom: 0 !important;
                                    font-weight: bold;
                                    margin-bottom: 0 !important;
                                }
                            .top-bar .container div .btn{
                                color:white;
                            }
                            @media print {
                                button, .btn {
                                    display: none !important;
                                }
                            }
                            </style>
                
                
                <style>
                    @media print {
                        .top-bar {
                            display: none !important;
                        }
                    }
                </style>
                
                
                <style>
                    .text-box-container {
                    display: flex;
                    justify-content: center;
                    margin: 20px 0;
                }
                
                .text-box {
                    width: 100%;
                    /* max-width: 600px; */
                    min-height: 50px;
                    padding: 10px;
                    border: 2px solid #ccc;
                    border-radius: 8px;
                    font-size: 16px;
                    background-color: #f9f9f9;
                    outline: none;
                }
                
                .text-box:empty:before {
                    content: attr(placeholder);
                    color: #999;
                    font-style: italic;
                }
                
                </style>
                
    </head>

    <body>
       




<!-- -----main content----------- -->
<div class="top-bar p-2">
    <div class="container">
        <div>
            <p>jskfhwkehiweodjawekdjskfhwkehiweodjawekdjskfhwkehiweodjawekd</p>
        </div>
        <div>
            <div class="btn bg-danger">
                00:00:00
            </div>
        </div>
    </div>
</div>
<div class="container-fluid  mt-5">
    
    <div class="container">
        <div class="top-headings" >
          
            <div class="d-flex justify-content-between align-items-center p-3" style="width:100%;">
    
                <!-- Left Section: Student ID -->
                <div>
                    <h6 class="mb-1"><small>Student ID</small>: <span style="color: blue;">{{$studentName->student_id}}</span></h6>
                    <h6 class="mb-0">
                        <small>Student Name</small>: <span style="color: blue;">{{$studentName->name}}</span>
                    </h6>
                </div>
            
                <!-- Center Section: Business Name, Exam Name, Student Name -->
                <div class="text-center">
                    <div class="main-logo">
                        <img src="{{ asset('assets/img/of2onlogo.png') }}" alt="">
                    </div>
                    <h3 class="mb-1">{{$setting->business_name}}</h3>
                    <h4 class="mb-1">
                        <small>Exam Name</small>: <span style="color: blue;">{{$get_examName->exam_name}}</span>
                    </h4>

                </div>
                <!-- Right Section: Exam Date and Time -->
                <div class="text-end">
                    <h6 class="mb-1">
                        <small>Exam Date</small>: 
                        <span style="color: blue;">{{ \Carbon\Carbon::parse($studentName->created_at)->format('d-m-Y') }}</span>
                    </h6>
                    
                    <h6 class="mb-0">
                        <small>Exam Time</small>: 
                        <span style="color: blue;">{{ \Carbon\Carbon::parse($studentName->created_at)->format('h:i A') }}</span>
                    </h6>
                      
                </div>
            
            </div>
            
        <table>
            <thead>
                <tr>
                    <th>Total Questions</th>
                    <th>{{$totalMax_attempt_Q}}</th>

                    <th>Total Attempted</th>
                    <th>{{$totalAttemptedCount}}</th>
                </tr>
                <tr>
                    <th>Correct Answers</th>
                    <th>{{$correctAnsCount}}</th>

                    <th>Incorrect Answers</th>
                    <th>{{$inCorrectAns}}</th>
                </tr>
                <tr>
                    <th>Not Attempted</th>
                    <th>{{$notAttempted }}</th>

                </tr>
            </thead>
          
        </table>

       <div class="container">
            <div class="table-container my-5">
                <table >
                    <tbody>
                        <tr>
                            <td  rowspan="2"><h5>Score : </h5></td>
                            <td> <h6 class="scores"> Marks : <span> {{$finalCorrectScore}}</span> </h6></td>
                        </tr>
                        <tr>
                            <td><h6 class="scores"> Percentage : <span> {{$percentage}}% </span> </h6> </td>
                        </tr>
                    </tbody>
                </table>
                <table >
                    <tbody>
                        <tr>
                            <td  rowspan="2"><h5 class="result">Results : </h5></td>
                            <td> <h4 class="scores">{{$status}}</h4></td>
                        </tr>
                        <!-- <tr>
                            <td><h6 class="scores"> Percentage : <span> 65% </span> </h6> </td>
                        </tr> -->
                    </tbody>
                </table>

              
                
            </div>
            <div class="text-box-container">
                <div class="text-box" contenteditable="true" placeholder="Enter your notes here..."></div>
            </div>
            <div class="text-end my-3" >
                <div class="d-flex flex-row justify-content-center">
                    <button onclick="window.print()" class="btn btn-success me-2 print-btn">
                        <i class="fa fa-print"></i> Print
                    </button>

                    <h6><a href="{{route('home')}}" class="btn btn-primary print-btn">Home page</a></h6>
                </div>



            </div>
       </div>
  

</div>


</div>



    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>


    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="lib/twentytwenty/jquery.event.move.js"></script>
    <script src="lib/twentytwenty/jquery.twentytwenty.js"></script>

 

{{-- 
<script>
    let timeLeft = 45; // 1 minute countdown

    function updateTimer() {
        let minutes = Math.floor(timeLeft / 60);
        let seconds = timeLeft % 60;

        // Format seconds to always have two digits
        seconds = seconds < 10 ? "0" + seconds : seconds;

        // Update the button text
        document.querySelector(".top-bar .btn").innerText = `00:${seconds}`;

        if (timeLeft === 0) {
            window.location.href = "{{route('home')}}"; // Redirect to home page
        } else {
            timeLeft--;
            setTimeout(updateTimer, 1000); // Call function every second
        }
    }

    // Start the countdown when the page loads
    updateTimer();
</script> --}}


        <!-- Template Javascript -->
        <script src="main.js"></script>
    </body>

</html>
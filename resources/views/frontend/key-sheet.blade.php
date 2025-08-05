<html>
    <head>
        <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>{{$setting->business_name}}</title>
  <meta name="description" content="">
  <meta name="keywords" content="">



  <link href="{{ asset('storage/'.$setting->logo) }}" rel="icon">
  <!-- Favicons -->

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/aos/aos.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">

    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />


    <!-- Main CSS File -->
    <link href="{{asset('assets/css/main.css')}}" rel="stylesheet">

    <link href="{{asset('assets/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Company
  * Template URL: https://bootstrapmade.com/company-free-html-bootstrap-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->



    {{-- <style>
        .key-sheet{
            display:flex;
            justify-content: center;
            /* flex-direction: column; */
            align-items:center;
        }
        .main{
            gap:10px;
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items:center;
        }
        .main-key-logo{
            height: 60px;
            object-fit: fill;
        }
        .main-key-logo img{
            height:100%;
        }
        .brand-name h2{
            font-size: 32px;
            font-weight: bold !important;
        }
        .name-date{
            align-items: center;
            display: flex;
            justify-content: space-between;
        }
        .examName span{
            color: blue;
        }
        .date span{
            color: blue;
        }
        .time span{
            color: blue;
        }
        h3{
            font-size: 20px;
            font-weight: bold;
        }
        .key-heading{
            font-weight:bold;
            text-align:center;
            text-decoration: underline blue;
            /* border-bottom: 2px solid blue;
            width: fit-content; */

        }
        .qst-box{
            width: 100%;
            border: 2px solid grey;
            box-shadow: 1px 0px 21px 0px grey;
            border-radius: 20px;
            display: grid;
            gap:10px;
        }
        .options{
            display: flex;
            gap:30px;
        }
        .question h4{
            font-weight: bold;
            font-size: 22px;
        }
        .answer h5{
            font-size: 18px;
            font-weight: bold;
        }
    </style> --}}

    <style>
        {!! file_get_contents(public_path('css/pdf-style.css')) !!}
    </style>


    </head>

    <body>

        <div class="container-fluid key-sheet py-4">
            <div class="main">
                <div class="main-key-logo">
                    <img src="{{asset('storage/'.$setting->logo)}}" alt="" style="height: 60px;">


                </div>
                <div class="brand-name">

                    <h2>{{$setting->business_name}}</h2>


                </div>
            </div>


        </div>
        <div class="container">
            <div class="name-date px-3">
                <div class="examName">
                    <h3>Exam Name : <span>{{ $exam->exam_name }}</span></h3>
                </div>
                <div style="text-align: right;">
                    <div class="date">
                        <h3>Exam Date : <span>{{ $exam->start_date }}</span></h3>
                    </div>
                    <div class="time">
                        <h3>Exam Time : <span>{{ $exam->start_time }}</span></h3>
                    </div>
                </div>
            </div>


            <hr>
            <h2 class="key-heading">Key</h2>


            @foreach ($questions as $index => $question)
            <div class="container qst-box p-4 my-3">
                <div class="question">
                    <h4>Q{{ $index + 1 }}) {{ $question->question }}</h4>
                </div>
                <div class="options" style="margin-top: 10px;">
                    <span style="display: inline-block; margin-right: 30px;">a) {{ $question->option_1 }}</span>
                    <span style="display: inline-block; margin-right: 30px;">b) {{ $question->option_2 }}</span>
                    <span style="display: inline-block; margin-right: 30px;">c) {{ $question->option_3 }}</span>
                    <span style="display: inline-block; margin-right: 30px;">d) {{ $question->option_4 }}</span>
                </div>


                <div class="answer">
                    <h5>
                        @php
                            $answerMap = [
                                'option1' => 'a) ' . $question->option_1,
                                'option2' => 'b) ' . $question->option_2,
                                'option3' => 'c) ' . $question->option_3,
                                'option4' => 'd) ' . $question->option_4,
                            ];
                        @endphp
                        {{ $answerMap[$question->answer] ?? 'Not Available' }}
                    </h5>
                </div>
            </div>
            @endforeach

        </div>

    </body>
</html>

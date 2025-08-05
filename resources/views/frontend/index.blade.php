@extends('frontend.layouts.master')

@section('content')

<style>
  .was-validated .form-control:invalid,
.was-validated .form-select:invalid {
  border-color: #dc3545;
}

</style>


<main class="main">

  <!-- Scrolling Message -->

  

  @if(!session()->has('student'))
    <!-- About Section -->
    <section id="about" class="about section">

      <div class="container mt-5">

        <div class="row position-relative">

          <div class="col-lg-7 about-img"  data-aos="zoom-out" data-aos-delay="200">
            
            @if(!empty($homeContent->video))
              <video width="560" height="350" controls autoplay loop muted playsinline >
                  <source src="{{ asset($homeContent->video) }}" type="video/mp4" style="height:300px;">
                  Your browser does not support the video tag.
              </video>
          @endif

          </div>

          <div class="col-lg-7"  data-aos="fade-up" data-aos-delay="100">
            {{-- <h2 class="inner-title">Consequatur eius et magnam</h2> --}}
            <div class="our-story">
             
              <p>{!!$homeContent->content!!}</p>
            
             
            </div>
          </div>

        </div>

      </div>

    </section><!-- /About Section -->
    @endif

    @if(session()->has('student'))
    <main class="main">
    
      <!-- Blog Posts Section -->
      <section id="blog-posts" class="blog-posts section ">
          <div class="container section-title" data-aos="fade-up">
              <h2> All Courses</h2>
             
            </div>
  
            <div class="container ">
              <div class="owl-carousel coarse-carousel">
                @foreach ($coursePages as $pg)
                  <div class="coarse-item ">
                    <article class="position-relative h-100">
            
                      <div class="post-img position-relative overflow-hidden">
                        <img src="{{ asset('storage/' . $pg->image) }}" class="img-fluid" alt="">
                      </div>
            
                      <div class="post-content d-flex flex-column">
                        <h3 class="post-title">{{ $pg->course_name }}</h3>
                        <hr>
                        <a href="{{ route('test-series') }}" class="readmore stretched-link btn btn-warning p-3">
                          <span class="text-white">Write exam</span>
                          <i class="bi bi-arrow-right" style="color:white"></i>
                        </a>
                      </div>
            
                    </article>
                  </div>
                @endforeach
              </div>
            </div>
            
  
      </section><!-- /Blog Posts Section -->
  
      
  
    </main>
@endif


@if(!session()->has('student'))
      <main class="main">

       
    
        <!-- Contact Section -->
        <section id="contact" class="contact section">

            <div class="container section-title" data-aos="fade-up">
                <h2>Student Login Form</h2>
               
              </div>
    
    
          <div class="container " data-aos="fade">
    
            <div class="row gy-5 gx-lg-5">
    
              <div class="col-lg-4 ">
    
                <div class="info">
                  <h3>Get in touch</h3>
              
                  <div class="info-item d-flex">
                    <i class="bi bi-geo-alt flex-shrink-0"></i>
                    <div>
                      <h4>Location:</h4>
                      <p>{!!$setting->address!!}</p>
                    </div>
                  </div><!-- End Info Item -->
    
                  <div class="info-item d-flex">
                    <i class="bi bi-envelope flex-shrink-0"></i>
                    <div>
                      <h4>Email:</h4>
                      <p>{{$setting->email}} / <br>{{$setting->email_1}}</p>
                    </div>
                  </div><!-- End Info Item -->
    
                  <div class="info-item d-flex">
                    <i class="bi bi-phone flex-shrink-0"></i>
                    <div>
                      <h4>Call:</h4>
                      <p>{{$setting->phone}} / {{$setting->phone_1}}</p>
                    </div>
                  </div><!-- End Info Item -->

                  <div class="info-item d-flex">
                    <i class="bi bi-whatsapp flex-shrink-0"></i>
                    <div>
                      <h4>Whats App:</h4>
                      <p>{{$setting->whatsapp_link}} </p>
                    </div>
                  </div><!-- End Info Item -->


    
                </div>
    
              </div>
    
              <div class="col-lg-8">

                {{-- @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif --}}


            <form action="{{ route('StudentLogin') }}" method="POST" novalidate id="studentForm">
              @csrf
              <div class="row g-3">
            
                <!-- Name -->
                <div class="col-lg-12 ">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="name" name="name" required>
                    <label for="name">Your Name <span class="text-danger">*</span></label>
                    <div class="invalid-feedback">Please enter your name.</div>
                  </div>
                </div>
            
                <!-- Email (optional) -->
                <div class="col-lg-12 ">
                  <div class="form-floating">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Your Email">
                    <label for="email">Your Email (Optional)</label>
                    <div class="invalid-feedback">Please enter a valid email address.</div>
                  </div>
                </div>
            
                <!-- Phone -->
                <div class="col-lg-12 ">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="phone" name="phone" required pattern="\d{10}">
                    <label for="phone">Your Phone <span class="text-danger">*</span></label>
                    <div class="invalid-feedback">Please enter a valid 10-digit phone number.</div>
                  </div>
                </div>
            
                <!-- Alternate Phone (optional) -->
                <div class="col-lg-12 ">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="alternate_phone" name="alternate_phone" pattern="\d{10}">
                    <label for="alternate_phone">Alternate Phone (Optional)</label>
                    <div class="invalid-feedback">Alternate phone must be a valid 10-digit number.</div>
                  </div>
                </div>
            
                <!-- College -->
                <div class="col-lg-12 col-xl-12">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="college" name="college" required>
                    <label for="college">College Name <span class="text-danger">*</span></label>
                    <div class="invalid-feedback">Please enter your college name.</div>
                  </div>
                </div>
            
                <!-- Course -->
                <div class="col-12 col-xl-12">
                  <div class="form-floating">
                    <select class="form-select" id="course" name="course" required>
                      <option value="">-- Select Course --</option>
                      @foreach ($courses as $course)
                        <option value="{{ $course }}">{{ $course }}</option>
                      @endforeach
                    </select>
                    <label for="course">Course <span class="text-danger">*</span></label>
                    <div class="invalid-feedback">Please select a course.</div>
                  </div>
                </div>

                <input type="hidden" name="student_id" value="{{ $randomStudentId }}">
            
                <!-- Submit Button -->
                <div class="col-12">
                  <div class="d-flex flex-row justify-content-center">
                    <button type="submit" class="btn btn-primary py-3" style="width:120px;">Submit</button>
                  </div>
               
                </div>
            
              </div>
            </form>
            
              </div><!-- End Contact Form -->



            
            </div>
    
          </div>
    
        </section><!-- /Contact Section -->
    
      </main>

      @endif


  </main>


  <script>
    $(".coarse-carousel").owlCarousel({
  autoplay: true,
  smartSpeed: 1500,
  center: false,
  dots: true,
  loop: true,
  margin: 25,
  nav: false,
  responsiveClass: true,
  responsive: {
    0: {
      items: 1
    },
    576: {
      items: 1
    },
    768: {
      items: 2
    },
    992: {
      items: 2
    },
    1200: {
      items: 3
    }
  }
});

  </script>



<script>
  document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('studentForm');

    form.addEventListener('submit', function (e) {
      // Email validation: only if not empty
      const email = document.getElementById('email');
      if (email.value !== "" && !email.validity.valid) {
        email.classList.add('is-invalid');
        e.preventDefault();
        e.stopPropagation();
      } else {
        email.classList.remove('is-invalid');
      }

      // Alternate Phone validation: only if not empty
      const altPhone = document.getElementById('alternate_phone');
      if (altPhone.value !== "" && !altPhone.checkValidity()) {
        altPhone.classList.add('is-invalid');
        e.preventDefault();
        e.stopPropagation();
      } else {
        altPhone.classList.remove('is-invalid');
      }

      // General Bootstrap validation trigger
      if (!form.checkValidity()) {
        e.preventDefault();
        e.stopPropagation();
      }

      form.classList.add('was-validated');
    });
  });
</script>

    
@endsection
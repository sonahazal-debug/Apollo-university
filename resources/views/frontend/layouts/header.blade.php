<!-- HEADER -->
<header id="header" class="header d-flex align-items-center sticky-top" style="background-color: rgb(189, 231, 253); z-index: 1000;">
  <div class="container position-relative d-flex nav-content align-items-center justify-content-between">

    <!-- Logo + Business Name -->
    <div class="d-flex align-items-center">
      <a href="{{ route('home') }}" class="logo d-flex align-items-center me-3">
        <h1 class="sitename mb-0">{{ $setting->business_name }}</h1>
      </a>
      <div class="main-logo">
        <img src="{{ asset('storage/'.$setting->logo) }}" alt="" height="50">
      </div>
    </div>

    <!-- Nav -->
    <nav id="navmenu" class="navmenu">
      <ul>
        <!-- Add your menu items here -->
      </ul>
      <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
    </nav>

    <!-- Student Dropdown -->
    @if(session()->has('student'))
      @php $student = (object) session('student'); @endphp
      <div class="dropdown ms-3">
        <button class="btn btn-light border shadow-sm d-flex align-items-center dropdown-toggle" type="button" id="studentDropdown" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-person-circle fs-5 text-primary me-2"></i>
          <span class="fw-semibold text-dark">{{ $student->name }}</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end mt-2 shadow-sm" aria-labelledby="studentDropdown">
          <li><h6 class="dropdown-header">Logged in as</h6></li>
          <li class="px-3 text-muted small">{{ $student->name ?? 'No Name Provided' }}</li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <a class="dropdown-item text-danger d-flex align-items-center" href="{{ route('StudentLogout') }}">
              <i class="bi bi-box-arrow-right me-2"></i> Logout
            </a>
          </li>
        </ul>
      </div>
    @endif

  </div>
</header>

<!-- SCROLLING BANNER (Placed just below header) -->
<div class="scrolling-banner bg-primary text-white py-2">
  <div class="scrolling-text">
    <h5 class="mb-0 text-white mt-2" style="font-weight: bold;">
      {!! $setting->content !!}
    </h5>
  </div>
</div>

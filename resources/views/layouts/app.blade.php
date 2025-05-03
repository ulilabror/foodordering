<!-- filepath: resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Mie Gacor')</title>
  <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('assets/css/main.css')}}" rel="stylesheet">

</head>

<body class="index-page">
  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container position-relative d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center me-auto me-xl-0">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1 class="sitename">Mie Gacor</h1>
        <!-- <span></span> -->
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{url('/')}}" class="{{ request()->is('/') ? 'active' : '' }}">Home</a></li>
          <li><a href="{{url('about')}}" class="{{ request()->is('about') ? 'active' : '' }}">About</a></li>
          <li><a href="{{url('menu')}}" class="{{ request()->is('menu') ? 'active' : '' }}">Menu</a></li>
          <li><a href="{{asset('contact')}}" class="{{ request()->is('contact') ? 'active' : '' }}">Contact</a></li>
          <!-- <li><a href="{{url('/')}}" class="{{ request()->is('events') ? 'active' : '' }}">Events</a></li> -->
          <!-- <li><a href="#chefs" class="{{ request()->is('chefs') ? 'active' : '' }}">Chefs</a></li> -->
          <!-- <li><a href="{{url('gallery')}}" class="{{ request()->is('gallery') ? 'active' : '' }}">Gallery</a></li> -->
          <li class="dropdown"><a href="#"><span>Login</span> <i class="bi bi-people toggle-dropdown"></i></a>
            <ul>
              <li><a href="{{ url('admin') }}">Admin</a></li>
              <!-- <li class="dropdown"><a href="#"><span>Deep Dropdown</span> <i
                    class="bi bi-chevron-down toggle-dropdown"></i></a>
                <ul>
                  <li><a href="#">Deep Dropdown 1</a></li>
                  <li><a href="#">Deep Dropdown 2</a></li>
                  <li><a href="#">Deep Dropdown 3</a></li>
                  <li><a href="#">Deep Dropdown 4</a></li>
                  <li><a href="#">Deep Dropdown 5</a></li>
                </ul>
              </li> -->
              <li><a href="{{ url("customer") }}">Customer</a></li>
              <li><a href="{{ url("courier") }}">Courier</a></li>
              <!-- <li><a href="#">Dropdown 4</a></li> -->
            </ul>
          </li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <!-- <a class="btn-getstarted" href="{{url('customer')}}">Login</a> -->
      <!-- <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{url('/')}}" class="" bis_skin_checked="1">Home<br></a></li>
          <li><a href="{{url('about')}}" bis_skin_checked="1" class="">About</a></li>
          <li><a href="{{url('menu')}}" class="" bis_skin_checked="1">Menu</a></li>
          <li><a href="#events" bis_skin_checked="1">Events</a></li>
          <li><a href="#chefs" bis_skin_checked="1">Chefs</a></li>
          <li><a href="#gallery" bis_skin_checked="1" class="">Gallery</a></li>
          <li><a href="{{url('contact')}}" bis_skin_checked="1" class="">Contact</a></li>
        </ul> -->
      <!-- <i class="mobile-nav-toggle d-xl-none bi bi-list"></i> -->
      <!-- </nav> -->
    </div>
  </header>

  <main class="main">
    @yield('content')
  </main>

  <footer class="footer bg-light text-center py-4">
    <div class="container">
      <p>&copy; 2025 Mie Gacor. All Rights Reserved.</p>
    </div>
  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="{{ url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ url('assets/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ url('assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ url('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ url('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ url('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

  <!-- Main JS File -->
  <script src="{{ url('assets/js/main.js') }}"></script>

</body>

</html>
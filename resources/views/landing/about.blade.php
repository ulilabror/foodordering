@extends('layouts.app')

@section('content')
<section id="about" class="about section">
  <div class="container section-title" data-aos="fade-up">
    <h2>About Us</h2>
    <p><span>Learn More</span> <span class="description-title">About Us</span></p>
  </div>
  <div class="container">
    <div class="row gy-4">
      <div class="col-lg-7" data-aos="fade-up" data-aos-delay="100">
        <img src="{{ url('assets/img/about.jpg') }}" class="img-fluid mb-4" alt="">
        <div class="book-a-table">
          <h3>Book a Table</h3>
          <p>+1 5589 55488 55</p>
        </div>
      </div>
      <div class="col-lg-5" data-aos="fade-up" data-aos-delay="250">
        <div class="content ps-0 ps-lg-5">
          <p class="fst-italic">Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
          <ul>
            <li><i class="bi bi-check-circle-fill"></i> Ullamco laboris nisi ut aliquip ex ea commodo consequat.</li>
            <li><i class="bi bi-check-circle-fill"></i> Duis aute irure dolor in reprehenderit in voluptate velit.</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
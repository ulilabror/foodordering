@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section id="hero" class="hero section light-background">

<div class="container">
  <div class="row gy-4 justify-content-center justify-content-lg-between">
    <div class="col-lg-5 order-2 order-lg-1 d-flex flex-column justify-content-center">
      <h1 data-aos="fade-up">Nikmati makan mie<br>Dengan rasa yang khas</h1>
      <p data-aos="fade-up" data-aos-delay="100">Kami menyediakan berbagai jenis mie dengan cita rasa yang lezat dan bervariasi. Kami berkomitmen untuk memberikan pengalaman kuliner terbaik bagi Anda dan keluarga.</p>
      </p>
      <div class="d-flex" data-aos="fade-up" data-aos-delay="200">
        <a href="{{url('menu')}}" class="btn-get-started">Lihat Daftar Menu</a>
        <a href="https://www.youtube.com/embed/bXiTimdrWWE?si=P4mdtMxHfpvj1aNE"
          class="glightbox btn-watch-video d-flex align-items-center"><i class="bi bi-play-circle"></i><span>Watch
            Video</span></a>
      </div>
    </div>
    <div class="col-lg-5 order-1 order-lg-2 hero-img" data-aos="zoom-out">
      <img src="{{ url('assets/img/hero-img.png') }}" class="img-fluid animated" alt="">
    </div>
  </div>
</div>

</section><!-- /Hero Section -->

@endsection
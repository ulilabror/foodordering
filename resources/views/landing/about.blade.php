@extends('layouts.app')

@section('content')
<section id="about" class="about section">
  <div class="container section-title" data-aos="fade-up">
    <h2>Reservasi</h2>
    <p><span>Learn More</span> <span class="description-title">About Us</span></p>
  </div>
  <div class="container">
    <div class="row gy-4">
      <div class="col-lg-7" data-aos="fade-up" data-aos-delay="100">
        <img src="{{ url('assets/img/about.jpg') }}" class="img-fluid mb-4" alt="">
        <div class="book-a-table">
          <h3>Reservasi Sekarang</h3>
          <p>0877732168347</p>
        </div>
      </div>
      <div class="col-lg-5" data-aos="fade-up" data-aos-delay="250">
        <div class="content ps-0 ps-lg-5">
          <p class="fst-italic">Kami menyediakan fasilitas ruangan yang nyaman dan modern untuk memenuhi kebutuhan Anda...</p>
          <ul>
            <li><i class="bi bi-check-circle-fill"></i> Ruangan ber-AC untuk kenyamanan maksimal.</li>
            <li><i class="bi bi-check-circle-fill"></i> Meja dan kursi yang ergonomis untuk pengalaman terbaik.</li>
            <li><i class="bi bi-check-circle-fill"></i> Akses Wi-Fi gratis di seluruh area.</li>
            <li><i class="bi bi-check-circle-fill"></i> Pencahayaan yang hangat dan suasana yang menyenangkan.</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
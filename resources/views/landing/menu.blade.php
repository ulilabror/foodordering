@extends('layouts.app')

@section('content')
<!-- Menu Section -->
<section id="menu" class="menu section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Our Menu</h2>
        <p><span>Check Our</span> <span class="description-title">Yummy Menu</span></p>
    </div><!-- End Section Title -->

    <div class="container">

        <ul class="nav nav-tabs d-flex justify-content-center" data-aos="fade-up" data-aos-delay="100">

            <li class="nav-item">
                <a class="nav-link active show" data-bs-toggle="tab" data-bs-target="#makanan">
                    <h4>Makanan</h4>
                </a>
            </li><!-- End tab nav item -->

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" data-bs-target="#minuman">
                    <h4>Minuman</h4>
                </a><!-- End tab nav item -->

            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" data-bs-target="#cemilan">
                    <h4>Cemilan</h4>
                </a>
            </li><!-- End tab nav item -->

            <!-- <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" data-bs-target="#menu-dinner">
                    <h4>Dinner</h4>
                </a>
            </li>End tab nav item -->

        </ul>

        <div class="tab-content" data-aos="fade-up" data-aos-delay="200">

            <div class="tab-pane fade active show" id="makanan">

                <div class="tab-header text-center">
                    <p>Menu</p>
                    <h3>makanan</h3>
                </div>

                <div class="row gy-5">

                    <div class="col-lg-4 menu-item">
                        <a href="{{ asset('assets/img/menu/menu-item-1.png') }}" class="glightbox"><img src="{{ asset('assets/img/menu/menu-item-1.png') }}"
                                class="menu-img img-fluid" alt=""></a>
                        <h4>Magnam Tiste</h4>
                        <p class="ingredients">
                            Lorem, deren, trataro, filede, nerada
                        </p>
                        <p class="price">
                            $5.95
                        </p>
                    </div><!-- Menu Item -->

                    <div class="col-lg-4 menu-item">
                        <a href="{{ asset('assets/img/menu/menu-item-2.png') }}" class="glightbox"><img src="{{ asset('assets/img/menu/menu-item-2.png') }}"
                                class="menu-img img-fluid" alt=""></a>
                        <h4>Aut Luia</h4>
                        <p class="ingredients">
                            Lorem, deren, trataro, filede, nerada
                        </p>
                        <p class="price">
                            $14.95
                        </p>
                    </div><!-- Menu Item -->

                    <div class="col-lg-4 menu-item">
                        <a href="{{ asset('assets/img/menu/menu-item-3.png') }}" class="glightbox"><img src="{{ asset('assets/img/menu/menu-item-3.png') }}"
                                class="menu-img img-fluid" alt=""></a>
                        <h4>Est Eligendi</h4>
                        <p class="ingredients">
                            Lorem, deren, trataro, filede, nerada
                        </p>
                        <p class="price">
                            $8.95
                        </p>
                    </div><!-- Menu Item -->

                    <div class="col-lg-4 menu-item">
                        <a href="{{ asset('assets/img/menu/menu-item-4.png') }}" class="glightbox"><img src="{{ asset('assets/img/menu/menu-item-4.png') }}"
                                class="menu-img img-fluid" alt=""></a>
                        <h4>Eos Luibusdam</h4>
                        <p class="ingredients">
                            Lorem, deren, trataro, filede, nerada
                        </p>
                        <p class="price">
                            $12.95
                        </p>
                    </div><!-- Menu Item -->

                    <div class="col-lg-4 menu-item">
                        <a href="{{ asset('assets/img/menu/menu-item-5.png') }}" class="glightbox"><img src="{{ asset('assets/img/menu/menu-item-5.png') }}"
                                class="menu-img img-fluid" alt=""></a>
                        <h4>Eos Luibusdam</h4>
                        <p class="ingredients">
                            Lorem, deren, trataro, filede, nerada
                        </p>
                        <p class="price">
                            $12.95
                        </p>
                    </div><!-- Menu Item -->

                    <div class="col-lg-4 menu-item">
                        <a href="{{ asset('assets/img/menu/menu-item-6.png') }}" class="glightbox"><img src="{{ asset('assets/img/menu/menu-item-6.png') }}"
                                class="menu-img img-fluid" alt=""></a>
                        <h4>Laboriosam Direva</h4>
                        <p class="ingredients">
                            Lorem, deren, trataro, filede, nerada
                        </p>
                        <p class="price">
                            $9.95
                        </p>
                    </div><!-- Menu Item -->

                </div>
            </div><!-- End Starter Menu Content -->

            <div class="tab-pane fade active show" id="minuman">

                <div class="tab-header text-center">
                    <p>Menu</p>
                    <h3>minuman</h3>
                </div>

                <div class="row gy-5">

                    <div class="col-lg-4 menu-item">
                        <a href="{{ asset('assets/img/menu/menu-item-1.png') }}" class="glightbox"><img src="{{ asset('assets/img/menu/menu-item-1.png') }}"
                                class="menu-img img-fluid" alt=""></a>
                        <h4>Magnam Tiste</h4>
                        <p class="ingredients">
                            Lorem, deren, trataro, filede, nerada
                        </p>
                        <p class="price">
                            $5.95
                        </p>
                    </div><!-- Menu Item -->

                    <div class="col-lg-4 menu-item">
                        <a href="{{ asset('assets/img/menu/menu-item-2.png') }}" class="glightbox"><img src="{{ asset('assets/img/menu/menu-item-2.png') }}"
                                class="menu-img img-fluid" alt=""></a>
                        <h4>Aut Luia</h4>
                        <p class="ingredients">
                            Lorem, deren, trataro, filede, nerada
                        </p>
                        <p class="price">
                            $14.95
                        </p>
                    </div><!-- Menu Item -->

                    <div class="col-lg-4 menu-item">
                        <a href="{{ asset('assets/img/menu/menu-item-3.png') }}" class="glightbox"><img src="{{ asset('assets/img/menu/menu-item-3.png') }}"
                                class="menu-img img-fluid" alt=""></a>
                        <h4>Est Eligendi</h4>
                        <p class="ingredients">
                            Lorem, deren, trataro, filede, nerada
                        </p>
                        <p class="price">
                            $8.95
                        </p>
                    </div><!-- Menu Item -->

                    <div class="col-lg-4 menu-item">
                        <a href="{{ asset('assets/img/menu/menu-item-4.png') }}" class="glightbox"><img src="{{ asset('assets/img/menu/menu-item-4.png') }}"
                                class="menu-img img-fluid" alt=""></a>
                        <h4>Eos Luibusdam</h4>
                        <p class="ingredients">
                            Lorem, deren, trataro, filede, nerada
                        </p>
                        <p class="price">
                            $12.95
                        </p>
                    </div><!-- Menu Item -->

                    <div class="col-lg-4 menu-item">
                        <a href="{{ asset('assets/img/menu/menu-item-5.png') }}" class="glightbox"><img src="{{ asset('assets/img/menu/menu-item-5.png') }}"
                                class="menu-img img-fluid" alt=""></a>
                        <h4>Eos Luibusdam</h4>
                        <p class="ingredients">
                            Lorem, deren, trataro, filede, nerada
                        </p>
                        <p class="price">
                            $12.95
                        </p>
                    </div><!-- Menu Item -->

                    <div class="col-lg-4 menu-item">
                        <a href="{{ asset('assets/img/menu/menu-item-6.png') }}" class="glightbox"><img src="{{ asset('assets/img/menu/menu-item-6.png') }}"
                                class="menu-img img-fluid" alt=""></a>
                        <h4>Laboriosam Direva</h4>
                        <p class="ingredients">
                            Lorem, deren, trataro, filede, nerada
                        </p>
                        <p class="price">
                            $9.95
                        </p>
                    </div><!-- Menu Item -->

                </div>
            </div><!-- End Starter Menu Content -->

            <div class="tab-pane fade active show" id="cemilan">

                <div class="tab-header text-center">
                    <p>Menu</p>
                    <h3>Cemilan</h3>
                </div>

                <div class="row gy-5">

                    <div class="col-lg-4 menu-item">
                        <a href="{{ asset('assets/img/menu/menu-item-1.png') }}" class="glightbox"><img src="{{ asset('assets/img/menu/menu-item-1.png') }}"
                                class="menu-img img-fluid" alt=""></a>
                        <h4>Magnam Tiste</h4>
                        <p class="ingredients">
                            Lorem, deren, trataro, filede, nerada
                        </p>
                        <p class="price">
                            $5.95
                        </p>
                    </div><!-- Menu Item -->

                    <div class="col-lg-4 menu-item">
                        <a href="{{ asset('assets/img/menu/menu-item-2.png') }}" class="glightbox"><img src="{{ asset('assets/img/menu/menu-item-2.png') }}"
                                class="menu-img img-fluid" alt=""></a>
                        <h4>Aut Luia</h4>
                        <p class="ingredients">
                            Lorem, deren, trataro, filede, nerada
                        </p>
                        <p class="price">
                            $14.95
                        </p>
                    </div><!-- Menu Item -->

                    <div class="col-lg-4 menu-item">
                        <a href="{{ asset('assets/img/menu/menu-item-3.png') }}" class="glightbox"><img src="{{ asset('assets/img/menu/menu-item-3.png') }}"
                                class="menu-img img-fluid" alt=""></a>
                        <h4>Est Eligendi</h4>
                        <p class="ingredients">
                            Lorem, deren, trataro, filede, nerada
                        </p>
                        <p class="price">
                            $8.95
                        </p>
                    </div><!-- Menu Item -->

                    <div class="col-lg-4 menu-item">
                        <a href="{{ asset('assets/img/menu/menu-item-4.png') }}" class="glightbox"><img src="{{ asset('assets/img/menu/menu-item-4.png') }}"
                                class="menu-img img-fluid" alt=""></a>
                        <h4>Eos Luibusdam</h4>
                        <p class="ingredients">
                            Lorem, deren, trataro, filede, nerada
                        </p>
                        <p class="price">
                            $12.95
                        </p>
                    </div><!-- Menu Item -->

                    <div class="col-lg-4 menu-item">
                        <a href="{{ asset('assets/img/menu/menu-item-5.png') }}" class="glightbox"><img src="{{ asset('assets/img/menu/menu-item-5.png') }}"
                                class="menu-img img-fluid" alt=""></a>
                        <h4>Eos Luibusdam</h4>
                        <p class="ingredients">
                            Lorem, deren, trataro, filede, nerada
                        </p>
                        <p class="price">
                            $12.95
                        </p>
                    </div><!-- Menu Item -->

                    <div class="col-lg-4 menu-item">
                        <a href="{{ asset('assets/img/menu/menu-item-6.png') }}" class="glightbox"><img src="{{ asset('assets/img/menu/menu-item-6.png') }}"
                                class="menu-img img-fluid" alt=""></a>
                        <h4>Laboriosam Direva</h4>
                        <p class="ingredients">
                            Lorem, deren, trataro, filede, nerada
                        </p>
                        <p class="price">
                            $9.95
                        </p>
                    </div><!-- Menu Item -->

                </div>
            </div><!-- End Starter Menu Content -->

            <!-- Repeat similar changes for other menu sections -->

        </div>

    </div>

</section><!-- /Menu Section -->
@endsection
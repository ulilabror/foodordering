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

        <!-- Nav Tabs -->
        <ul class="nav nav-tabs d-flex justify-content-center" data-aos="fade-up" data-aos-delay="100">
            @foreach ($categories as $index => $category)
                <li class="nav-item">
                    <a class="nav-link {{ $index === 0 ? 'active show' : '' }}" data-bs-toggle="tab" data-bs-target="#category-{{ $category->id }}">
                        <h4>{{ $category->name }}</h4>
                    </a>
                </li>
            @endforeach
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" data-aos="fade-up" data-aos-delay="200">
            @foreach ($categories as $index => $category)
                <div class="tab-pane fade {{ $index === 0 ? 'active show' : '' }}" id="category-{{ $category->id }}">
                    <div class="tab-header text-center">
                        <p>Menu</p>
                        <h3>{{ $category->name }}</h3>
                    </div>

                    <div class="row gy-5">
                        @foreach ($category->menus as $menu)
                            <div class="col-lg-4 menu-item">
                                <a href="{{ asset($menu->image_path) }}" class="glightbox">
                                    <img src="{{ Storage::url($menu->image_path) }}" class="menu-img img-fluid" alt="{{ $menu->name }}">
                                </a>
                                <h4>{{ $menu->name }}</h4>
                                <p class="ingredients">
                                    {{ $menu->description }}
                                </p>
                                <p class="price">
                                    Rp{{ number_format($menu->price, 2) }}
                                </p>
                            </div><!-- Menu Item -->
                        @endforeach
                    </div>
                </div><!-- End Tab Content -->
            @endforeach
        </div>

    </div>

</section><!-- /Menu Section -->
@endsection
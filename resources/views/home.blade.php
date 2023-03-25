@extends('layouts.user.header')

@section('container')
    <!-- Hero Section Begin -->
    <section class="hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="hero__categories">
                        <div class="hero__categories__all">
                            <i class="fa fa-bars"></i>
                            <span>
                                Semua kategori
                            </span>
                        </div>
                        <ul>
                            @foreach ($categories as $category)
                                <li><a href="/shop?category={{ $category->id }}">{{ $category->nama }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-7">                    
                    <div class="hero__item set-bg" data-setbg="/assets_user/img/hero/banner.png">
                        <div class="hero__text">
                            <span>MAKE UP</span>
                            <h2>Skin Care <br />100% Original</h2>
                            <a href="{{ route('shop') }}" class="primary-btn">SHOP NOW</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2" style="position: relative; padding-top:70px;z-index:-999">
                    <img src="/assets_user/img/hero/banner-right.png" style="vertical-align: bottom; display:flex; position:absolute" alt="">
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Brands Section Begin -->
    <section class="categories">
        <div class="container">
            <div class="row">
                <div class="categories__slider owl-carousel">
                    @foreach ($brands as $brand)
                        <div class="col-lg-3">
                            {{-- <div class="categories__item set-bg" data-setbg="{{ $brand->pic_path }}" style="width:100%; height:auto"> --}}
                            <div class="categories__item set-bg">
                                <center><img src="{{ $brand->pic_path }}" alt="" style="width: 5cm;"></center>
                                <h5><a href="/shop?brand={{ $brand->id }}">{{ $brand->nama }}</a></h5>
                            </div>
                        </div>                        
                    @endforeach                    
                </div>
            </div>
        </div>
    </section>
    <!-- Brands Section End -->

@endsection
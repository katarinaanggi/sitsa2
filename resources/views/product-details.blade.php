@extends('layouts.user.header')

@section('container')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="/assets_user/img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>{{ $product->nama }}</h2>
                        <div class="breadcrumb__option">
                            <a href="{{ route('shop') }}">Shop</a>
                            <a href="/shop?category={{ $product->category->id }}">{{ $product->category->nama }}</a>
                            <span>{{ $product->nama }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__pic">
                        <div class="product__details__pic__item">
                            <img class="product__details__pic__item--large"
                                src="{{ $product->pic_path }}" alt="{{ $product->nama }}">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__text">
                        <h3>{{ $product->nama }}</h3>
                        <div class="product__details__price">Rp{{ number_format($product->harga,0, ',' , '.') }}</div>
                        <form action="{{ route('product_detail',$product->id) }}" method="post">
                            @csrf
                            <div class="product__details__quantity">
                                <div class="quantity">
                                    <div class="pro-qty">
                                        <input type="text" name="jumlah" value="{{ old('jumlah', 1) }}">
                                    </div>
                                </div>
                            </div>
                            <button class="primary-btn" type="submit" style="border: 0ch">ADD TO CART</button>
                        </form>
                        <ul>
                            <li><b>Stok</b> <span>{{ $product->stok }}</span></li>
                            <li><b>Brand</b> <span>{{ $product->brand->nama }}</span></li>
                            <li><b>Kategori</b> <span>{{ $product->category->nama }}</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="product__details__tab">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab"
                                    aria-selected="true">Deskripsi Produk</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    <p class="text-justify">
                                        {!! $product->deskripsi !!}
                                    </p>
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Details Section End -->

    <!-- Related Product Section Begin -->
    <section class="related-product">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title related__product__title">
                        <h2>Produk Terkait</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($relateds as $related)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" data-setbg="{{ $related->pic_path }}">
                                <ul class="product__item__pic__hover">
                                    <li><a href="{{ route('add_one_to_cart',$related->id) }}"><i class="fa fa-shopping-cart"></i></a></li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6><a href="{{ route('product_detail',$related->id) }}">{{ $related->nama }}</a></h6>
                                <h5>Rp{{ number_format($related->harga,0, ',' , '.') }}</h5>
                            </div>
                        </div>
                    </div>                    
                @endforeach
            </div>
        </div>
    </section>
    <!-- Related Product Section End -->
@endsection
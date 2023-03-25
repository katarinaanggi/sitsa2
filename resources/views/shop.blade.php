@extends('layouts.user.header')

@section('container')
    <!-- Hero Section Begin -->
    <section class="hero hero-normal">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="hero__categories">
                        <div class="hero__categories__all">
                            <i class="fa fa-bars"></i>
                            <span>
                                @if (request('category'))
                                    {{ App\Models\Category::where('id',request()->get('category'))->first()->nama }}
                                @else
                                    Semua kategori
                                @endif
                            </span>
                        </div>
                        <ul>
                            @foreach ($categories as $category)
                                @if (request('search') && !request('brand'))
                                    <li><a href="/shop?category={{ $category->id }}&search={{ request('search') }}">{{ $category->nama }}</a></li>
                                @elseif (request('brand') && !request('search'))
                                    <li><a href="/shop?category={{ $category->id }}&brand={{ request('brand') }}">{{ $category->nama }}</a></li>
                                @elseif (request('brand') && request('search'))
                                    <li><a href="/shop?brand={{ request('brand') }}&category={{ $category->id }}&search={{ request('search') }}">{{ $category->nama }}</a></li>
                                @else
                                    <li><a href="/shop?category={{ $category->id }}">{{ $category->nama }}</a></li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="hero__search">
                        <div class="hero__search__form">
                            <form action="{{ route('shop') }}">
                                @if (request('category') && !request('brand'))
                                    <input type="hidden" name="category" value="{{ request('category') }}">
                                @elseif (request('brand') && !request('category'))
                                    <input type="hidden" name="brand" value="{{ request('brand') }}">
                                @elseif (request('brand') && request('category'))
                                    <input type="hidden" name="brand" value="{{ request('brand') }}">
                                    <input type="hidden" name="category" value="{{ request('category') }}">
                                @endif
                                <input type="text" class="form-control" name="search" placeholder="Cari produk..." value="{{ request('search') }}">
                                <button type="submit" class="site-btn">CARI</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="/assets_user/img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Sistem Informasi Toko Sri Ayu</h2>
                        <div class="breadcrumb__option">
                            <a href="/">Home</a>
                            <span>Shop</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    @if (!(request('category') || request('brand') || request('search')))
                        <div class="product__discount">
                            <div class="section-title product__discount__title">
                                <h2>Terbaru</h2>
                            </div>
                            <div class="row">
                                <div class="product__discount__slider owl-carousel">
                                    @foreach ($latest_products as $product)
                                        <div class="col-lg-9">
                                            <div class="product__discount__item">
                                                <div class="product__discount__item__pic set-bg" height="50" data-setbg="/uploads/products/{{ $product->gambar }}">
                                                    @auth
                                                        <ul class="product__item__pic__hover">
                                                            <li><a href="{{ route('add_one_to_cart',$product->id) }}"><i class="fa fa-shopping-cart"></i></a></li>
                                                        </ul>            
                                                    @endauth
                                                </div>
                                                <div class="product__discount__item__text">
                                                    <span>{{ $product->category->nama }}</span>
                                                    <h5><a href="{{ route('product_detail',$product->id) }}">{{ $product->nama }}</a></h5>
                                                    <div class="product__item__price">Rp{{ number_format($product->harga,0, ',' , '.') }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif  
                    @if (request('category') || request('brand') || request('search'))
                        <div class="section-title product__discount__title">
                            <h2>Produk</h2>
                        </div>
                    @endif                  
                    <div class="filter__item">
                        <div class="row">
                            <div class="col-lg-4 col-md-5">
                                {{-- @if ($products->total() != 0)
                                    <div class="filter__sort">
                                        <span>Sort by</span>
                                        <select id="sort" class="select">
                                            <option value="harga" selected><a href="{{ url()->current() }}&sortby=harga">Harga</a></option>
                                            <option value="nama"><a href="{{ url()->current() }}&sortby=nama">Nama</a></option>
                                        </select>
                                    </div>
                                @endif --}}
                            </div>                                
                            <div class="col-lg-4 col-md-4">
                                <div class="filter__found">
                                    <h6><span>{{ $products->total() }}</span> Produk ditemukan</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @foreach ($products as $product)
                            <div class="col-sm-6 col-md-4 col-lg-3">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg" data-setbg="{{ $product->pic_path }}">
                                        @auth
                                            <ul class="product__item__pic__hover">
                                                <li><a href="{{ route('add_one_to_cart',$product->id) }}"><i class="fa fa-shopping-cart"></i></a></li>
                                            </ul>  
                                        @endauth
                                    </div>
                                    <div class="product__item__text">
                                        <h6><a href="{{ route('product_detail',$product->id) }}">{{ $product->nama }}</a></h6>
                                        <h5>Rp{{ number_format($product->harga,0, ',' , '.') }}</h5>
                                    </div>
                                </div>
                            </div>                            
                        @endforeach
                    </div>
                    @if ($products->total() != 0)
                        <div class="product__pagination">
                            @if (!$products->onFirstPage())
                            <a href="{{ $products->previousPageUrl() }}"><i class="fa fa-long-arrow-left"></i></a> 
                            @endif
                            @if ($products->lastPage() != 1)
                                @for ($i = 1; $i <= $products->lastPage(); $i++)
                                    <a href="{{ $products->url($i) }}">{{ $i }}</a>                            
                                @endfor
                            @endif
                            
                            @if ($products->currentPage() != $products->lastPage())
                                <a href="{{ $products->nextPageUrl() }}"><i class="fa fa-long-arrow-right"></i></a>      
                            @endif
                        </div>                        
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- Product Section End -->

    <script type="text/javascript">
        function sortby(){
            var x = document.getElementById("sort").val();

            $.ajax({
                url:base_url+'&sortby='+x,
                type: 'GET',
            });
        }
    </script>
@endsection
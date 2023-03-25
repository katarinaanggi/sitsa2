@extends('layouts.user.header')

@section('container')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="/assets_user/img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>History</h2>
                        <div class="breadcrumb__option">
                            <a href="{{ route('home') }}">Home</a>
                            <span>History</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- History Section Begin -->
    <section class="checkout spad">
        <div class="container">
            @if(session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show mb-5" role="alert">
                    {{ session('success') }}
                    <a style="float:right; color:inherit; font-weight:bold" class="text-right" href="{{ route('cart',auth()->user()->id) }}">Lihat</a>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @elseif(session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="checkout__form">
                <h4>Riwayat Pemesanan</h4>
                @if ($orders->count())
                    @foreach ($orders as $order)
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="checkout__order">
                                    <div class="checkout__order__total">{{ $order->jumlah }} Produk 
                                        <span>
                                        <a data-bs-toggle="collapse" href="#collapseExample{{ $order->id }}" aria-expanded="false" aria-controls="collapseExample" style="position:sticky; color:#dcafac">Lihat Detail</a>
                                        </span>
                                        <div class="collapse" id="collapseExample{{ $order->id }}">
                                            <div class="card card-body" style="background-color: inherit; border:0ch">
                                            <ul>
                                                @foreach ($order->order_details as $detail)
                                                <li style="font-weight: normal">
                                                    {{ $detail->jumlah }} x <a style="color: inherit" href="{{ route('product_detail',$detail->product_id) }}">{{ $detail->product->nama }}</a> <span style="    color: #6f6f6f;">Rp{{ number_format($detail->product->harga,0, ',' , '.') }}</span>
                                                </li>
                                                    
                                                @endforeach
                                            </ul>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($order->jenis == "online")
                                        <ul>
                                            <li>ID Pemesanan <span>Order #{{ $order->id }}</span></li>
                                            <li>Tanggal Pemesanan <span>{{ $order->created_at->format('d-m-Y') }}</span></li>
                                            <li>Jenis Pemesanan <span>Online</span></li>
                                            <li>Subtotal <span>Rp{{ number_format($order->total-8000,0, ',' , '.') }}</span></li>
                                            <li>Biaya Pengiriman <span>Rp{{ number_format(8000,0, ',' , '.') }}</span></li>                                            
                                        </ul>
                                        <div class="checkout__order__subtotal">Total <span>Rp{{ number_format($order->total,0, ',' , '.') }}</span></div>
                                        <div class="checkout__order__products">Status Pemesanan <span>{{ $order->status }}</span></div>  
                                    @else
                                        <ul>
                                            <li>ID Pemesanan <span>Order #{{ $order->id }}</span></li>
                                            <li>Tanggal Pemesanan <span>{{ $order->created_at->format('d-m-Y') }}</span></li>
                                            <li>Jenis Pemesanan <span>Self Pickup</span></li>
                                            <li>Subtotal <span>Rp{{ number_format($order->total,0, ',' , '.') }}</span></li>                                         
                                        </ul>
                                        <div class="checkout__order__subtotal">Total <span>Rp{{ number_format($order->total,0, ',' , '.') }}</span></div>
                                        <div class="checkout__order__products">Status Pemesanan <span>{{ $order->status }}</span></div>                                         
                                    @endif
                                    <div class="text-right mt-4">
                                        <a class="primary-btn" href="{{ route('reorder',$order->id) }}">BELI LAGI</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4 style="border: 0ch"></h4> 
                    @endforeach
                    <div class="product__pagination">
                        @if (!$orders->onFirstPage())
                        <a href="{{ $orders->previousPageUrl() }}"><i class="fa fa-long-arrow-left"></i></a> 
                        @endif
                        @if ($orders->lastPage() != 1)
                            @for ($i = 1; $i <= $orders->lastPage(); $i++)
                                <a href="{{ $orders->url($i) }}">{{ $i }}</a>                            
                            @endfor
                        @endif
                        
                        @if ($orders->currentPage() != $orders->lastPage())
                            <a href="{{ $orders->nextPageUrl() }}"><i class="fa fa-long-arrow-right"></i></a>      
                        @endif
                    </div>
                @else
                    <p class="text-center">Anda belum memiliki riwayat pemesanan</p>
                    <div class="text-center">
                        <a href="{{ route('orders',auth()->user()->id) }}" class="primary-btn">LIHAT DAFTAR PEMESANAN</a>
                    </div>
                @endif
                
                                
            </div>
        </div>
        
    </section>
@endsection
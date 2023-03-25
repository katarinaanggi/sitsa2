@extends('layouts.user.header')

@section('container')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="/assets_user/img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Orders</h2>
                        <div class="breadcrumb__option">
                            <a href="{{ route('home') }}">Home</a>
                            <span>Orders</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Orders Section Begin -->
    <section class="checkout spad">
        <div class="container">
            <div class="checkout__form">
                <h4>Pemesanan Anda</h4>
                @if ($orders)
                    @foreach ($orders as $order)
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="checkout__order">
                                    <div class="checkout__order__total">
                                        {{ $order->jumlah }} Produk 
                                        <span>
                                        <a data-bs-toggle="collapse" href="#collapseExample{{ $order->id }}" aria-expanded="false" aria-controls="collapseExample" style="position:sticky; color:#dcafac">Lihat Detail</a>
                                        </span>
                                        <div class="collapse" id="collapseExample{{ $order->id }}">
                                            <div class="card card-body" style="background-color: inherit; border:0ch">
                                            <ul>   
                                                @foreach ($order->order_details as $detail)
                                                <li style="font-weight: normal">
                                                    {{ $detail->jumlah }} x <a style="color: inherit" href="{{ route('product_detail',$detail->product_id) }}">{{ $detail->product->nama }}</a> <span style="color: #6f6f6f">Rp{{ number_format($detail->product->harga,0, ',' , '.') }}</span>
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
                                            @if ($order->resi)
                                                <li>Nomor Resi <span>{{ $order->resi }}</span></li>
                                            @endif
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
                                    @if ($order->status == "Menunggu pembayaran")
                                    <div class="mt-4">
                                        <a type="button" style="border: 0ch; color:white; background: #bababa" class="primary-btn" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $order->id }}">BATALKAN PEMESANAN</a>
                                        <a type="button" style="border: 0ch; color:white; float:right" class="primary-btn float-right" onclick="pay({{ $order->id }})">BAYAR</a>
                                    </div>
                                    @elseif ($order->status == "Dalam pengiriman")
                                    <div class="text-right mt-4">
                                        <a type="button" class="primary-btn" style="color: white" data-bs-toggle="modal" data-bs-target="#receiveModal{{ $order->id }}">PESANAN DITERIMA</a>
                                    </div>
                                    @elseif ($order->status == "Gagal dikonfirmasi")
                                    <div class="text-danger mt-4">Bukti pembayaran gagal dikonfirmasi. Silakan unggah kembali bukti pembayaran untuk melanjutkan pemesanan.</div>
                                    <div class="mt-4">
                                        <a type="button" style="border: 0ch; color:white; background: #bababa" class="primary-btn" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $order->id }}">BATALKAN PEMESANAN</a>
                                        <a type="button" style="border: 0ch; color:white; float:right" class="primary-btn float-right" onclick="repay({{ $order->id }})">UPLOAD</a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>                        
                        
                        <!-- Cancel Order Modal -->
                        <div class="modal fade" id="deleteModal{{ $order->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="deleteModalLabel"><b> Batalkan Pemesanan</b></h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    Anda yakin ingin membatalkan pemesanan?
                                    </div>
                                    <div class="modal-footer">
                                    <a type="button" class="primary-btn" style="color:white; background: #bababa" data-bs-dismiss="modal">Tidak</a>
                                    <a href="{{ route('delete_order',$order->id) }}" type="button" class="primary-btn">Ya</a>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <h4 style="border: 0ch"></h4>      
                        
                        <!-- Checkout Modal -->
                        <div class="modal fade" id="payModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="payModalLabel"><b> Pembayaran</b></h1>
                                <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal"
                                    aria-label="Close"
                                ></button>
                                </div>
                                <div class="modal-body">
                                <div id="pay"></div>
                                </div>
                            </div>
                            </div>
                        </div>

                        <!-- Repay Modal -->
                        <div class="modal fade" id="repayModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="repayModalLabel"><b> Unggah Ulang Bukti Pembayaran</b></h1>
                                <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal"
                                    aria-label="Close"
                                ></button>
                                </div>
                                <div class="modal-body">
                                <div id="repay"></div>
                                </div>
                            </div>
                            </div>
                        </div>

                        <!-- Receive Order Modal -->
                        <div class="modal fade" id="receiveModal{{ $order->id }}" tabindex="-1" aria-labelledby="receiveModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="receiveModalLabel"><b> Konfirmasi Pemesanan</b></h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    Konfirmasi pesanan diterima?
                                    </div>
                                    <div class="modal-footer">
                                    <a type="button" class="primary-btn" style="color:white; background: #bababa" data-bs-dismiss="modal">Batal</a>
                                    <a href="{{ route('complete_order',$order->id) }}" type="button" class="primary-btn">Konfirmasi</a>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                    <p class="text-center">Tidak ada pemesanan yang sedang berlangsung</p>
                    <div class="text-center">
                        <a href="{{ route('cart',auth()->user()->id) }}}" class="primary-btn">CHECKOUT SEKARANG</a>
                    </div>
                @endif
                               
            </div>
        </div>
        
    </section>
    <!-- Checkout Section End -->

    <script>  
        function pay(id){
            $.get("{{ route('pay_order', '') }}/" + id, {}, function(data, status){
                $("#pay").html(data);
                $("#payModal").modal('show');
            });
        }
        function upload(id){
            let token = $("meta[name='csrf-token']").attr("content");
            
            let pic = $('#pic')[0].files[0];
    
            var fd = new FormData();
            fd.append('pic', pic);
            fd.append('_token', token);
            $.ajax({
                type: "post",
                url: "{{ route('confirm_pay','') }}/" + id,
                data: fd,
                contentType: false,
                processData: false,
                success:function(data){
                    //close modal 
                    $(".btn-close").click();
                    window.location.reload();

                    if(data.success == true){
                        //show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: `${data.message}`,
                            showConfirmButton: false,
                            timer: 3000
                        });                        
                    }
                    else{
                        Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: `${data.message}`,
                        showConfirmButton: true,
                        timer: 3000
                        });
                    }        
                },
                error: function(error){
                    if( error.status === 422 ){
                        var errors = $.parseJSON(error.responseText);
            
                        //hapus text error yang ada
                        $(".errorsay").text(' ');
            
                        //loop untuk mnampilkan tiap error
                        $.each(errors, function (key, val) {
                            $("#" + key + "_error").text(val[0]);
                        });
                    }
                    else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: `${error.message}`,
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                }
            });
        }
        function repay(id){
            $.get("{{ route('repay_order','') }}/" + id, {}, function(data, status){
                $("#repay").html(data);
                $("#repayModal").modal('show');
            });
        }
        function reupload(id){
            let token = $("meta[name='csrf-token']").attr("content");
            
            let pic = $('#pic')[0].files[0];
    
            var fd = new FormData();
            fd.append('pic', pic);
            fd.append('_token', token);
            $.ajax({
                type: "post",
                url: "{{ route('confirm_repay','') }}/" + id,
                data: fd,
                contentType: false,
                processData: false,
                success:function(data){
                    //close modal 
                    $(".btn-close").click();
                    window.location.reload();

                    if(data.success == true){
                        //show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: `${data.message}`,
                            showConfirmButton: false,
                            timer: 3000
                        });                        
                    }
                    else{
                        Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: `${data.message}`,
                        showConfirmButton: true,
                        timer: 3000
                        });
                    }        
                },
                error: function(error){
                    if( error.status === 422 ){
                        var errors = $.parseJSON(error.responseText);
            
                        //hapus text error yang ada
                        $(".errorsay").text(' ');
            
                        //loop untuk mnampilkan tiap error
                        $.each(errors, function (key, val) {
                            $("#" + key + "_error").text(val[0]);
                        });
                    }
                    else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: `${error.message}`,
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                }
            });
        }
    </script>
@endsection
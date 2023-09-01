@extends('layouts.user.header')

@section('container')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="/assets_user/img/breadcrumb.png">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Shopping Cart</h2>
                        <div class="breadcrumb__option">
                            <a href="{{ route('home') }}">Home</a>
                            <span>Shopping Cart</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shoping Cart Section Begin -->
    <section class="shoping-cart spad">
        @if ($details->count())
            <div class="container">
                <form action="{{ route('cart',auth()->user()->id) }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="shoping__cart__table">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="shoping__product">Produk</th>
                                            <th>Harga</th>
                                            <th>Jumlah</th>
                                            <th>Total</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($details as $detail)    
                                            @php
                                                $subtotal = $detail->product->harga*$detail->jumlah     
                                            @endphp
                                            <tr>
                                                <td class="shoping__cart__item">
                                                    <a href="{{ route('product_detail',$detail->product_id) }}"><img src="{{ $detail->product->pic_path }}" alt="" width="100">
                                                    <h5>{{ $detail->product->nama }}</h5></a>
                                                </td>
                                                <td class="shoping__cart__price">
                                                    Rp{{ number_format($detail->product->harga,0, ',' , '.') }}
                                                </td>
                                                <td class="shoping__cart__quantity">
                                                    <div class="quantity">
                                                        <input type="hidden" name="item_id" class="item_id" value="{{ $detail->id }}">
                                                        <div class="cart-pro-qty">
                                                            <span class="dec qtybtn" data-cartid="{{ $detail->id }}" data-price="{{ $detail->product->harga }}">-</span>
                                                            <input type="text" name="jumlah" value="{{ old('jumlah', $detail->jumlah) }}" oninput="updateTotal({{ $detail->id }}, value, {{ $detail->product->harga }})">
                                                            <span class="inc qtybtn" data-cartid="{{ $detail->id }}" data-price="{{ $detail->product->harga }}">+</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td id="subtotal{{ $detail->id }}" class="shoping__cart__total" data-subid="{{ $detail->id }}">
                                                    Rp{{ number_format($subtotal,0, ',' , '.') }}
                                                </td>
                                                <td class="shoping__cart__item__close">
                                                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $detail->id }}">
                                                        <span class="icon_close"></span>
                                                    </a>
                                                </td>
                                            </tr>
                                            <!-- Delete Product Modal -->
                                            <div class="modal fade" id="deleteModal{{ $detail->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="deleteModalLabel"><b> Hapus Produk</b></h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                        Anda yakin ingin menghapus produk ini dari keranjang?
                                                        </div>
                                                        <div class="modal-footer">
                                                        <a type="button" class="primary-btn" style="color:white; background: #bababa" data-bs-dismiss="modal">Tidak</a>
                                                        <a href="{{ route('delete_cart',$detail->id) }}" type="button" class="primary-btn">Ya</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>  
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="shoping__cart__btns">
                                <a href="{{ route('shop') }}" class="primary-btn cart-btn">LANJUT BERBELANJA</a>
                            </div>
                        </div>
                        <div class="col-lg-6">
                        </div>
                        <div class="col-lg-6">
                            <div class="shoping__checkout">
                                <h5>Cart Total</h5>
                                <ul>
                                    <li style="border-bottom: 0ch">
                                        Subtotal <span id="total">Rp{{ number_format($total,0, ',' , '.') }}</span>
                                    </li>
                                </ul>
                                <a type="button" onclick="checkout({{ auth()->user()->id }})" class="primary-btn" style="color: white">CHECKOUT</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        @else
            <p class="text-center">Tidak ada produk di dalam keranjang</p>
            <div class="text-center">
                <a href="{{ route('shop') }}" class="primary-btn">BELANJA SEKARANG</a>
            </div>
        @endif
    </section>
    <!-- Shoping Cart Section End -->

    <!-- Checkout Modal -->
    <div class="modal fade" id="checkoutModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="loader"></div>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Pilih Jenis Pemesanan</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    <div id="checkout"></div>
                </div>
            </div>
        </div>
    </div>

    <script>  
        function checkout(id){
            $.get("{{ route('checkout', '') }}/" + id, {}, function(data, status){
                $("#checkout").html(data);
                $("#checkoutModal").modal('show');
            });
        }
        function order(id){
            let token = $("meta[name='csrf-token']").attr("content");
            
            var jenis = $('#jenis').val();
            if(jenis == "pickup"){
                var total = $("input[id=tp]").val();
            }else{
                total = $("input[id=to]").val();
            }
            $.ajax({
                type: "post",
                url: "{{ route('order', '') }}/" + id,
                data: {
                   jenis: jenis,
                   total: total,
                   user_id: id,
                   status: 'Menunggu pembayaran', 
                    _token: token
                },
                beforeSend:function(){
                    $(".loader").fadeOut();
                    $("#preloder").delay(200).fadeOut("slow");
                },
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
                        
                    }else{
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
                            showConfirmButton: true,
                            timer: 3000
                        });
                    }
                }
            });
        };

        function updateTotal(id, jumlah, harga){
            var subtotal = toRupiah(jumlah*harga);
            $("#subtotal"+id).text(subtotal);
            if (jumlah == '0') {
                $.ajax({
                    type: "get",
                    url: "{{ route('delete_cart', '') }}/" + id,
                    success:function(data){
                        window.location.reload();
                    },
                });
            }
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "post",
                url: "{{ route('update_cart', '') }}/" + id,
                data: {
                    id: id,
                    jumlah: jumlah
                }
            });
            $.ajax({
                type: "get",
                url: "{{ route('subtotal') }}",
                success:function(data){
                    $("#total").text(toRupiah(data));
                }
            })
        };

        function toRupiah(value){
            var	number_string = (value).toString(),
            sisa 	= number_string.length % 3,
            rupiah 	= number_string.substr(0, sisa),
            ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
                
            if (ribuan) {
                var separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            return 'Rp' + rupiah;
        }
    </script>
@endsection
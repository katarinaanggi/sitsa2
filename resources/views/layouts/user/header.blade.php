<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets_user/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="/assets_user/css/sweetalert2.min.css">
    <link rel="stylesheet" href="/assets_user/css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="/assets_user/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="/assets_user/css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="/assets_user/css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="/assets_user/css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="/assets_user/css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="/assets_user/css/style.css" type="text/css">

    <!-- Icon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('/assets_user/img/icon.png') }}" />

</head>

<body>
    @include('sweetalert::alert')
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Humberger Begin -->
    <div class="humberger__menu__overlay"></div>
    <div class="humberger__menu__wrapper">
        <div class="humberger__menu__logo">
            <a href="{{ route('home') }}"><img src="/assets_user/img/logo.png" alt="" width="150"></a>
        </div>
        @auth
            <div class="humberger__menu__cart">
                <ul>
                    <li><a href="{{ route('cart',auth()->user()->id) }}"><i class="fa fa-shopping-bag"></i> <span>{{ auth()->user()->cart->cart_details->sum('jumlah') }}</span></a></li>
                </ul>
            </div>            
        @endauth
        <div class="humberger__menu__widget">
            <div class="header__top__right__auth">
                @auth
                    <div class="dropdown">
                        <a class="dropdown-toggle" href="#" style="color: black" id="dropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-user"></i>{{ auth()->user()->nama }} </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="{{ route('edit_profile',auth()->user()->id) }}"><i class="fa fa-edit"></i>Edit Profile</a></li>
                            <li><a class="dropdown-item" onclick="edit({{ auth()->user()->id }})"><i class="fa fa-key"></i>Ubah Password</a></li>
                            <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa fa-trash"></i>Hapus Akun</a></li>
                            <li><a class="dropdown-item" href="{{ route('user_logout') }}"><i class="fa fa-sign-out"></i>Logout</a></li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}"><i class="fa fa-sign-in"></i>Login</a>
                @endauth
            </div>
        </div>
        <nav class="humberger__menu__nav mobile-menu">
            <ul>
                <li class="{{ Request::is('/') ? 'active' : "" }}"><a href="{{ route('home') }}">Home</a></li>
                <li class="{{ Request::is('shop*') ? 'active' : "" }}"><a href="{{ route('shop') }}">Shop</a></li>
                @auth
                   <li class="{{ Request::is('orders*') ? 'active' : "" }}"><a href="{{ route('orders',auth()->user()->id) }}">Orders</a></li>
                    <li class="{{ Request::is('history*') ? 'active' : "" }}"><a href="{{ route('history',auth()->user()->id) }}">History</a></li> 
                @endauth
                
            </ul>
        </nav>
        <div id="mobile-menu-wrap"></div>
        <div class="humberger__menu__contact">
            <ul>
                <li>
                    <a href="mailto:sriayubeautyshop@gmail.com" style="color: initial"><i class="fa fa-envelope"></i> sriayubeautyshop@gmail.com</a>
                </li>
                <li>Selamat Datang di Sistem Informasi Toko Sri Ayu!</li>
            </ul>
        </div>
    </div>
    <!-- Humberger End -->

    <!-- Header Section Begin -->
    <header class="header">
        <div class="header__top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__left">
                            <ul>
                                <li>
                                   <a href="mailto:sriayubeautyshop@gmail.com" style="color: initial"><i class="fa fa-envelope"></i> sriayubeautyshop@gmail.com</a>
                                </li>
                                <li>Selamat Datang di Sistem Informasi Toko Sri Ayu!</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__right">
                            <div class="header__top__right__auth">
                                @auth
                                    <div class="dropdown" style="position: relative; z-index: 10000 !important;">
                                        <a id="dropdown" class="dropdown-toggle" href="#" style="color: black" id="dropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-user"></i>{{ auth()->user()->nama }} </a>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <li><a class="dropdown-item" href="{{ route('edit_profile',auth()->user()->id) }}"><i class="fa fa-edit"></i>Edit Profil</a></li>
                                            <li><a class="dropdown-item" onclick="edit({{ auth()->user()->id }})"><i class="fa fa-key"></i>Ubah Password</a></li>
                                            <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa fa-trash"></i>Hapus Akun</a></li>
                                            <li><a class="dropdown-item" href="{{ route('user_logout') }}"><i class="fa fa-sign-out"></i>Logout</a></li>
                                        </ul>
                                    </div>
                                @else
                                    <a href="{{ route('login') }}"><i class="fa fa-sign-in"></i>Login</a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container" style="background-color: white">
            <div class="row">
                <div class="col-lg-3">
                    <div class="header__logo">
                        <a style="color: #cda09b; font-weight:bolder; font-size:30px" href="{{ route('home') }}"><img src="/assets_user/img/icon.png" alt="" width="35">&nbsp; SITSA</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <nav class="header__menu">
                        <ul>
                            <li class="{{ Request::is('/') ? 'active' : "" }}"><a href="{{ route('home') }}">Home</a></li>
                            <li class="{{ Request::is('shop*') ? 'active' : "" }}"><a href="{{ route('shop') }}">Shop</a></li>
                            @auth
                               <li class="{{ Request::is('orders*') ? 'active' : "" }}"><a href="{{ route('orders',auth()->user()->id) }}">Orders</a></li>
                               <li class="{{ Request::is('history*') ? 'active' : "" }}"><a href="{{ route('history',auth()->user()->id) }}">History</a></li>
                            @endauth                            
                        </ul>
                    </nav>
                </div>
                @auth
                    <div id="cart" class="col-lg-1">
                        <div class="header__cart">
                            <ul>
                                <li><a href="{{ route('cart',auth()->user()->id) }}"><i class="fa fa-shopping-bag"></i> <span>{{ auth()->user()->cart->cart_details->sum('jumlah') }}</span></a></li>
                            </ul>
                        </div>
                    </div>
                @endauth
            </div>
            <div class="humberger__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
    <!-- Header Section End -->

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel1">Ubah Password</h5>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div class="modal-body">
              <div id="page"></div>
            </div>
          </div>
        </div>
    </div>

    @auth
    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteModalLabel"><b> Anda yakin ingin menghapus akun ini?</b></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                Semua data terkait akun ini akan terhapus
                </div>
                <div class="modal-footer">
                <a type="button" class="primary-btn" style="color:white; background: #bababa" data-bs-dismiss="modal">Tidak</a>
                <a href="{{ route('delete_user', auth()->user()->id) }}" type="button" class="primary-btn">Ya</a>
                </div>
            </div>
        </div>
    </div>         
    @endauth

    @yield('container')

    <!-- Footer Section Begin -->
    <footer class="footer spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="footer__about">
                        <div class="footer__about__logo">
                            <a href="{{ route('home') }}"><img src="/assets_user/img/logo.png" alt="" width="200"></a>
                        </div>                        
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="footer__widget" style="padding-top: 30px">
                        <ul>
                            <li>Address : Johar Tengah Blok 1, No. 81, Semarang</li>
                            <li>Email : sriayubeautyshop@gmail.com</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="footer__copyright">
                        <div class="footer__copyright__text">
                            <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                            &copy;<script>document.write(new Date().getFullYear());</script> Crafted with with <i class="fa fa-heart" aria-hidden="true"></i> by Levina Marsya V. S.
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                        </div>
                        <div class="footer__copyright__payment"><img src="/assets_user/img/qris_logo.png" alt="" width="70"></div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="/assets_user/js/jquery-3.3.1.min.js"></script>
    <script src="/assets_user/js/sweetalert2.all.min.js"></script>
    <script src="/assets_user/js/bootstrap.min.js"></script>
    <script src="/assets_user/js/jquery.nice-select.min.js"></script>
    <script src="/assets_user/js/jquery-ui.min.js"></script>
    <script src="/assets_user/js/jquery.slicknav.js"></script>
    <script src="/assets_user/js/mixitup.min.js"></script>
    <script src="/assets_user/js/owl.carousel.min.js"></script>
    <script src="/assets_user/js/main.js"></script>
    
    @auth        
    <script>
        // Edit Password
        function edit(id){
            $.get("{{ route('edit_password', '') }}/" + id, {}, function(data, status){
                $("#page").html(data);
                $("#editModal").modal('show');
            });
        }
        
        // Update Password
        function update(id){
            let token   = $("meta[name='csrf-token']").attr("content");

            var current_password = $("input[id=current_password]").val();
            var new_password = $("input[id=new_password]").val();
            var new_confirm_password = $("input[id=new_confirm_password]").val();
            $.ajax({
                type: "post",
                url: "{{ route('update_password', '') }}/" + id,
                // contentType: false,
                // processData: false,
                datatype: 'json',
                data: {
                    current_password:  current_password,
                    new_password: new_password,
                    new_confirm_password: new_confirm_password,
                    _token: token
                },
                success:function(data){
                    //close modal 
                    $(".btn-close").click();
                    window.location.reload();
        
                    //show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: `${data.message}`,
                        showConfirmButton: false,
                        timer: 3000
                    });
                },
                error: function(error){
                    if( error.status === 422 ){
                        var errors = $.parseJSON(error.responseText);
            
                        //hapus text error yang ada
                        $(".errorsay").text(' ');
            
                        //loop untuk menampilkan tiap error
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
        }

        // $(function(){
        //     // var d = document.getElementById("dropdown").getAttribute('aria-expanded');
        //     var d = document.getElementById("dropdown");
        //     // var d = console.log($(this).find('a[aria-expanded]').attr('aria-expanded'));
        //     if(d.ariaExpanded = "true"){
        //         document.getElementById("cart").style.zIndex = "-1";
        //     }
        //     else{
        //         document.getElementById("cart").style.zIndex = "0";
        //     }
        // })
    </script>

    
    @endauth

</body>

</html>
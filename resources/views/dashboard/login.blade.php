<!DOCTYPE html>
<html
  lang="en"
  class="light-style customizer-hide"
  dir="ltr"
>
  <head>
    <meta charset="utf-8" />
    <meta
    name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Admin Login</title>
    
    <meta name="description" content="" />
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('/assets_user/img/icon.png') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet"
    />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Quicksand&family=Poppins&display=swap" rel="stylesheet">

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('assets_admin/vendor/fonts/boxicons.css') }}" />
    
    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets_admin/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets_admin/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets_admin/css/demo.css') }}" />
    
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets_admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    
    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets_admin/vendor/css/pages/page-auth.css') }}" />
    <!-- Helpers -->
    <script src="{{ asset('assets_admin/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets_admin/js/config.js') }}"></script>
  </head>
  
  <body>
    @include('sweetalert::alert')
    <!-- Content -->

    @php
        if(isset($_COOKIE['login_email']) && isset($_COOKIE['login_password'])) {
          $email = $_COOKIE['login_email'];
          $password = $_COOKIE['login_password'];
        }
        else {
          $email = '';
          $password = '';
        }
    @endphp

    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Register -->
          <div class="card">
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center">
                <a href="{{ route('home') }}" class="app-brand-link gap-2">
                  <span class="app-brand-logo demo">
                    <img src="{{ asset('/assets_user/img/icon.png') }}" width="30">
                  </span>
                  <span class="app-brand-text demo text-body fw-bolder">SITSA</span>
                </a>
              </div>
              <!-- /Logo -->
              <h4 class="mb-2">Selamat Datang di SITSA! 👋</h4>
              <p class="mb-4">Tolong sign-in ke akun anda</p>

              <form id="formAuthentication" class="mb-3" action="{{ route('admin.check') }}" method="POST" autocomplete="off">
                {{-- @if (Session::get('error'))
                  <div class="alert alert-danger">
                    {{ Session::get('error') }}
                  </div>                    
                @endif --}}
                @csrf
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input
                    type="text"
                    class="form-control"
                    id="email"
                    name="email"
                    placeholder="Enter your email"
                    value="{{ $email }}"
                    autofocus
                  />
                  <span class="text-danger">@error('email') {{ $message }}@enderror</span>
                </div>
                <div class="mb-3 form-password-toggle">
                  <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">Password</label>
                    <a href="{{ route('admin.forgot_password') }}">
                      <small>Forgot Password?</small>
                    </a>
                  </div>
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="password"
                      class="form-control"
                      name="password"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      aria-describedby="password"
                      value="{{ $password }}"
                    />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                  <span class="text-danger">@error('password') {{ $message }}@enderror</span>
                </div>
                <div class="mb-3">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember_me" name="remember_me" value="remember_me"/>
                    <label class="form-check-label" for="remember_me"> Remember Me </label>
                  </div>
                </div>
                <div class="mb-3">
                  {!! NoCaptcha::renderJs() !!}
                  {!! NoCaptcha::display() !!}
                  <span class="text-danger">@error('g-recaptcha-response') {{ $message }}@enderror</span>
                </div>
                <div class="mb-3">
                  <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                </div>
              </form>

              <p class="text-center">
                <span>New?</span>
                <a href="{{ route('admin.register') }}">
                  <span>Create an account</span>
                </a>
              </p>
            </div>
          </div>
          <!-- /Register -->
        </div>
      </div>
    </div>

    <!-- Core JS -->
    <!-- build:js assets_admin/vendor/js/core.js -->
    <script src="{{ asset('assets_admin/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets_admin/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets_admin/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets_admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('assets_admin/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="{{ asset('assets_admin/js/main.js') }}"></script>

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>

<!DOCTYPE html>
<html
  lang="en"
  class="light-style customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{ asset('assets_admin/') }}"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>{{ $title }}</title>

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
    <link 
      href="https://fonts.googleapis.com/css2?family=Montserrat&family=Quicksand&family=Poppins&display=swap" 
      rel="stylesheet"
    />

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
    <!-- Content -->

    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Register Card -->
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
              <h4 class="mb-2">Form Registrasi 🚀</h4>
              <p class="mb-4">Registrasi untuk mengakses SITSA</p>

              <form id="formAuthentication" class="mb-3" action="{{ route('register') }}" method="POST">
                @if (Session::get('success'))
                  <div class="alert alert-success">
                    {{ Session::get('success') }}
                  </div>                    
                @endif
                @if (Session::get('error'))
                  <div class="alert alert-danger">
                    {{ Session::get('error') }}
                  </div>                    
                @endif
                @csrf
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input
                    type="text"
                    class="form-control @error('nama') is-invalid @enderror"
                    id="nama"
                    name="nama"
                    placeholder="Masukan nama Anda"
                    value="{{ old('nama') }}"
                    autofocus
                    />
                    @error('nama')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="hp" class="form-label">Nomor HP/Telepon</label>
                    <input type="text" class="form-control @error('hp') is-invalid @enderror" id="hp" name="hp" placeholder="Masukan nomor HP/telepon Anda" value="{{ old('hp') }}"/>
                    @error('hp')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Masukan email Anda" value="{{ old('email') }}"/>
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3 form-password-toggle">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-group input-group-merge @error('password') is-invalid @enderror">
                    <input
                        type="password"
                        id="password"
                        class="form-control @error('password') is-invalid @enderror"
                        name="password"
                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                        aria-describedby="password"
                        value="{{ old('password') }}"
                    />    
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>                
                </div>
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                </div>
                <div class="mb-3 form-password-toggle">
                  <label class="form-label" for="password">Konfirmasi Password</label>
                  <div class="input-group input-group-merge" @error('password_confirmation') is-invalid @enderror>
                    <input
                      type="password"
                      id="password_confirmation"
                      class="form-control @error('password_confirmation') is-invalid @enderror"
                      name="password_confirmation"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      aria-describedby="password_confirmation"
                      value="{{ old('password_confirmation') }}"
                    />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
                @error('password_confirmation')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="alamat">Alamat Lengkap</label>
                    <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" placeholder="Alamat lengkap (sertakan kode pos)">{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror                            
                </div>

                <button class="btn btn-primary d-grid w-100" type="submit">Sign up</button>
              </form>

              <p class="text-center">
                <span>Sudah memiliki akun?</span>
                <a href="{{ route('login') }}">
                  <span><u>Login</u></span>
                </a>
              </p>
            </div>
          </div>
          <!-- Register Card -->
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

<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
    <meta name="description" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('meta')
    
    <title>SITSA | {{ $title }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Quicksand&family=Poppins&display=swap" rel="stylesheet">
    
    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('assets_admin/vendor/fonts/boxicons.css') }}" />
    <link rel="icon" type="image/x-icon" href="{{ asset('/assets_user/img/icon.png') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets_admin/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets_admin/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets_admin/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets_admin/css/styles.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets_admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets_admin/vendor/libs/apex-charts/apex-charts.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets_admin/vendor/libs/sweetalert2/sweetalert2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets_admin/vendor/libs/choices.js/choices.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets_admin/vendor/libs/bootstrap-icons/bootstrap-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets_admin/vendor/libs/toastify/toastify.css') }}" />
    
    <!-- Datatable  -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.13.1/af-2.5.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/cr-1.6.1/date-1.2.0/fc-4.2.1/fh-3.3.1/kt-2.8.0/r-2.4.0/rg-1.3.0/rr-1.3.1/sc-2.0.7/sb-1.4.0/sp-2.1.0/sl-1.5.0/sr-1.2.0/datatables.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.2.0/css/dataTables.dateTime.min.css">
    

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ asset('assets_admin/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets_admin/js/config.js') }}"></script>

    @yield('style')
  </head>

  <body>
    @include('sweetalert::alert')
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        
        @include('layouts.admin.menu')

        <!-- Layout page -->
        <div class="layout-page">
          
          @include('layouts.admin.navbar')

          <!-- Content wrapper -->
          <div class="content-wrapper">
            
            @yield('content')

            <footer style="padding: 32px">
              <div class="footer clearfix mb-0 text-muted">
                  <div class="float-start">
                  </div>
                  <div class="float-end">
                    © <script>document.write(new Date().getFullYear());</script>
                    Crafted with ❤️ by 
                    <a href="" target="_blank" class="footer-link fw-bolder">Katarina H S A </a>
                  </div>
              </div>
          </footer>

            <div class="content-backdrop fade"></div>
          </div>
          <!-- / Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    {{-- Pusher --}}
    <script src="/js/app.js "></script>

    <!-- Core JS -->
    <!-- build:js assets_admin/vendor/js/core.js -->
    <script src="{{ asset('assets_admin/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets_admin/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets_admin/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets_admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>

    <script src="{{ asset('assets_admin/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('assets_admin/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets_admin/vendor/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets_admin/vendor/libs/choices.js/choices.min.js') }}"></script>
    <script src="{{ asset('assets_admin/vendor/libs/ckeditor4/ckeditor.js') }}"></script>
    <script src="{{ asset('assets_admin/vendor/libs/pusher/pusher.min.js') }}"></script>
    <script src="{{ asset('assets_admin/vendor/libs/toastify/toastify.js') }}"></script>
    
    <!-- Main JS -->
    <script src="{{ asset('assets_admin/js/main.js') }}"></script>
    <script src="{{ asset('assets_admin/js/form.js') }}"></script>

    <!-- Page JS -->
    {{-- <script src="{{ asset('assets_admin/js/dashboards-analytics.js') }}"></script> --}}

    <!-- Datatable -->
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.13.1/af-2.5.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/cr-1.6.1/date-1.2.0/fc-4.2.1/fh-3.3.1/kt-2.8.0/r-2.4.0/rg-1.3.0/rr-1.3.1/sc-2.0.7/sb-1.4.0/sp-2.1.0/sl-1.5.0/sr-1.2.0/datatables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.11.4/dataRender/ellipsis.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.12/sorting/datetime-moment.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/datetime/1.2.0/js/dataTables.dateTime.min.js"></script>
    
    
    @yield('script')
    
    @yield('datatable')
    
    {{-- Mark Notif --}}
    <script>
      //token csrf
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $(function() {
        $('.mark-as-read').click(function() {
          let id = $(this).data('id');
          $.ajax({
            url: "{{ route('admin.markNotification') }}", 
            method: 'POST',
            data: {
              id
            },
            success: function(data){
              location.reload();
            },
          });
        });
        $('#mark-all').click(function() {
          $.ajax({
            url: "{{ route('admin.markNotification') }}", 
            method: 'POST',
            success: function(data){
              location.reload();
            },
          });
        });
      });
    </script>
    {{-- /Mark Notif --}}

    {{-- Pusher - Realtime Notif --}}
    <script>
      var pusher = new Pusher('1cb0852d58b90daf6c22', {
        encrypted: true,
        cluster: 'ap1'
      });
  
      // Subscribe to the channel we specified in our Laravel Event
      var channel = pusher.subscribe('NewOrder');
      var channel = pusher.subscribe('DeleteOrder');

      // Bind a function to a Event (the full Laravel class)
      channel.bind('Ordered', function(data) {
        notif(data.username);
      });
      channel.bind('OrderBatal', function(data) {
        $('#notif').load(document.URL +  ' #notif');
      });

      function notif(data) {
        $('#notif').load(document.URL +  ' #notif');
        Toastify({
          text: data + " membuat order baru!",
          className: "info",
          gravity: "bottom", // `top` or `bottom`
          position: "right", // `left`, `center` or `right`
          stopOnFocus: true, // Prevents dismissing of toast on hover
          style: {
            background: "linear-gradient(to right, #00b09b, #96c93d)",
          },
        }).showToast();
      }
   </script>
   {{-- /Pusher - Realtime Notif --}}
    
    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

  </body>
</html>

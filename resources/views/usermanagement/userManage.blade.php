@extends('layouts.admin.main')

@section('meta')
@parent
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
  <section class="section container-p-y container-xxl">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Daftar Pelanggan</h4>
            @if ($message = Session::get('error'))
              <div class="alert alert-danger">
                <strong>{{ $message }}</strong>
              </div>
            @endif
        </div>
        <div class="card-body">
          {{-- <a class="btn btn-primary" onclick="create()" style="color: #fff">+Tambah User</a><br /><br /> --}}
          <div id="read"></div>
          <table class="table table-inverse table-responsive table-hover" style="width:100%" id="userTable">
            <thead class="thead-inverse">
              <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Alamat</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
    </div>
    {{-- <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="titlemodal1">Tambah User</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div id="addpage"></div>
          </div>
        </div>
      </div>
    </div> --}}
    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Modal title</h5>
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
  </section>   
@endsection

@section('datatable')
  <script>
    $(document).ready( function () {
      $('#userTable').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        ajax: '{!! route('admin.data_user') !!}',
        columns: [
          { data: 'id', name: 'id' },
          { data: 'nama', name: 'nama' },
          { data: 'email', name: 'email' },
          { data: 'hp', name: 'hp' },
          { data: 'alamat', name: 'alamat' },
          { data: 'action', name: 'action' }
        ]
      });
    });
  </script>
@endsection

@section('script')
    <script>
      function create() {
        $.get(" {{ route('admin.add_user') }} ", {}, function(data,status) {
          $("#titlemodal1").html('Tambah User');
          $("#addpage").html(data);
          $("#addModal").modal('show');
        });
      }

      function store() {
        //define variable
        let name = $("#name").val();
        let email = $("#email").val();
        let phone = $("#phone").val();
        let address = $("#address").val();
        let password = $("#password").val();
        let token   = $("meta[name='csrf-token']").attr("content");

        //ajax
        $.ajax({
          type:"post",
          url:"{{ route('admin.store_user') }}",
          data: {
            'name': name,
            'email':email,
            'phone':phone,
            'address':address,
            'password':password,
            '_token': token
          },
          success: function(data){
            //close modal and refresh table
            $(".btn-close").click();
            $('#userTable').DataTable().ajax.reload();

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

              //loop untuk mnampilkan tiap error
              $.each(errors, function (key, val) {
                  $("#" + key + "_error").text(val[0]);
              });
            }
          }
        });
      }

      function edit(id) {
        $.get("{{ route('admin.edit_user', '')}}"+"/"+id, {}, function(data,status) {
          $("#exampleModalLabel1").html('Ubah User');
          $("#page").html(data);
          $("#editModal").modal('show');
        });
      }

      function update(id) {
        //show confirm message
        Swal.fire({
          title: 'Apakah anda yakin?',
          text: "Data akan diubah secara permanen!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, ubah data!'
        }).then((result) => {
          if (result.isConfirmed) {
            //define variable
            let name = $("#name").val();
            let email = $("#email").val();
            let phone = $("#phone").val();
            let address = $("#address").val();
            let password = $("#password").val();
            let token   = $("meta[name='csrf-token']").attr("content");
    
            //ajax
            $.ajax({
              type:"patch",
              url:"{{ route('admin.update_user', '')}}"+"/"+id,
              data: {
                'name': name,
                'email':email,
                'phone':phone,
                'address':address,
                'password':password,
                '_token': token
              },
              success: function(data){
                //close modal and refresh table
                $(".btn-close").click();
                $('#userTable').DataTable().ajax.reload();
    
                //show success message
                Swal.fire({
                  icon: 'success',
                  title: 'Berhasil!',
                  text: `${data.message}`,
                  showConfirmButton: false,
                  timer: 3000
                });
                if(data.error == true){
                  Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: `${data.message}`,
                    showConfirmButton: false,
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
        });
      }

      function destroy(id) {
        //define variable
        let token   = $("meta[name='csrf-token']").attr("content");

        //show confirm message
        Swal.fire({
          title: 'Apakah anda yakin?',
          text: "Data akan dihapus secara permanen!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, hapus data!'
        }).then((result) => {
          if (result.isConfirmed) {
            //ajax
            $.ajax({
              type:"get",
              url:"{{ route('admin.delete_user', '')}}"+"/"+id,
              data: {
                '_token': token
              },
              success: function(data){
                //close modal and refresh table
                $('#userTable').DataTable().ajax.reload();

                //show success alert
                Swal.fire({
                  icon: 'success',
                  text: `${data.message}`,
                  title: 'Dihapus!',
                  showConfirmButton: false,
                  timer: 3000
                });
              }
            });
          }
        });
        
      }

      function reset(id) {
        //define variable
        let token   = $("meta[name='csrf-token']").attr("content");

        //show confirm message
        Swal.fire({
          title: 'Apakah anda yakin?',
          text: "Password customer akan direset. Segera beritahu customer setelah password direset!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, reset password!'
        }).then((result) => {
          if (result.isConfirmed) {
            //ajax
            $.ajax({
              type:"get",
              url:"{{ route('admin.reset_user', '')}}"+"/"+id,
              data: {
                '_token': token
              },
              success: function(data){
                //close modal and refresh table
                $('#userTable').DataTable().ajax.reload();

                //show success alert
                Swal.fire({
                  icon: 'success',
                  text: `${data.message}`,
                  title: 'Password Direset!',
                  showConfirmButton: false,
                  timer: 3000
                });
              }
            });
          }
        });
        
      }

      function toggle() {
        let pass = document.getElementById('password');
        // toggle the type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        // toggle the eye slash icon
        $(".togglepass").toggleClass("bx bx-show bx bx-hide");
      }
    </script>
@endsection
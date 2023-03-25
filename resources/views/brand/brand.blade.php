@extends('layouts.admin.main')

@section('meta')
@parent
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
  <section class="section container-p-y container-xxl">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Daftar Merek Produk</h4>
            @if ($message = Session::get('error'))
              <div class="alert alert-danger">
                <strong>{{ $message }}</strong>
              </div>
            @endif
        </div>
        <div class="card-body">
          <a class="btn btn-primary" onclick="create()" style="color: #fff">+Tambah Merek</a><br /><br />
          <div id="read"></div>
          <table class="table table-inverse table-responsive table-hover" id="brandTable" style="width:100%">
            <thead class="thead-inverse">
              <tr>
                <th>ID</th>
                <th>Gambar</th>
                <th>Nama</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
    </div>
    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="titlemodal1">Tambah Brand</h5>
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
    </div>
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

    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div id="showpage"></div>
          </div>
        </div>
      </div>
    </div>
  </section>   
@endsection

@section('datatable')
<script>
  $(document).ready( function () {
    let table = $('#brandTable').DataTable({
      processing: true,
      serverSide: true,
      scrollX: true,
      ajax: '{!! route('admin.data_brand') !!}',
      columns: [
        { data: 'id', name: 'id' },
        { data: 'pic_path', name: 'pic_path', 
          render: function( data, type, full, meta ) {
            return "<img src=\"" + data + "\" height=\"50\"/>";
          }
        },
        { data: 'nama', name: 'nama' },
        { data: 'action', name: 'action' }
      ]
    });

    $('#brandTable tbody').on('click', 'tr td:nth-child(2)', function () {
      var data = table.row(this).data();
      Swal.fire({
        title: data['nama'],
        imageUrl: data['pic_path'],
        imageWidth: 300,
        showConfirmButton: false,
      });
    });
  });
</script>
@endsection

@section('script')
    <script>
      //token csrf
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      function readURL(input) {
        if (input.files && input.files[0]) {
          var reader = new FileReader();
          
          reader.onload = function (e) {
            $('#preview').attr('src', e.target.result);
          }
          
          reader.readAsDataURL(input.files[0]);
          $('#picname').attr('disabled',false); 
        }
      }

      function create() {
        $.get(" {{ route('admin.add_brand') }} ", {}, function(data,status) {
          $("#titlemodal1").html('Tambah brand');
          $("#addpage").html(data);
          $("#addModal").modal('show');
        });
      }

      function store(form) {
        //define variable
        let name = $("#name").val();
        let picname = $("#picname").val();
        let pic = $('#pic')[0].files[0];

        var fd = new FormData();
        fd.append('pic', pic);
        fd.append('name', name);
        fd.append('picname', picname);

        //ajax
        $.ajax({
          type:"post",
          url:"{{ route('admin.store_brand') }}",
          data: fd,
          contentType: false,
          processData: false,
          success: function(data){
            //close modal and refresh table
            $(".btn-close").click();
            $('#brandTable').DataTable().ajax.reload();

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
        $.get("{{ route('admin.edit_brand', '')}}"+"/"+id, {}, function(data,status) {
          $("#exampleModalLabel1").html('Ubah brand');
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
            let picname = $("#picname").val();
            let pic = $('#pic')[0].files[0];
    
            var fd = new FormData();
            fd.append('pic', pic);
            fd.append('name', name);
            fd.append('picname', picname);
    
            //ajax
            $.ajax({
              type:"post",
              url:"{{ route('admin.update_brand', '')}}"+"/"+id,
              data: fd,
              contentType: false,
              processData: false,
              success: function(data){
                //close modal and refresh table
                $(".btn-close").click();
                $('#brandTable').DataTable().ajax.reload();
    
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

      function showlist(id) {
        $.get("{{ route('admin.show_by_brand', '')}}"+"/"+id, {}, function(data,status) {
          $("#showpage").html(data);
          $("#detailModal").modal('show');
        });
      }

      function destroy(id, pic) {
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
            //url
            let url = "{{ route('admin.delete_brand', ['id' => ':id', 'pic' => ':pic']) }}";
            url = url.replace(':id', id);
            url = url.replace(':pic', pic);
            //ajax
            $.ajax({
              type:"get",
              url: url,
              success: function(data){
                //close modal and refresh table
                $('#brandTable').DataTable().ajax.reload();

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
    </script>
@endsection
@extends('layouts.admin.main')

@section('meta')
@parent
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
  <section class="section container-p-y container-xxl">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Daftar Produk</h4>
            @if ($message = Session::get('error'))
              <div class="alert alert-danger">
                <strong>{{ $message }}</strong>
              </div>
            @endif
        </div>
        <div class="card-body">
          <a class="btn btn-primary" onclick="create()" style="color: #fff">+Tambah Produk</a><br /><br />
          <div id="read"></div>
          <table class="table table-inverse table-responsive table-hover" id="productTable" style="width:100%">
            <thead class="thead-inverse">
              <tr>
                <th>ID</th>
                <th>Gambar</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Merek</th>
                <th>Stok</th>
                <th>Harga (IDR)</th>
                <th>Expired Date</th>
                <th>Deskripsi</th>
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
            <h5 class="modal-title" id="titlemodal1">Tambah Produk</h5>
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
    <!-- Add Stock Modal -->
    <div class="modal fade" id="addStockModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addStockModalTitle">Tambah Stok</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div id="stockpage"></div>
          </div>
        </div>
      </div>
    </div>
    <!-- substract Stock Modal -->
    <div class="modal fade" id="substractStockModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="substractStockModalTitle">Kurang Stok</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div id="minstok"></div>
          </div>
        </div>
      </div>
    </div>
  </section>   
@endsection

@section('datatable')
  <script>
    $(document).ready( function () {
      let table = $('#productTable').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        // scrollY: true,
        ajax: '{!! route('admin.data_product') !!}',
        columns: [
          { data: 'id', name: 'id' },
          { data: 'pic_path', name: 'pic_path', 
            render: function( data, type, full, meta ) {
              return "<img src=\"" + data + "\" height=\"50\"/>";
            }
          },
          { data: 'nama', name: 'nama' },
          { data: 'category.nama', name: 'category.nama' },
          { data: 'brand.nama', name: 'brand.nama' },
          { data: 'stok', name: 'stok',
            render: function(data, type, row){
              return "<a class='button' onclick='substractStock("+row.id+")'><i class='bx bxs-minus-circle'></i></a>"+data+"<a class='button' onclick='addStock("+row.id+")'><i class='bx bxs-plus-circle'></i></a>";
            } 
          },
          { data: 'harga', name: 'harga',
            render: DataTable.render.number( ',', '.', 2, 'Rp ' )
          },
          { data: 'expired_date', name: 'expired_date' },
          { data: 'deskripsi', name: 'deskripsi',
            render: function(data, type, row) {
              if (type === 'display' && data != null) {
                data = data.replace(/<(?:.|\\n)*?>/gm, '');
                if(data.length > 50) {
                  return '<span class=\"show-ellipsis\">' + data.substr(0, 50) + '</span><span class=\"no-show\">' + data.substr(50) + '</span>';
                } else {
                  return data;
                }
              } else {
                return data;
              }
            }
          },
          { data: 'action', name: 'action' }
        ],
        columnDefs: [
          {
            targets: [5,6],
            className: "text-nowrap",
          }
        ]
      });
 
      $('#productTable tbody').on('click', 'tr td:nth-child(2)', function () {
        var data = table.row(this).data();
        Swal.fire({
          title: data['nama'],
          text: 'Stok: ' +data['stok'],
          imageUrl: data['pic_path'],
          imageWidth: 300,
          showConfirmButton: false,
        });
      });

      $('#productTable tbody').on('click', 'tr td:nth-child(8)', function () {
        var data = table.row(this).data();
        Swal.fire({
          title: 'Deskripsi',
          text: data['deskripsi'],
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
      $.get(" {{ route('admin.add_product') }} ", {}, function(data,status) {
        $("#titlemodal1").html('Tambah Produk');
        $("#addpage").html(data);
        $("#addModal").modal('show');
      });
    }

    function store(form) {
      //define variable
      let name = $("#name").val();
      let category = $("#category").val();
      let brand = $("#brand").val();
      let price = $("#price").val();
      let stock = $("#stock").val();
      let desc = $("#desc").val();
      let picname = $("#picname").val();
      let pic = $('#pic')[0].files[0];

      var fd = new FormData();
      fd.append('pic', pic);
      fd.append('name', name);
      fd.append('picname', picname);
      fd.append('category', category);
      fd.append('brand', brand);
      fd.append('price', price);
      fd.append('stock', stock);
      fd.append('desc', desc);

      //ajax
      $.ajax({
        type:"post",
        url:"{{ route('admin.store_product') }}",
        data: fd,
        contentType: false,
        processData: false,
        success: function(data){
          //close modal and refresh table
          $(".btn-close").click();
          $('#productTable').DataTable().ajax.reload();

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
      $.get("{{ route('admin.edit_product', '')}}"+"/"+id, {}, function(data,status) {
        $("#exampleModalLabel1").html('Ubah product');
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
            let category = $("#category").val();
            let brand = $("#brand").val();
            let price = $("#price").val();
            let stock = $("#stock").val();
            let desc = $("#desc").val();
            let picname = $("#picname").val();
            let pic = $('#pic')[0].files[0];

            var fd = new FormData();
            fd.append('pic', pic);
            fd.append('name', name);
            fd.append('picname', picname);
            fd.append('category', category);
            fd.append('brand', brand);
            fd.append('price', price);
            fd.append('stock', stock);
            fd.append('desc', desc);
      
            //ajax
            $.ajax({
              type:"post",
              url:"{{ route('admin.update_product', '')}}"+"/"+id,
              data: fd,
              contentType: false,
              processData: false,
              success: function(data){
                //close modal and refresh table
                $(".btn-close").click();
                $('#productTable').DataTable().ajax.reload();
      
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
              }
            });
          }
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
          let url = "{{ route('admin.delete_product', ['id' => ':id', 'pic' => ':pic']) }}";
          url = url.replace(':id', id);
          url = url.replace(':pic', pic);
          //ajax
          $.ajax({
            type:"get",
            url: url,
            success: function(data){
              //close modal and refresh table
              $('#productTable').DataTable().ajax.reload();

              //show success alert
              Swal.fire({
                icon: 'success',
                text: `${data.message}`,
                title: 'Dihapus!',
                showConfirmButton: false,
                timer: 3000
              });
            },
            error: function(data){
              Swal.fire({
                icon: 'error',
                text: 'Data tidak dapat dihapus!',
                title: 'Gagal!',
                showConfirmButton: false,
                timer: 3000
              });
            }
          });
        }
      });
    }

    function addStock(id) {
      $.get("{{ route('admin.add_stock', '')}}"+"/"+id, {}, function(data,status) {
        $("#addStockModalTitle").html('Tambah stok product');
        $("#stockpage").html(data);
        $("#addStockModal").modal('show');
      });
    }  

    function substractStock(id) {
      $.get("{{ route('admin.substract_stock', '')}}"+"/"+id, {}, function(data,status) {
        $("#substractStockModalTitle").html('Kurang stok product');
        $("#minstok").html(data);
        $("#substractStockModal").modal('show');
      });
    }  
    
    function jumlahstock() {
      let a = parseFloat($("#stocktersedia").val()); 
      let b = parseFloat($("#ubahstok").val()); 
      $("#jumlah").val(a + b);
    }

    function kurangstock() {
      let a = parseFloat($("#stocktersedia").val()); 
      let b = parseFloat($("#ubahstok").val()); 
      $("#jumlah").val(a - b);
    }

    function updateStock(id) {
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
          let ubahstok = $("#ubahstok").val();
    
          var fd = new FormData();
          fd.append('ubahstok', ubahstok);          
      
          //ajax
          $.ajax({
            type:"post",
            url:"{{ route('admin.update_stock', '')}}"+"/"+id,
            data: fd,
            contentType: false,
            processData: false,
            success: function(data){
              //close modal and refresh table
              $(".btn-close").click();
              $('#productTable').DataTable().ajax.reload();
    
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
      });
    }

  </script>
  <script>
    $(document).ready(function () { 
      $('#addModal').on('shown.bs.modal', function (e) {
        const choice1 = new Choices('#brand');
        const choice2 = new Choices('#category');
        // CKEDITOR.replace( 'desc' );
      });

      $('#editModal').on('shown.bs.modal', function (e) {
        const choice3 = new Choices('#brand');
        const choice4 = new Choices('#category');
        // CKEDITOR.replace( 'desc' );
      });
    });
  </script>
@endsection
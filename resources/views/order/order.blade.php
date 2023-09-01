@extends('layouts.admin.main')

@section('meta')
@parent
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
  <section class="section container-p-y container-xxl">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Daftar Order Produk</h4>
            @if ($message = Session::get('error'))
              <div class="alert alert-danger">
                <strong>{{ $message }}</strong>
              </div>
            @endif
        </div>
        <div class="card-body">
          <div id="read"></div>
          <table class="table table-inverse table-responsive table-hover" id="orderTable" style="width:100%">
            <thead class="thead-inverse">
              <tr>
                <th>Order ID</th>
                <th>User ID</th>
                <th>Jumlah</th>
                <th>Total</th>
                <th>Bukti Transfer</th>
                <th>Jenis</th>
                <th>Resi</th>
                <th>Status</th>
                <th>Confirmed By</th>
                <th>Details</th>
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
            <h5 class="modal-title" id="titlemodal1">Tambah Order</h5>
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
    <!-- Order Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title lead fw-bold p-3" id="detailModalTitle">Modal title</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
              id="detailModalClose"
            ></button>
          </div>
          <div class="modal-body" id="mbdetail">
            <div id="detailpage"></div>
          </div>
        </div>
      </div>
    </div>
    <!-- Add Resi Modal -->
    <div class="modal fade" id="addResiModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addResiModalTitle">Tambah Resi</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div id="resipage"></div>
          </div>
        </div>
      </div>
    </div>
  </section>   
@endsection

@section('datatable')
  <script>
    $(document).ready( function () {
      let table = $('#orderTable').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        ajax: '{!! route('admin.data_order') !!}',
        columns: [
          { data: 'id', name: 'id',
            render: function( data, type, full, meta ){
              return "<span>Order #"+data+"</span>"
            }
          },
          { data: 'user.nama', name: 'user.nama' },
          { data: 'jumlah', name: 'jumlah' },
          { data: 'total', name: 'total',
            render: DataTable.render.number( ',', '.', 2, 'Rp ' )
          },
          { data: 'bukti_transfer_path', name: 'bukti_transfer_path', 
            render: function( data, type, full, meta ) {
              if(data != null){
                return "<img src=\"" + data + "\" height=\"50\"/>";
              }
              else {
                return "Menunggu pembayaran";
              }
            }
          },
          { data: 'jenis', name: 'jenis' },
          { data: 'resi', name: 'resi',
            render: function(data, type, row){
              if(data === null && row.jenis === 'online'){
                return "<a class='button' onclick='addResi("+row.id+")'><i class='bx bxs-plus-circle'></i></a>";
              }
              else{
                return data;
              }
            } 
          },
          { data: 'status', name: 'status',
            render: function (data, type, row) {
              if(data == 'Menunggu konfirmasi'){
                return '<a style="color: white; font-size: 15px;" onclick="confirm('+row.id+')" id="status" class="btn btn-warning">' + data + '</a>';
              }
              else if(data == 'Menunggu pembayaran'){
                return '<a style="color: white; font-size: 15px;" id="status" class="btn btn-danger">' + data + '</a>';
              }
              else if(data == 'Dalam pengiriman'){
                return '<a style="color: white; font-size: 15px;" id="status" class="btn btn-waiting">' + data + '</a>';
              }
              else if(data == 'Pembayaran terkonfirmasi'){
                return '<a style="color: white; font-size: 15px;" id="status" class="btn btn-info">' + data + '</a>';
              }
              else if(data == 'Pesanan dapat diambil'){
                return '<a style="color: white; font-size: 15px;" onclick="complete('+row.id+')" id="status" class="btn btn-info">' + data + '</a>';
              }
              else if(data == 'Gagal dikonfirmasi'){
                return '<a style="color: white; font-size: 15px;" onclick="confirm('+row.id+')" id="status" class="btn btn-secondary">' + data + '</a>';
              }
              else{
                return '<a style="color: white; font-size: 15px;" id="status" class="btn btn-success">' + data + '</a>';
              }
            },
          },
          { data: 'admin.nama', name: 'admin.nama', defaultContent: "None" },
          { data: 'details', name: 'details' }
        ],
        columnDefs: [
          {
            targets: [0,3,6],
            className: "text-nowrap",
          }
        ]
      });
 
      $('#orderTable tbody').on('click', 'tr td:nth-child(5)', function () {
        var data = table.row(this).data();
        if(data['status'] == 'Menunggu konfirmasi' || data['status'] == 'Gagal dikonfirmasi') {
          Swal.fire({
            title: "Order #"+data['id'],
            imageUrl: data['bukti_transfer_path'],
            imageWidth: 250,
            html:
            'Status akan diubah menjadi <b>Pembayaran Terkonfirmasi!</b> ' +
            'Jika bukti tidak sesuai silahkan <b class="text-danger">BATALKAN</b> ' +
            'konfirmasi pembayaran.',
            showDenyButton: true,
            showCloseButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ya, konfirmasi!',
            denyButtonText: 'Tidak, batalkan!',
          }).then((result) => {
            if (result.isConfirmed) {
              //ajax
              $.ajax({
                type:"post",
                url: "{{ route('admin.confirm_payment', '')}}"+"/"+data['id'],
                success: function(data){
                  //close modal and refresh table
                  $('#orderTable').DataTable().ajax.reload();
  
                  //show success alert
                  Swal.fire({
                    icon: 'success',
                    text: `${data.message}`,
                    title: 'Terkonfirmasi!',
                    showConfirmButton: false,
                    timer: 3000
                  });
                }
              });
            } 
            else if (result.isDenied) {
              //ajax
              Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Konfirmasi pembayaran akan dibatalkan! Mohon cek kembali bukti transfer yang dikirimkan pelanggan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, batalkan!',
              }).then((result) => {
                if (result.isConfirmed){
                  //ajax
                  $.ajax({
                    type:"post",
                    url: "{{ route('admin.not_confirm', '')}}"+"/"+data['id'],
                    success: function(data){
                      //close modal and refresh table
                      $('#orderTable').DataTable().ajax.reload();
  
                      //show success alert
                      Swal.fire({
                        icon: 'success',
                        text: `${data.message}`,
                        title: 'Status diubah!',
                        showConfirmButton: false,
                        timer: 3000
                      });
                    }
                  });
                }
              });
            }
          });
        }
        else {
          Swal.fire({
            title: "Order #"+data['id'],
            imageUrl: data['bukti_transfer_path'],
            imageWidth: 250,
          });
        }
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

      function confirm(id){
        //show confirm message
        Swal.fire({
          title: 'Apakah anda yakin?',
          html:
            'Status akan diubah menjadi <b>Pembayaran Terkonfirmasi!</b> ' +
            'Jika bukti tidak sesuai silahkan <b class="text-danger">BATALKAN</b> ' +
            'konfirmasi pembayaran.',
          icon: 'info',
          showDenyButton: true,
          showCloseButton: true,
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'Ya, konfirmasi!',
          denyButtonText: 'Tidak, batalkan!',
        }).then((result) => {
          if (result.isConfirmed) {
            //ajax
            $.ajax({
              type:"post",
              url: "{{ route('admin.confirm_payment', '')}}"+"/"+id,
              success: function(data){
                //close modal and refresh table
                $('#orderTable').DataTable().ajax.reload();

                //show success alert
                Swal.fire({
                  icon: 'success',
                  text: `${data.message}`,
                  title: 'Terkonfirmasi!',
                  showConfirmButton: false,
                  timer: 3000
                });
              }
            });
          } 
          else if (result.isDenied) {
            //ajax
            Swal.fire({
              title: 'Apakah anda yakin?',
              text: "Konfirmasi pembayaran akan dibatalkan! Mohon cek kembali bukti transfer yang dikirimkan pelanggan.",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Ya, batalkan!',
            }).then((result) => {
              if (result.isConfirmed){
                //ajax
                $.ajax({
                  type:"post",
                  url: "{{ route('admin.not_confirm', '')}}"+"/"+id,
                  success: function(data){
                    //close modal and refresh table
                    $('#orderTable').DataTable().ajax.reload();

                    //show success alert
                    Swal.fire({
                      icon: 'success',
                      text: `${data.message}`,
                      title: 'Status diubah!',
                      showConfirmButton: false,
                      timer: 3000
                    });
                  }
                });
              }
            });
          }
        });
      }

      function addResi(id) {
        $.get("{{ route('admin.add_resi', '')}}"+"/"+id, {}, function(data,status) {
          $("#addresiModalTitle").html('Tambah Resi');
          $("#resipage").html(data);
          $("#addResiModal").modal('show');
        });
      }  
      
      function updateresi(id) {
        //show confirm message
        Swal.fire({
          title: 'Apakah anda yakin?',
          text: "Resi akan ditambahkan!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, tambahkan resi!'
        }).then((result) => {
          if (result.isConfirmed) {
            //define variable
            let resi = $("#resi").val();
            
            var fd = new FormData();
            fd.append('resi', resi);          
            
            //ajax
            $.ajax({
              type:"post",
              url:"{{ route('admin.update_resi', '')}}"+"/"+id,
              data: fd,
              contentType: false,
              processData: false,
              success: function(data){
                //close modal and refresh table
                $(".btn-close").click();
                $('#orderTable').DataTable().ajax.reload();
                
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

      function detail(id) {
        $.get("{{ route('admin.order_details', '')}}"+"/"+id, {}, function(data,status) {
          $("#detailModalTitle").html('Detail Pemesanan');
          $("#detailpage").html(data);
          $("#detailModal").modal('show');
        });
      }
      function complete(id) {
        //show confirm message
        Swal.fire({
          title: 'Apakah anda yakin?',
          text: "Pesanan akan diselesaikan!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, selesaikan pesanan!'
        }).then((result) => {
          if (result.isConfirmed) {
            //ajax
            $.ajax({
              type:"get",
              url:"{{ route('admin.complete_order', '')}}"+"/"+id,
              success: function(data){
                $('#orderTable').DataTable().ajax.reload();
                //show success alert
                Swal.fire({
                  icon: 'success',
                  text: 'Pesanan telah diselesaikan.',
                  title: 'Pesanan Selesai!',
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

{{-- <a 
  class="button detail text-primary" 
  style="cursor:pointer"
  onclick="event.preventDefault();detail({{ $model->id }})" 
  data-bs-toggle="tooltip" 
  title="detail order" >
  Order Details</a> --}}
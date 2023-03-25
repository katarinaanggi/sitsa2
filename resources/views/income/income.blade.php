@extends('layouts.admin.main')

@section('meta')
@parent
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
  <section class="section container-p-y container-xxl">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Daftar Pemasukan Toko</h4>
            @if ($message = Session::get('error'))
              <div class="alert alert-danger">
                <strong>{{ $message }}</strong>
              </div>
            @endif
        </div>
        <div class="card-body">
          <a class="btn btn-primary mb-3" onclick="create()" style="color: #fff">+Tambah Pemasukan</a><br /><br />
          <div id="read"></div>
          <form action="{{ route('admin.export') }}" id="range" method="POST">
            @csrf
            @method('POST')
          {{-- <table cellspacing="5" cellpadding="5" class="mb-3">
            <tbody>
              <tr>
                <td>Minimum date:</td>
                <td><input type="text" id="min" name="min"></td>
              </tr>
              <tr>
                <td>Maximum date:</td>
                <td><input type="text" id="max" name="max"></td>
              </tr>
            </tbody>
          </table> --}}
            <div class="row g-2">
              <div class="col mb-3">
                <label for="min">Minimum Date : </label>
                <input type="text" class="minmaxdate" id="min" name="min">
              </div>
            </div>
            <div class="row g-2">
              <div class="col mb-3">
                <label for="max">Maximum Date : </label>
                <input type="text" class="minmaxdate" id="max" name="max">
              </div>
            </div>
            {{-- <button type="submit" id="exportall" class="btn btn-info mb-3 mt-4" style="color: #fff">Export All Data</button> --}}
          </form>
          <a href="" id="reset" class="btn btn-info mb-3 mt-4" style="color: #fff">Reset</a>
          <table class="table table-inverse table-responsive table-hover" id="incomeTable" style="width:100%">
            <thead class="thead-inverse">
              <tr>
                <th>ID</th>
                <th>Tanggal (y-m-d)</th>
                <th>Nama</th>
                <th>Jumlah</th>
                <th>Total</th>
                <th>Deskripsi</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
              <tr>
                  <th colspan="4" style="text-align:right">Total Pemasukan: </th>
                  <th></th>
              </tr>
          </tfoot>
          </table>
        </div>
      </div>
      <!-- Add Modal -->
      <div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="titlemodal1">Tambah income</h5>
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
  </section>   
  @endsection
  
  @section('datatable')
  <script>
  var minDate, maxDate;
  $.fn.dataTable.Buttons.defaults.dom.button.className = 'btn';
  
  $(document).ready( function () {
    // Create date inputs
    minDate = new DateTime($('#min'), {
        format: 'YYYY-MM-DD'
    });
    maxDate = new DateTime($('#max'), {
        format: 'YYYY-MM-DD'
    });
  
    //Datatables
    var table = $('#incomeTable').DataTable({
      processing: true,   
      searching: true,
      scrollX: true,
      scrollY: 500,
      lengthMenu: [
          [10, 25, 50, -1],
          [10, 25, 50, 'All'],
      ],
      ajax: '{!! route('admin.data_income') !!}',
      columns: [
        { data: 'id', name: 'id' },
        { data: 'tanggal', name: 'tanggal' },
        { data: 'nama', name: 'nama' },
        { data: 'jumlah', name: 'jumlah' },
        { data: 'total', name: 'total',
            render: DataTable.render.number( ',', '.', 2, 'Rp ' )
        },
        { data: 'deskripsi', name: 'deskripsi' },
        { data: 'action', name: 'action' }
      ],
      columnDefs: [
        {
          targets: [1,4],
          className: "text-nowrap",
        }
      ],
      dom: '<"mb-3"B><"container-fluid"<"row"<"col"l><"col"f>>>rtip', /*length (l), search (f), processing (r), table (t), info (i), pagination (p), button (B)*/
      buttons: [
        {
          extend: 'excel',
          className: 'btn-success',
          text: 'Excel',
          title: 'Rekap Pemasukan Sri Ayu',
          footer: true, 
          exportOptions: {
            columns: [ 1, 2, 3, 4, 5 ],
            format: {
              body: function ( data, row, column, node ) {
                // Strip Rp from salary column to make it numeric
                return column === 3 ?
                  data.replace( /[Rp \$,]/g, '' ).slice(0,-3) :
                  data;
              }
            }
          }
        }
      ],
      // Total Jumlah
      footerCallback: function (row, data, start, end, display) {
        var api = this.api();
        var uang = $.fn.dataTable.render.number( ',', '.', 2, 'Rp ' ).display;

        // Remove the formatting to get integer data for summation
        var intVal = function (i) {
          return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
        };

        // Total over all pages
        total = api
          .column(4)
          .data()
          .reduce(function (a, b) {
              return intVal(a) + intVal(b);
          }, 0);

        // Total over this page
        pageTotal = api
          .column(4, { page: 'current' })
          .data()
          .reduce(function (a, b) {
              return intVal(a) + intVal(b);
          }, 0);

        // Update footer
        $(api.column(4).footer())
          .attr('colspan',3)
          .css("text-align", "center")
          .html(uang(pageTotal) + ' ( Dari ' + uang(total) + ' total)');
      },
    });
  
    // Refilter the table
    $('#min, #max').on('change', function () {
      if($('#min').val() == '' && $('#max').val() == ''){
        $.fn.dataTable.ext.search.splice($.fn.dataTable.ext.search.indexOf(filterdate, -1));
      }
      else {
        // Custom filtering function which will search data in column four between two values
        var filterdate = function( settings, data, dataIndex ) {
          var min = minDate.val();
          var max = maxDate.val();
          var date = new Date( data[1] );
      
          if (
            ( min === null && max === null ) ||
            ( min === null && date <= max ) ||
            ( min <= date   && max === null ) ||
            ( min <= date   && date <= max )
          ) {
            return true;
          }
          return false;
        }
        $.fn.dataTable.ext.search.push(filterdate);
      }
      table.draw()
    });

    // $('#exportall').on('click', function () {
    //   let min = minDate.val();
    //   let max = maxDate.val();
    //   $('#min').val = min;
    //   $('#max').val = max;
    //   var form = $('#range');
    //   form.submit();
    //   // url
    //   // let url = "{{ route('admin.export', ['minDate' => ':minDate', 'maxDate' => ':maxDate']) }}";
    //   // url = url.replace(':minDate', min);
    //   // url = url.replace(':maxDate', max);
    //   // $.ajax({
    //   //   type:"get",
    //   //   url: url,
    //   //   success: function(data){
    //   //     //show success message
    //   //     Swal.fire({
    //   //       icon: 'success',
    //   //       title: 'Berhasil!',
    //   //       text: 'Berhasil diexport',
    //   //       showConfirmButton: false,
    //   //       timer: 3000
    //   //     });
    //   //   },
    //   //   error: function(error){
    //   //     Swal.fire({
    //   //       icon: 'error',
    //   //       title: 'Gagal!',
    //   //       text: "Gagal diexport",
    //   //       showConfirmButton: false,
    //   //       timer: 3000
    //   //     });
    //   //   }
    //   // });
    // });
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

      function create() {
        $.get(" {{ route('admin.add_income') }} ", {}, function(data,status) {
          $("#titlemodal1").html('Tambah Income');
          $("#addpage").html(data);
          $("#addModal").modal('show');
        });
      }

      function store(form) {
        //define variable
        let name = $("#name").val();
        let date = $("#date").val();
        let amount = $("#amount").val();
        let total = $("#total").val();
        let desc = $("#desc").val();

        var fd = new FormData();
        fd.append('name', name);
        fd.append('date', date);
        fd.append('total', total);
        fd.append('amount', amount);
        fd.append('desc', desc);

        //ajax
        $.ajax({
          type:"post",
          url:"{{ route('admin.store_income') }}",
          data: fd,
          contentType: false,
          processData: false,
          success: function(data){
            //close modal and refresh table
            $(".btn-close").click();
            $('#incomeTable').DataTable().ajax.reload();

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
        $.get("{{ route('admin.edit_income', '')}}"+"/"+id, {}, function(data,status) {
          $("#exampleModalLabel1").html('Ubah Income');
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
            let date = $("#date").val();
            let amount = $("#amount").val();
            let total = $("#total").val();
            let desc = $("#desc").val();

            var fd = new FormData();
            fd.append('name', name);
            fd.append('date', date);
            fd.append('total', total);
            fd.append('amount', amount);
            fd.append('desc', desc);
    
            //ajax
            $.ajax({
              type:"post",
              url:"{{ route('admin.update_income', '')}}"+"/"+id,
              data: fd,
              contentType: false,
              processData: false,
              success: function(data){
                //close modal and refresh table
                $(".btn-close").click();
                $('#incomeTable').DataTable().ajax.reload();
    
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
            // let url = "{{ route('admin.delete_income', ['id' => ':id']) }}";
            // url = url.replace(':id', id);
            //ajax
            $.ajax({
              type:"get",
              url:"{{ route('admin.delete_income', '')}}"+"/"+id,
              success: function(data){
                //close modal and refresh table
                $('#incomeTable').DataTable().ajax.reload();

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
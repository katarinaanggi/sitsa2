<div class="card-body">
  
  <div class="row">
    <div class="col mb-3">
      <p class="small text-muted mb-1">Date</p>
      <p>{{ $order->created_at }}</p>
    </div>
    <div class="col mb-3">
      <p class="small text-muted mb-1">Order No.</p>
      <p>{{ $order->id }}</p>
    </div>
  </div>

  <div class="mx-n5 px-5 py-4" style="background-color: #f2f2f2;">
    @foreach ($order->order_details as $order_detail)
      <div class="row">
        <div class="col-md-7 col-lg-8">
          <p>{{ $order_detail->product->nama }}</p>
        </div>
        <div class="col-md-1 col-lg-1">
          <p>{{ $order_detail->jumlah }}</p>
        </div>
        <div class="col-md-4 col-lg-3">
          <p style="text-align:right;">Rp {{ number_format($order_detail->product->harga * $order_detail->jumlah,0, ',' , '.') }}</p>
        </div>
      </div>        
    @endforeach
  </div>

  <div class="row my-4">
    <div class="col-md-4 offset-md-9 col-lg-3 offset-lg-9">
      <p class="lead fw-bold mb-0" style="color: #f37a27;">Rp {{ number_format($order->total,0, ',' , '.') }}</p>
    </div>
  </div>

  <p class="lead fw-bold mb-4 pb-2" style="color: #f37a27;">Tracking Order</p>

  <div class="row">
    <div class="col-lg-12">
      <div class="horizontal-timeline">
        <div class="row d-flex align-items-center">
          <div class="col-md-2">
            <p class="text-muted mb-0 small">Track Order</p>
          </div>
          <div class="col-md-10">
            <div class="progress" style="height: 6px; border-radius: 16px;">
              @if ($order->status == "Selesai")
                <div 
                  class="progress-bar" 
                  role="progressbar"
                  style="width: 100%; border-radius: 16px; background-color: #f37a27;" 
                  aria-valuenow="100"
                  aria-valuemin="0" 
                  aria-valuemax="100">
                </div>
                @elseif ($order->status == "Dalam pengiriman" || $order->status == "Pesanan dapat diambil")
                <div 
                  class="progress-bar" 
                  role="progressbar"
                  style="width: 75%; border-radius: 16px; background-color: #f37a27;" 
                  aria-valuenow="75"
                  aria-valuemin="0" 
                  aria-valuemax="100">
                </div>
              @elseif ($order->status == "Pembayaran terkonfirmasi")
              <div 
                class="progress-bar" 
                role="progressbar"
                style="width: 50%; border-radius: 16px; background-color: #f37a27;"
                aria-valuenow="50" 
                aria-valuemin="0" 
                aria-valuemax="100">
              </div>
              @elseif ($order->status == "Menunggu konfirmasi")
              <div 
                class="progress-bar" 
                role="progressbar"
                style="width: 25%; border-radius: 16px; background-color: #f37a27;" 
                aria-valuenow="25"
                aria-valuemin="0" 
                aria-valuemax="100">
              </div>
              @else
              <div 
                class="progress-bar" 
                role="progressbar"
                style="width: 0%; border-radius: 16px; background-color: #f37a27;"
                aria-valuenow="0" 
                aria-valuemin="0" 
                aria-valuemax="100">
              </div>                   
              @endif
            </div>
            <div class="d-flex justify-content-around mb-1">
              <p class="text-muted mt-1 mb-0 small ms-xl-5">{{$order->status}}</p>
              <p class="text-muted mt-1 mb-0 small ms-xl-5">Selesai</p>
            </div>
          </div>
        </div>
      </div>      
    </div>
  </div>  

  {{-- <p class="mt-4 pt-2 mb-0">Want any help? <a href="#!" style="color: #f37a27;">Please contact us</a></p> --}}
  
</div>

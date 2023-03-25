<form method="post" action="{{ route('pay_order',$order->id) }}" enctype="multipart/form-data"  onsubmit="upload({{ $order->id }}); return false;">
    <h6 class="mb-2">Nominal: Rp{{ number_format($order->total,0, ',' , '.') }}</h6>
    @csrf
   {{-- <p>Silakan <i>scan</i> QRIS</p> --}}
    <div class="accordion" id="accordionPanelsStayOpenExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                QRIS
                </button>
            </h2>
            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">
                <div class="accordion-body">
                    <center><img src="/assets_user/img/qris.jpeg" alt="QRIS" width="350"></center>
                </div>
            </div>
        </div>
    </div>

    <label for="pic" class="form-label mt-3">Bukti Pembayaran</label>
    <input type="file" id="pic" class="form-control" placeholder="Masukkan Gambar">
    <span class="text-danger errorsay" role="alert" id="pic_error"></span>

    <button type="submit" style="border: 0ch; float:right" class="primary-btn mt-4">Upload</button>
</form>
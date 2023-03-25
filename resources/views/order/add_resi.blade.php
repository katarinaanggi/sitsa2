<form class="form-horizontal" id="createresi" method="post" onsubmit="updateresi({{ $order->id }}); return false;">
  {{-- Tambah resi --}}
  <div class="row g-2 mb-3">
    <label for="resi" class="form-label">Resi : </label>
    <input type="text" id="resi" class="form-control"/>
    <span class="text-danger errorsay" role="alert" id="resi_error"></span>  
  </div>
  <button type="submit" class="btn btn-primary">Simpan</button>
</form>

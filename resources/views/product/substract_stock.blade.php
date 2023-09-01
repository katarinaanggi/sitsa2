<form class="form-horizontal" id="createstock" method="post" enctype="multipart/form-data" onsubmit="updateStock({{ $product->id }}); return false;">
  {{-- Stok yang sudah ada --}}
  <div class="row g-2 mb-3">
    <label for="stocktersedia" class="form-label">Stok Tersedia : </label>
    <input type="number" id="stocktersedia" class="form-control" value="{{ $product->stok }}" />
  </div>
  {{-- Kurang stok --}}
  <div class="row g-2 mb-3">
    <label for="ubahstok" class="form-label">Kurangi Stok : </label>
    <input type="number" id="ubahstok" class="form-control" oninput="kurangstock();"/>
    <span class="text-danger errorsay" role="alert" id="ubahstok_error"></span>  
  </div>
  <div class="row g-2 mb-3">
    <label for="jumlah" class="form-label">Jumlah : </label>
    <input type="number" class="form-control" id="jumlah" name="jumlah" >
  </div>
  <button type="submit" class="btn btn-primary">Simpan</button>
</form>

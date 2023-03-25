<form class="form-horizontal" id="createstock" method="post" enctype="multipart/form-data" onsubmit="updateStock({{ $product->id }}); return false;">
  {{-- Stok yang sudah ada --}}
  <div class="row g-2 mb-3">
    <label for="stocktersedia" class="form-label">Stok Tersedia : </label>
    <input type="number" id="stocktersedia" class="form-control" value="{{ $product->stok }}" />
  </div>
  {{-- Tambah stok --}}
  <div class="row g-2 mb-3">
    <label for="tambahstok" class="form-label">Tambah Stok : </label>
    <input type="number" id="tambahstok" class="form-control" oninput="jumlahstock();"/>
    <span class="text-danger errorsay" role="alert" id="tambahstok_error"></span>  
  </div>
  <div class="row g-2 mb-3">
    <label for="jumlah" class="form-label">Jumlah : </label>
    <input type="number" class="form-control" id="jumlah" name="jumlah" >
  </div>
  <button type="submit" class="btn btn-primary">Simpan</button>
</form>

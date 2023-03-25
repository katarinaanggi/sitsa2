<form class="form-horizontal" id="createexpense" method="post" enctype="multipart/form-data" onsubmit="store(this); return false;">
  <div class="row g-2">
    <label for="name" class="form-label">Nama</label>
    <input type="text" id="name" class="form-control" placeholder="Masukkan nama" />
    <span class="text-danger errorsay" role="alert" id="name_error"></span>  
  </div>
  <div class="row g-2">
    <label for="date" class="form-label">Tanggal</label>
    <input type="date" id="date" class="form-control" placeholder="dd-mm-yyyy"/>
    <span class="text-danger errorsay" role="alert" id="date_error"></span>  
  </div>
  <div class="row g-2">
    <div class="col mb-3">
      <label for="amount" class="form-label">Jumlah</label>
      <input type="number" id="amount" class="form-control" placeholder="Masukkan jumlah" />
      <span class="text-danger errorsay" role="alert" id="amount_error"></span>  
    </div>
    <div class="col mb-3">
      <label for="total" class="form-label">Total (Rupiah)</label>
      <input type="number" id="total" class="form-control" placeholder="Masukkan total" />
      <span class="text-danger errorsay" role="alert" id="total_error"></span>  
    </div>
  </div>
  <div class="row g-2">
    <label for="desc" class="form-label">Deskripsi</label>
    <textarea type="text" class="form-control" id="desc" name="desc">Masukkan deskripsi</textarea>
  <span class="text-danger errorsay" role="alert" id="desc_error"></span>  
  </div>
  <button type="submit" class="btn btn-primary">Simpan</button>
</form>
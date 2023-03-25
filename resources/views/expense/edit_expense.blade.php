<form class="form-horizontal" id="createexpense" method="post" enctype="multipart/form-data" onsubmit="update({{ $expense->id }}); return false;">
  <div class="row g-2">
    <label for="name" class="form-label">Nama</label>
    <input type="text" id="name" class="form-control" value="{{ $expense->nama }}" placeholder="Masukkan Name" />
    <span class="text-danger errorsay" role="alert" id="name_error"></span>  
  </div>
  <div class="row g-2">
    <label for="date" class="form-label">Tanggal</label>
    <input type="date" id="date" class="form-control" value="{{ $expense->tanggal }}"/>
    <span class="text-danger errorsay" role="alert" id="date_error"></span> 
  </div>
  <div class="row g-2">
    <div class="col mb-3">
      <label for="amount" class="form-label">Jumlah</label>
      <input type="number" id="amount" class="form-control" value="{{ $expense->jumlah }}" placeholder="Masukkan jumlah" />
      <span class="text-danger errorsay" role="alert" id="amount_error"></span>  
    </div>
    <div class="col mb-3">
      <label for="total" class="form-label">Total (Rupiah) : </label>
      <input type="number" id="total" class="form-control" value="{{ $expense->total }}" placeholder="Masukkan total" /> 
      <span class="text-danger errorsay" role="alert" id="total_error"></span>  
    </div>
  </div>
  <div class="row g-2">
    <label for="desc" class="form-label">Deskripsi</label>
    <textarea type="text" class="form-control" id="desc" name="desc">{{ $expense->deskripsi }}</textarea>
    <span class="text-danger errorsay" role="alert" id="desc_error"></span>  
  </div>
  <button type="submit" class="btn btn-danger">Simpan Perubahan</button>
</form>
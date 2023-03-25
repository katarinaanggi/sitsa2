<form class="form-horizontal" id="createproduct" method="post" enctype="multipart/form-data" onsubmit="store(this); return false;">
  <div class="row g-2">
    <div class="col mb-3">
      <div class="row g-2">
        <label for="pic" class="form-label">Gambar</label>
        <input type="file" id="pic" class="form-control" placeholder="Masukkan Gambar" onchange="readURL(this);"/>
        <span class="text-danger errorsay" role="alert" id="pic_error"></span>  
      </div>
      <div class="row g-2">
        <label for="picname" class="form-label">Simpan sebagai</label>
        <input type="text" id="picname" class="form-control" placeholder="Simpan sebagai.." disabled/>
        <span class="text-danger errorsay" role="alert" id="picname_error"></span>  
      </div>
      <div class="row g-2">
        <label for="preview" class="form-label">Preview</label>
        <img src="" id="preview" width="200px" />
      </div>
    </div>
  </div>
  <div class="row g-2">
    <div class="col mb-3">
      <label for="name" class="form-label">Name</label>
      <input type="text" id="name" class="form-control" placeholder="Masukkan Name" />
      <span class="text-danger errorsay" role="alert" id="name_error"></span>  
    </div>
  </div>
  <div class="row g-2">
    <div class="col mb-3">
      <label for="price" class="form-label">Harga</label>
      <input type="number" id="price" class="form-control" placeholder="Masukkan harga" />
      <span class="text-danger errorsay" role="alert" id="price_error"></span>  
    </div>
    <div class="col mb-3">
      <label for="stock" class="form-label">Stok</label>
      <input type="number" id="stock" class="form-control" placeholder="Masukkan stok" />
      <span class="text-danger errorsay" role="alert" id="stock_error"></span>  
    </div>
  </div>
  <div class="row g-2">
    <div class="col mb-3">
      <label for="category" class="form-label">Kategori</label>
      <select name="category" id="category" class="choices form-select ">
        <option value="">--pilih kategori--</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->nama}}</option>
        @endforeach
      </select>
      <span class="text-danger errorsay" role="alert" id="category_error"></span>  
    </div>
    <div class="col mb-3">
      <label for="brand" class="form-label">Merek</label>
      <select name="brand" id="brand" class="choices form-select ">
        <option value="">--pilih merek--</option>
        @foreach($brands as $brand)
            <option value="{{ $brand->id }}">{{ $brand->nama}}</option>
        @endforeach
      </select>
      <span class="text-danger errorsay" role="alert" id="brand_error"></span>  
    </div>
  </div>
  <div class="row g-2 mb-3">
    <label for="desc" class="form-label">Deskripsi</label>
    <textarea type="text" class="form-control" id="desc" name="desc"></textarea>
    <span class="text-danger errorsay" role="alert" id="desc_error" style="display: margin-top: 0 !important"></span>  
  </div>
  <button type="submit" class="btn btn-primary">Simpan</button>
</form>

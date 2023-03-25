<form class="form-horizontal" id="createbrand" method="post" enctype="multipart/form-data" onsubmit="store(this); return false;">
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
  <button type="submit" class="btn btn-primary">Simpan</button>
</form>
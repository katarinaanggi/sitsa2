<form class="form-horizontal" id="createcategory" method="post" enctype="multipart/form-data" onsubmit="update({{ $category->id }}); return false;">
  <div class="row g-2">
    <div class="col mb-3">
      <div class="row g-2 mb-3">
        <label for="prev" class="form-label">Gambar Disimpan :</label>
        <img id="prev" src="{{ url('uploads/categories/'.$category->gambar) }}" width="200px"/>
      </div>
      <div class="row g-2">
        {{-- input Gambar --}}
        <label for="pic" class="form-label">Gambar Baru :</label>
        <input type="file" id="pic" class="form-control" placeholder="Masukkan Gambar" onchange="readURL(this);"/>
        <span class="text-danger errorsay" role="alert" id="pic_error"></span>  
        
        {{-- save as --}}
        <label for="picname" class="form-label">Simpan sebagai</label>
        <input type="text" id="picname" class="form-control" placeholder="Simpan sebagai.." disabled/>
        <span class="text-danger errorsay" role="alert" id="picname_error"></span>  
        
        {{-- preview gambar --}}
        <label for="preview" class="form-label">Preview</label>
        <img src="" id="preview" width="200px" />
      </div>
    </div>
  </div>
  <div class="row g-2">
    <div class="col mb-3">
      <label for="name" class="form-label">Name</label>
      <input type="text" id="name" class="form-control" value="{{ $category->nama }}" placeholder="Masukkan Name" />
      <span class="text-danger errorsay" role="alert" id="name_error"></span>  
    </div>
  </div>
  <button type="submit" class="btn btn-danger">Simpan Perubahan</button>
</form>
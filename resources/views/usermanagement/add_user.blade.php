<div class="row">
  <div class="col mb-3">
    <label for="name" class="form-label">Name</label>
    <input type="text" id="name" class="form-control" placeholder="Masukkan Name" />
    <span class="text-danger errorsay" role="alert" id="name_error"></span>  
    
  </div>
</div>
<div class="row g-2">
  <div class="col mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="text" id="email" class="form-control" placeholder="Masukkan Email" />
    <span class="text-danger errorsay" role="alert" id="email_error"></span>  
    
  </div>
  <div class="col mb-3">
    <label for="phone" class="form-label">Phone</label>
    <input type="text" id="phone" class="form-control" placeholder="+62xxx" />
    <span class="text-danger errorsay" role="alert" id="phone_error"></span>  
  </div>
</div>
<div class="row">
  <div class="col mb-3">
    <label for="address" class="form-label">Alamat</label>
    <input type="text" id="address" class="form-control" placeholder="Masukkan alamat" />
    <span class="text-danger errorsay" role="alert" id="address_error"></span>  
    
  </div>
</div>
<div class="row">
  <div class="col mb-3">
    <label for="password" class="form-label">Password: </label>
    <div class="input-group input-group-merge">
      <input type="password"  id="password" class="form-control" placeholder="Masukkan password">
      <span class="input-group-text cursor-pointer" onclick="toggle();"><i class="togglepass bx bx-hide" ></i></span>
    </div>
    <span class="text-danger errorsay" role="alert" id="password_error"></span>  
    
  </div>
</div>
{{-- <button type="button" class="btn btn-outline-secondary " data-bs-dismiss="modal">
  Close
</button> --}}
<button type="button" class="btn btn-primary" onclick="store()">Simpan</button>

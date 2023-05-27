<div class="row">
  <div class="col mb-3">
    <label for="name" class="form-label">Name</label>
    <input type="text" id="name" class="form-control" value="{{ $user->nama }}" placeholder="Masukkan Name" />
    <span class="text-danger errorsay" role="alert" id="name_error"></span>  
    
  </div>
</div>
<div class="row g-2">
  <div class="col mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="text" id="email" class="form-control" value="{{ $user->email }}" placeholder="Masukkan Email" />
    <span class="text-danger errorsay" role="alert" id="email_error"></span>  
    
  </div>
  <div class="col mb-3">
    <label for="phone" class="form-label">Phone</label>
    <input type="text" id="phone" class="form-control" value="{{ $user->hp }}" placeholder="+62xxx" />
    <span class="text-danger errorsay" role="alert" id="phone_error"></span>  
  </div>
</div>
<div class="row">
  <div class="col mb-3">
    <label for="address" class="form-label">Alamat</label>
    <input type="text" id="address" class="form-control" value="{{ $user->alamat }}" placeholder="Masukkan alamat" />
    <span class="text-danger errorsay" role="alert" id="address_error"></span>  
    
  </div>
</div>
<button type="button" class="btn btn-danger" onclick="update({{ $user->id }})">Simpan Perubahan</button>

<script>
  const togglePassword = document.querySelector('#togglePassword');
  const password = document.querySelector('#password');
  
  togglePassword.addEventListener('click', function (e) {
    // toggle the type attribute
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    // toggle the eye slash icon
    $(this).toggleClass("bi-eye-fill bi-eye-slash-fill");
  });
</script>  
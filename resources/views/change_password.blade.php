<div class="p-2">
    <div class="form-group">
        <label>Password Lama</label>
        <input type="password" id="current_password" name="current_password" class="form-control validate">
        @error('current_password')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
        <span class="text-danger errorsay" role="alert" id="current_password_error"></span>      
    </div>
    <div class="form-group">
        <label>Password Baru</label>
        <input type="password" id="new_password" name="new_password" class="form-control validate">
        @error('new_password')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
        <span class="text-danger errorsay" role="alert" id="new_password_error"></span>       
    </div>
    <div class="form-group">
        <label>Konfirmasi Password Baru</label>
        <input type="password" id="new_confirm_password" name="new_confirm_password" class="form-control validate">
        @error('new_confirm_password')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
        <span class="text-danger errorsay" role="alert" id="new_confirm_password_error"></span>       
    </div>
    <button class="primary-btn btn-block mt-5 border-0" onclick="update({{ auth()->user()->id }})">Simpan Perubahan</button>
</div>
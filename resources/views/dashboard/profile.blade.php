@extends('layouts.admin.main')

@section('style')
    <link rel="stylesheet" href="../assets_admin/vendor/css/pages/profile.css">    
@endsection

@section('content')
  <!-- Main content -->

  <section class="content container-p-y">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <img class="profile-user-img img-fluid img-circle admin_picture" src="../assets_admin/img/avatars/1.png" alt="User profile picture">
              </div>
              <br>

              <h3 class="profile-username text-center admin_name" style="margin: 0">{{ Auth::guard('admin')->user()->nama }}</h3>
              <p class="text-muted text-center">Administrator</p>

              {{-- <input type="file" name="admin_image" id="admin_image" style="opacity: 0;height:1px;display:none"> --}}
              
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

      
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="card">
            <div class="card-header p-2">
              <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                  @if ($key = Session::get('tab'))  
                  <li class="nav-item" role="presentation">
                    <button class="nav-link {{ ($key == 'Personal Information') ? 'active' : '' }}" id="pills-pi-tab" data-bs-toggle="pill" data-bs-target="#pills-pi" type="button" role="tab" aria-controls="pills-pi" aria-selected="true">Informasi</button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link {{ ($key == 'Password') ? 'active' : '' }}" id="pills-pass-tab" data-bs-toggle="pill" data-bs-target="#pills-pass" type="button" role="tab" aria-controls="pills-pass" aria-selected="false">Ubah Password</button>
                  </li>
                  @else
                  <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-pi-tab" data-bs-toggle="pill" data-bs-target="#pills-pi" type="button" role="tab" aria-controls="pills-pi" aria-selected="true">Informasi</button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link " id="pills-pass-tab" data-bs-toggle="pill" data-bs-target="#pills-pass" type="button" role="tab" aria-controls="pills-pass" aria-selected="false">Ubah Password</button>
                  </li>
                  @endif
              </ul>
              @if ($message = Session::get('error'))
                  <div class="alert alert-danger">
                      <strong>{{ $message }}</strong>
                  </div>
              @endif
            </div>
            <!-- /.card-header -->
            <div class="card-body">

              @if ($key = Session::get('tab'))
                <div class="tab-content" id="pills-tabContent">
                  <div class="tab-pane fade {{ ($key == 'Personal Information') ? 'show active' : '' }}" id="pills-pi" role="tabpanel" aria-labelledby="pills-pi-tab">
                      <form class="form-horizontal needs-validation" method="POST" id="formvalid" action="{{ route('admin.changeProfile', Auth::guard('admin')->user()->id) }}" novalidate>
                          @csrf
                          @method('PATCH')
                          <div class="form-group row">
                              <label for="inputName" class="col-sm-2">Nama</label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" id="inputName" placeholder="Name" value="{{ Auth::guard('admin')->user()->nama }}" name="name" minlength="5" maxlength="255" required>
                                  @error('name') 
                                    <span class="text-danger">*{{$message}}</span>  
                                  @else
                                    <span class="invalid-feedback">
                                      Nama harus diisi minimal 5 karakter dan maksimal 255 karakter.
                                    </span> 
                                  @enderror
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="inputEmail" class="col-sm-2">Email</label>
                              <div class="col-sm-10">
                                  <input type="email" class="form-control" id="inputEmail" placeholder="Email" value="{{ Auth::guard('admin')->user()->email }}" name="email" required>
                                  @error('email') 
                                    <span class="text-danger">*{{$message}}</span>  
                                  @else
                                    <span class="invalid-feedback">
                                      Email harus diisi.
                                    </span> 
                                  @enderror
                              </div>
                          </div>
                          <div class="form-group row">
                            <div class="offset-sm-2 col-sm-8">
                              <button type="submit" class="btn btn-save btn-danger">Simpan</button>
                            </div>
                          </div>
                      </form>
                  </div><!-- /.tab-pane -->
                  <div class="tab-pane fade {{ ($key == 'Password') ? 'show active' : '' }}" id="pills-pass" role="tabpanel" aria-labelledby="pills-pass-tab">
                      <form class="form-horizontal needs-validation" action="{{ route('admin.changePassword', Auth::guard('admin')->user()->id) }}" method="POST" id="changePasswordAdminForm" novalidate>
                        @csrf
                        @method('PATCH')
                          <div class="form-group row">
                            <label for="oldpassword" class="col-sm-4">Password Lama</label>
                            <div class="col-sm-8">
                              <input type="password" class="form-control" id="oldpassword" placeholder="Enter current password" name="oldpassword" required>
                              @error('oldpassword') 
                                <span class="text-danger">*{{$message}}</span>  
                              @else
                                <span class="invalid-feedback">
                                  Password lama harus diisi. 
                                </span> 
                              @enderror
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="newpassword" class="col-sm-4">Password Baru</label>
                            <div class="col-sm-8">
                              <input type="password" class="form-control" id="newpassword" placeholder="Enter new password" name="newpassword" required>
                              @error('newpassword') 
                                <span class="text-danger">*{{$message}}</span>  
                              @else
                                <span class="invalid-feedback">
                                  Password baru harus diisi. 
                                </span> 
                              @enderror
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="cnewpassword" class="col-sm-4">Konfirmasi Password</label>
                            <div class="col-sm-8">
                              <input type="password" class="form-control" id="cnewpassword" placeholder="ReEnter new password" name="cnewpassword" required>
                              @error('cnewpassword') 
                                <span class="text-danger">*{{$message}}</span>  
                              @else
                                <span class="invalid-feedback">
                                  Konfirmasi password baru harus diisi. 
                                </span> 
                              @enderror
                            </div>
                          </div>
                        <div class="form-group row">
                          <div class="offset-sm-4 col-sm-8">
                            <button type="submit" class="btn btn-save btn-danger">Ubah Password</button>
                          </div>
                        </div>
                      </form>
                  </div> 
                </div><!-- /.tab-content -->


              
              @else
                <div class="tab-content" id="pills-tabContent">
                  <div class="tab-pane fade show active" id="pills-pi" role="tabpanel" aria-labelledby="pills-pi-tab">
                      <form class="form-horizontal needs-validation" method="POST" id="formvalid" action="{{ route('admin.changeProfile', Auth::guard('admin')->user()->id) }}" novalidate>
                          @csrf
                          @method('PATCH')
                          <div class="form-group row">
                            <label for="inputName" class="col-sm-2">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputName" placeholder="Name" value="{{ Auth::guard('admin')->user()->nama }}" name="name" minlength="5" maxlength="255" required>
                                @error('name') 
                                  <span class="text-danger">*{{$message}}</span>  
                                @else
                                  <span class="invalid-feedback">
                                    Nama harus diisi minimal 5 karakter dan maksimal 255 karakter.
                                  </span> 
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail" class="col-sm-2">Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="inputEmail" placeholder="Email" value="{{ Auth::guard('admin')->user()->email }}" name="email" required>
                                @error('email') 
                                  <span class="text-danger">*{{$message}}</span>  
                                @else
                                  <span class="invalid-feedback">
                                    Email harus diisi.
                                  </span> 
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                          <div class="offset-sm-2 col-sm-8">
                              <button type="submit" class="btn btn-save btn-danger">Simpan</button>
                          </div>
                        </div>
                      </form>
                  </div><!-- /.tab-pane -->
                  <div class="tab-pane fade" id="pills-pass" role="tabpanel" aria-labelledby="pills-pass-tab">
                      <form class="form-horizontal needs-validation" action="{{ route('admin.changePassword', Auth::guard('admin')->user()->id) }}" method="POST" id="changePasswordAdminForm" novalidate>
                        @csrf
                        @method('PATCH')
                        <div class="form-group row">
                          <label for="oldpassword" class="col-sm-4">Password Lama</label>
                          <div class="col-sm-8">
                            <input type="password" class="form-control" id="oldpassword" placeholder="Enter current password" name="oldpassword" required>
                            @error('oldpassword') 
                              <span class="text-danger">*{{$message}}</span>  
                            @else
                              <span class="invalid-feedback">
                                Password lama harus diisi. 
                              </span> 
                            @enderror
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="newpassword" class="col-sm-4">Password Baru</label>
                          <div class="col-sm-8">
                            <input type="password" class="form-control" id="newpassword" placeholder="Enter new password" name="newpassword" required>
                            @error('newpassword') 
                              <span class="text-danger">*{{$message}}</span>  
                            @else
                              <span class="invalid-feedback">
                                Password baru harus diisi. 
                              </span> 
                            @enderror
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="cnewpassword" class="col-sm-4">Konfirmasi Password</label>
                          <div class="col-sm-8">
                            <input type="password" class="form-control" id="cnewpassword" placeholder="ReEnter new password" name="cnewpassword" required>
                            @error('cnewpassword') 
                              <span class="text-danger">*{{$message}}</span>  
                            @else
                              <span class="invalid-feedback">
                                Konfirmasi password baru harus diisi. 
                              </span> 
                            @enderror
                          </div>
                        </div>
                        <div class="form-group row">
                          <div class="offset-sm-4 col-sm-8">
                            <button type="submit" class="btn btn-save btn-danger">Ubah Password</button>
                          </div>
                        </div>
                      </form>
                  </div> 
                </div><!-- /.tab-content -->
              @endif
            </div><!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
@endsection
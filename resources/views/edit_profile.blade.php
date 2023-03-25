@extends('layouts.user.header')

@section('container')
<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="/assets_user/img/breadcrumb.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>{{ $title }}</h2>
                    <div class="breadcrumb__option">
                        <a href="{{ route('home') }}">Home</a>
                        <span>{{ $title }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->
<section class="checkout spad" style="padding-top: 40px">
    <div class="container">
        <div class="checkout__form">
            <div class="row">
                <div class="checkout__order">
                    <form action="{{ route('edit_profile',$user->id) }}" method="post">
                        <h4>Profil</h4>
                        @csrf
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label class="labels">Nama</label>
                                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama" value="{{ old('nama', $user->nama) }}">
                                @error('nama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-12 mt-3">
                                <label class="labels">Nomor HP/Telepon</label>
                                <input type="text" name="hp" class="form-control @error('hp') is-invalid @enderror" placeholder="Nomor HP/Telepon" value="{{ old('hp', $user->hp) }}">
                                @error('hp')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-12 mt-3">
                                <label class="labels">Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email', $user->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-12 mt-3">
                                <label class="labels">Alamat Lengkap (Sertakan Kode Pos)</label>
                                <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" placeholder="Alamat lengkap (sertakan kode pos)">{{ old('alamat', $user->alamat) }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror                            
                            </div>
                        </div>
                        <div class="mt-5 text-center">
                            <button class="primary-btn" type="submit" style="border: 0ch">Simpan Profil</button>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</section>
@endsection
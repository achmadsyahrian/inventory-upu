@extends('app')
@section('content')

<x-sweetalert></x-sweetalert>

<div class="section-header">
   <h1>Profile</h1>
   <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
      <div class="breadcrumb-item">Profile</div>
   </div>
</div>

<div class="section-body">
   <h2 class="section-title">Hi, {{ $auth->name }}</h2>
   <p class="section-lead">
      Perbarui informasi tentang diri Anda di halaman ini.
   </p>

   <div class="row mt-sm-4">
      <div class="col-12 col-md-12 col-lg-12">
         <div class="card">
            <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data" novalidate="">
            @csrf
               <div class="card-header">
                  <h4>Edit Profile</h4>
               </div>
               <div class="card-body">
                  <div class="row">
                     <div class="form-group col-md-1 col-12">
                        <figure class="avatar mr-2 avatar-xl">
                           @if ($auth->photo)
                              <img src="{{ asset('storage/photos/user/' . $auth->photo) }}" alt="Foto Profile">
                           @else
                              <img src="{{ asset('assets/img/avatar/avatar-1.png') }}" alt="Foto Profile">
                           @endif
                         </figure>
                     </div>
                     <div class="col-sm-12 col-md-4">
                        <div class="custom-file">
                          <input type="file" name="photo" class="custom-file-input @error('photo') is-invalid @enderror" id="profile-logo">
                          <label class="custom-file-label">Choose File</label>
                        </div>
                        @error('photo')
                           <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Batas maksimal ukuran gambar adalah 2MB</div>
                      </div>
                  </div>
                  <div class="row">
                     <div class="form-group col-md-6 col-12">
                        <label>Nama <x-label-required></x-label-required></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $auth->name }}" placeholder="Masukkan nama">
                        <x-invalid-feedback field='name'></x-invalid-feedback>
                     </div>
                     <div class="form-group col-md-6 col-12">
                        <label>Username <x-label-required></x-label-required></label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ $auth->username }}" placeholder="Masukkan username">
                        <x-invalid-feedback field='username'></x-invalid-feedback>
                     </div>
                  </div>
                  <div class="row">
                     <div class="form-group col-md-7 col-12">
                        <label>Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $auth->email }}" placeholder="Masukkan email">
                        <x-invalid-feedback field='email'></x-invalid-feedback>
                     </div>
                     <div class="form-group col-md-5 col-12">
                        <label>No. Handphone</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $auth->phone }}" placeholder="Masukkan nomor">
                        <x-invalid-feedback field='phone'></x-invalid-feedback>
                     </div>
                  </div>
                  <div class="row">
                     <div class="form-group col-md-12 col-12">
                        <label>Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Masukkan password">
                        <x-invalid-feedback field='password'></x-invalid-feedback>
                        <div class="form-text text-muted">Kosongkan jika tidak ingin menggantinya</div>
                     </div>
                  </div>
               </div>
               <div class="card-footer text-right">
                  <button class="btn btn-primary">Simpan</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>


@endsection

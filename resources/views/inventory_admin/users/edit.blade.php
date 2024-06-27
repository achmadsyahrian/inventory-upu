@extends('app')
@section('content')

<div class="section">
   <x-sweetalert></x-sweetalert>

   <div class="section-header">
      <div class="section-header-back">
         <a href="{{ route('inventory_admin.users.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
      </div>
      <h1>Edit User</h1>
      <div class="section-header-breadcrumb">
         <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
         <div class="breadcrumb-item active"><a href="{{ route('inventory_admin.users.index') }}">Pengguna</a></div>
         <div class="breadcrumb-item">Edit</div>
      </div>
   </div>

   <div class="section-body">
      <h2 class="section-title">Edit User</h2>
      <p class="section-lead">
         Silakan perbarui informasi pengguna <span class="text-primary">{{ $user->name }}</span> di bawah ini sesuai dengan perubahan yang diinginkan
      </p>

      <div class="row mt-sm-4">
         <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
               <form action="{{ route('inventory_admin.users.update', [$user]) }}" method="post" enctype="multipart/form-data" novalidate="">
                  @method('patch')
                  @csrf
                  <div class="card-header">
                     <h4>Edit User</h4>
                  </div>
                  <div class="card-body">
                     <div class="row mb-3">
                        <div class="form-group col-md-1 col-12">
                           <figure class="avatar mr-2 avatar-xl">
                              @if ($user->photo)
                              <img src="{{ asset('storage/photos/user/' . $user->photo) }}" style="object-fit:cover;" alt="Foto Profile">
                              @else
                              <img src="{{ asset('assets/img/avatar/avatar-1.png') }}" alt="Foto Profile">
                              @endif
                           </figure>
                        </div>
                        <div class="col-sm-7 col-md-7">
                           <label>Foto</label>
                           <div class="custom-file">
                              <input type="file" name="photo" class="custom-file-input @error('photo') is-invalid @enderror" id="profile-logo">
                              <label class="custom-file-label">Pilih Gambar</label>
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
                           <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" placeholder="Masukkan Nama" autocomplete="off">
                           <x-invalid-feedback field='name'></x-invalid-feedback>
                        </div>
                        <div class="form-group col-md-6 col-12">
                           <label>Username <x-label-required></x-label-required></label>
                           <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username', $user->username) }}" placeholder="Masukkan Username" autocomplete="off">
                           <x-invalid-feedback field='username'></x-invalid-feedback>
                        </div>
                     </div>
                     <div class="row">
                        <div class="form-group col-md-7 col-12">
                           <label>Email</label>
                           <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" placeholder="Masukkan Email" autocomplete="off">
                           <x-invalid-feedback field='email'></x-invalid-feedback>
                        </div>
                        <div class="form-group col-md-5 col-12">
                           <label>No. Handphone</label>
                           <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Masukkan Nomor" autocomplete="off">
                           <x-invalid-feedback field='phone'></x-invalid-feedback>
                        </div>
                     </div>
                     <div class="row">
                        <div class="form-group col-md-6 col-12">
                           <label>Divisi <x-label-required></x-label-required></label>
                           <select class="form-control select2" name="division_id">
                              <option selected disabled>Pilih Divisi</option>
                              @foreach ($divisions as $item)
                              <option value="{{ $item->id }}" {{ old('division_id') == $item->id || (isset($user) && $user->division_id == $item->id) ? 'selected' : '' }}>
                                 {{ $item->name }}
                              </option>
                              @endforeach
                           </select>
                           @error('division_id')
                           <div class="form-text text-danger">{{ $message }}</div>
                           @enderror
                        </div>
                        <div class="form-group col-md-6 col-12">
                           <label>Level <x-label-required></x-label-required></label>
                           <select class="form-control selectric" name="role_id">
                              <option selected disabled>Pilih Level</option>
                              @foreach ($roles as $item)
                              <option value="{{ $item->id }}" {{ old('role_id') == $item->id || (isset($user) && $user->role_id == $item->id) ? 'selected' : '' }}>{{ $item->name }}</option>
                              @endforeach
                           </select>
                           @error('role_id')
                           <div class="form-text text-danger">{{ $message }}</div>
                           @enderror
                        </div>
                     </div>
                     <div class="row">
                        <div class="form-group col-md-12 col-12">
                           <label>Password Baru</label>
                           <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Masukkan Password Baru">
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
</div>


@endsection


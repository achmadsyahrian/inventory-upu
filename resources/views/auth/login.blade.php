@extends('app')
@section('auth')

<x-sweetalert></x-sweetalert>

<div class="container mt-5">
   <div class="row">
      <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
         <div class="login-brand">
            <img src="{{ asset('assets/img/me/Logopotensiutama.png') }}" alt="logo" width="100" class="shadow-dark rounded-circle">
         </div>

         <div class="card card-primary">
            <div class="card-header">
               <h4>Login</h4>
            </div>

            <div class="card-body">
               <form method="POST" action="{{ route('auth.login') }}" novalidate="">
                  @csrf
                  <div class="form-group">
                     <label for="username">Username</label>
                     <input id="username" type="username" class="form-control @error('username') is-invalid @enderror" name="username" tabindex="1" placeholder="Masukkan username" required autofocus autocomplete="off">
                     <x-invalid-feedback field='username'></x-invalid-feedback>
                  </div>

                  <div class="form-group">
                     <div class="d-block">
                        <label for="password" class="control-label">Password</label>
                     </div>
                     <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password" name="password" tabindex="2" required>
                     <x-invalid-feedback field='password'></x-invalid-feedback>
                  </div>

                  <div class="form-group">
                     <label>Role</label>
                     <select class="form-control" name="role_id">
                        @foreach ($roles as $item) 
                           <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                     </select>
                   </div>

                  <div class="form-group">
                     <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                        Login
                     </button>
                  </div>
               </form>
            </div>
         </div>
         <div class="simple-footer">
            Copyright &copy; <a href="https://potensi-utama.ac.id/" target="_blank">Universitas Potensi Utama</a> 2024
         </div>
      </div>
   </div>
</div>

@endsection

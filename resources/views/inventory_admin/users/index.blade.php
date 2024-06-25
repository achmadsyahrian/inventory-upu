@extends('app')
@section('content')

<x-sweetalert></x-sweetalert>

<div class="section-header">
   <h1>Users</h1>
   <div class="section-header-button">
      <a href="{{ route('users.create') }}" class="btn btn-primary">Tambah</a>
   </div>
   <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
      <div class="breadcrumb-item">Pengguna</div>
   </div>
</div>

<div class="section-body">
   <h2 class="section-title">Users</h2>
   <p class="section-lead">
      Anda memiliki kontrol penuh atas semua akun pengguna, termasuk opsi mengedit dan menghapus.
   </p>

   <div class="row mt-4">
      <div class="col-12">
         <div class="card">
            <div class="card-header">
               <h4>Semua User</h4>
            </div>
            <div class="card-body">
               <div class="float-left">
                  <select class="form-control selectric">
                     <option>Action For Selected</option>
                     <option>Move to Draft</option>
                     <option>Move to Pending</option>
                     <option>Delete Pemanently</option>
                  </select>
               </div>
               <div class="float-right">
                  <form>
                     <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search">
                        <div class="input-group-append">
                           <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                        </div>
                     </div>
                  </form>
               </div>

               <div class="clearfix mb-3"></div>

               <div class="table-responsive">
                  <table class="table table-striped">
                     <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Divisi</th>
                        <th>Level</th>
                     </tr>
                     @forelse ($users as $item)
                        <tr>
                           <td>{{ $loop->iteration }}</td>
                           <td>
                              <div class="d-flex align-items-center">
                                  <img alt="image" src="{{ asset('assets/img/avatar/avatar-5.png') }}" class="rounded-circle" width="35" data-toggle="title" title="">
                                  <div class="ml-3">
                                      <div>{{ $item->name }}</div>
                                      <div>
                                          <a href="#">View</a>
                                          <span class="bullet">•</span>
                                          <a href="#">Edit</a>
                                          <span class="bullet">•</span>
                                          <a href="#" class="text-danger">Trash</a>
                                      </div>
                                  </div>
                              </div>
                          </td>
                           <td>
                              <a href="#">Web Developer</a>,
                              <a href="#">Tutorial</a>
                           </td>
                           <td>
                              <a href="#">
                                 <div class="d-inline-block ml-1">{{ $item->division->name ??'--' }}</div>
                              </a>
                           </td>
                           <td>
                              <div class="badge badge-primary">{{ $item->role->name }}</div>
                           </td>
                        </tr>
                     @empty
                         
                     @endforelse
                  </table>
               </div>
               <div class="float-right">
                  <nav>
                     <ul class="pagination">
                        <li class="page-item disabled">
                           <a class="page-link" href="#" aria-label="Previous">
                              <span aria-hidden="true">&laquo;</span>
                              <span class="sr-only">Previous</span>
                           </a>
                        </li>
                        <li class="page-item active">
                           <a class="page-link" href="#">1</a>
                        </li>
                        <li class="page-item">
                           <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item">
                           <a class="page-link" href="#">3</a>
                        </li>
                        <li class="page-item">
                           <a class="page-link" href="#" aria-label="Next">
                              <span aria-hidden="true">&raquo;</span>
                              <span class="sr-only">Next</span>
                           </a>
                        </li>
                     </ul>
                  </nav>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>



@endsection
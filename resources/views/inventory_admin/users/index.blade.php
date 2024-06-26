@extends('app')
@section('content')

<div class="section">
   <x-sweetalert></x-sweetalert>

   <div class="section-header">
      <h1>Users</h1>
      <div class="section-header-button">
         <a href="{{ route('inventory_admin.users.create') }}" class="btn btn-primary">Tambah</a>
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
                  <h4>Data User</h4>
               </div>
               <div class="card-body">
                  <div class="float-right">
                     <div class="input-group">
                        <button type="button" class="btn btn-primary ml-3" data-toggle="modal" data-target="#exampleModal">Pencarian Lanjutan</button>
                        <form action="{{ route('inventory_admin.users.index') }}" method="GET" style="display:inline;">
                           <button type="submit" class="btn btn-secondary ml-3">Reset Pencarian</button>
                        </form>
                     </div>
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
                           <th>Aksi</th>
                        </tr>
                        @forelse ($data as $item)
                           <tr>
                              <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</td>
                              <td>
                                 <div class="d-flex align-items-center">
                                    @if ($item->photo)
                                       <img alt="image" src="{{ asset('storage/photos/user/' . $item->photo) }}" class="rounded-circle" style="object-fit: cover" width="35" height="35" data-toggle="title" title="">
                                    @else
                                       <img alt="image" src="{{ asset('assets/img/avatar/avatar-1.png') }}" class="rounded-circle" width="35" data-toggle="title" title="">
                                    @endif
                                     <div class="ml-3">
                                         <div>{{ $item->name }}</div>
                                         <div>
                                             <a href="mailto:{{ $item->email }}">{{ $item->email ?? '--' }}</a>
                                         </div>
                                     </div>
                                 </div>
                             </td>
                              <td>
                                 {{ $item->username }}
                              </td>
                              <td>
                                 <a href="{{ $item->division ? route('inventory_admin.divisions.edit', $item->division) : '#' }}">
                                    <div class="d-inline-block ml-1">{{ $item->division->name ?? '--' }}</div>
                                 </a>                                
                              </td>
                              <td>
                                 @php
                                    $role = strtolower($item->role->name);
                                    $badgeClass = '';
   
                                    switch ($role) {
                                       case 'admin inventori':
                                             $badgeClass = 'badge-warning';
                                             $icon = '<i class="fas fa-user-cog"></i>';
                                             break;
                                       case 'admin divisi':
                                             $badgeClass = 'badge-success';
                                             $icon = '<i class="fas fa-user"></i>';
                                             break;
                                       case 'wakil rektor 2':
                                             $badgeClass = 'badge-primary';
                                             $icon = '<i class="fas fa-user-graduate"></i>';
                                             break;
                                       default:
                                             $badgeClass = 'badge-secondary';
                                             $icon = '<i class="fas fa-question-circle"></i>';
                                             break;
                                    }
                                 @endphp
   
                                 <div class="badge {{ $badgeClass }}">{!! $icon !!} {{ $item->role->name }}</div>
                              </td>
                              <td>
                                 <a href="{{ route('inventory_admin.users.edit', [$item]) }}" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                 <form class="d-inline" action="{{ route('inventory_admin.users.destroy', $item) }}" method="post" id="delete-data-{{ $item->id }}">
                                    @method('delete')
                                    @csrf
                                    <button type="button" class="btn btn-danger btn-action" onclick="showDeleteConfirmation('Ya, Hapus', 'Apakah anda yakin ingin menghapus pengguna ini?', 'delete-data-{{ $item->id }}')" data-toggle="tooltip" title="Hapus"><i class="fas fa-trash"></i></button>
                                 </form>
                               </td>
                           </tr>
                        @empty
                            <tr>
                              <td colspan="100" class="text-center">Data tidak tersedia <i class="far fa-sad-tear"></i></td>
                            </tr>
                        @endforelse
                     </table>
                  </div>
                  <x-pagination :data="$data"></x-pagination>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

@include('inventory_admin.users.modal')
@endsection
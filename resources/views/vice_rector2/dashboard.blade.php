@extends('app')
@section('content')
    <div class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>
        <div class="row">
            <div class="col-12 mb-4">
                <div class="hero text-white hero-bg-image" style="background-image: url('assets/img/me/gedung-upu.jpg');">
                    <div class="hero-inner">
                        <h2>Selamat Datang, {{ Auth::user()->name }}!</h2>
                        <p class="lead">Anda sekarang berada di dashboard inventori Universitas Potensi Utama.</p>
                        <div class="mt-4">
                            <a href="{{ route('division_admin.inventoryitems.index') }}"
                                class="btn btn-outline-white btn-lg btn-icon icon-left" data-toggle="modal"
                                data-target="#infoModal">
                                <i class="fas fa-info-circle"></i> Informasi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12">
                <div class="card">
                  <div class="card-header">
                     <h4>Data Permintaan Barang</h4>
                  </div>
                  <div class="card-body">
                     <div class="clearfix mb-3"></div>

                     <div class="table-responsive">
                           <table class="table table-striped">
                              <tr>
                                 <th>No</th>
                                 <th>Unit Divisi</th>
                                 <th>Tanggal Permintaan</th>
                                 <th>Jumlah</th>
                                 <th>Aksi</th>
                              </tr>
                              @forelse ($data as $item)
                                 <tr>
                                       <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</td>
                                       <td>
                                          {{ $item->division->name }}
                                       </td>
                                       <td>
                                          <div class="d-flex align-items-center">
                                             <div>
                                                   <div>{{ \Carbon\Carbon::parse($item->date)->isoFormat('DD MMMM YYYY') }}
                                                   </div>
                                             </div>
                                          </div>
                                       </td>
                                       <td>{{ $item->count ?? '--' }}</td>
                                       <td>
                                          <a href="{{ route('vice_rector2.divisionrequests.detail', ['date' => $item->date, 'division' => $item->division_id]) }}"
                                             class="btn btn-primary btn-action mr-1" data-toggle="tooltip"
                                             title="Lihat Detail"><i class="fas fa-eye"></i> Detail Permintaan</a>
                                       </td>
                                 </tr>
                              @empty
                                 <tr>
                                       <td colspan="100" class="text-center">Data tidak tersedia <i
                                             class="far fa-sad-tear"></i></td>
                                 </tr>
                              @endforelse
                           </table>
                     </div>
                     <x-pagination :data="$data"></x-pagination>
                  </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
               <div class="card card-statistic-2">
                   <div class="card-stats">
                       <div class="card-stats-title">Jumlah Permintaan Barang</div>
                       <div class="card-stats-items">
                           <div class="card-stats-item">
                               <div class="card-stats-item-count">{{ $itemRequestPending }}</div>
                               <div class="card-stats-item-label">Pending</div>
                           </div>
                           <div class="card-stats-item">
                               <div class="card-stats-item-count">{{ $itemRequestComplete }}</div>
                               <div class="card-stats-item-label">Disetujui</div>
                           </div>
                           <div class="card-stats-item">
                               <div class="card-stats-item-count">{{ $itemRequestReject }}</div>
                               <div class="card-stats-item-label">Ditolak</div>
                           </div>
                       </div>
                   </div>
                   <div class="card-icon shadow-info bg-info">
                       <i class="fas fa-archive"></i>
                   </div>
                   <div class="card-wrap">
                       <div class="card-header">
                           <h4>Total Permintaan</h4>
                       </div>
                       <div class="card-body">
                           {{ $itemRequestTotal }}
                       </div>
                   </div>
               </div>
           </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="infoModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Informasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Sebagai Wakil Rektor, Anda memiliki peran penting dalam mengkonfirmasi dan mengelola tindak lanjut
                        dari permintaan barang yang diajukan oleh unit divisi.</p>
                    <p>Mohon untuk memeriksa dan menindaklanjuti setiap permintaan barang dengan teliti untuk memastikan
                        kebutuhan inventori kampus terpenuhi dengan baik.</p>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

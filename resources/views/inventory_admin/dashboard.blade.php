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
                <p class="lead">Anda sekarang berada di dashboard inventori Universitas Potensi Utama. Cek laporan persediaan barang, kelola stok, dan atur permintaan barang dengan efisien.</p>
                <div class="mt-4">
                  <a href="{{ route('inventory_admin.inventoryitems.index') }}" class="btn btn-outline-white btn-lg btn-icon icon-left"><i class="fas fa-cubes"></i> Lihat Stok Barang</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Pengguna</h4>
                        </div>
                        <div class="card-body">
                            {{ $users }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Divisi</h4>
                        </div>
                        <div class="card-body">
                            {{ $divisions }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-info">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Barang Non Habis Pakai</h4>
                        </div>
                        <div class="card-body">
                            {{ $inventoryItemNonConsum }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-recycle"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Barang Habis Pakai</h4>
                        </div>
                        <div class="card-body">
                            {{ $inventoryItemConsum }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-stats">
                        <div class="card-stats-title">Permintaan Barang</div>
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
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-stats">
                        <div class="card-stats-title">Peminjaman Barang</div>
                        <div class="card-stats-items">
                            <div class="card-stats-item">
                                <div class="card-stats-item-count">{{ $divisionLoanBorrow }}</div>
                                <div class="card-stats-item-label">Dipinjam</div>
                            </div>
                            <div class="card-stats-item">
                              <div class="card-stats-item-count">{{ $divisionLoanReturn }}</div>
                              <div class="card-stats-item-label">Selesai</div>
                            </div>
                            <div class="card-stats-item">
                                <div class="card-stats-item-count">{{ $divisionLoanLate }}</div>
                                <div class="card-stats-item-label">Terlambat Mengembalikan</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Peminjaman</h4>
                        </div>
                        <div class="card-body">
                            {{ $divisionLoanTotal }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

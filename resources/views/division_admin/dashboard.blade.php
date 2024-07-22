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
                                <i class="fas fa-info-circle"></i> Tata Tertib
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12">
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
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-archive"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Permintaan Anda</h4>
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
                    <h5 class="modal-title">Tata Tertib Permintaan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>1. Unit Pelayanan menginput data permintaan barang di form <a
                            href="{{ route('division_admin.divisionrequests.index') }}">permintaan Barang</a>.</p>
                    <p>2. Unit Pelayanan menunggu permintaan di konfirmasi oleh WR II dan admin inventori.</p>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

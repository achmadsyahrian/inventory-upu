<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        </ul>
    </form>
    <ul class="navbar-nav navbar-right">
        @if (Auth::user()->role_id == 2 || Auth::user()->role_id == 4)
            <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                    class="nav-link notification-toggle nav-link-lg {{ $pendingRequestsCount || $overdueBorrowedLoansCount ? 'beep' : '' }}"><i
                        class="far fa-bell"></i></a>
                <div class="dropdown-menu dropdown-list dropdown-menu-right">
                    <div class="dropdown-header">Pemberitahuan</div>
                    <div class=" dropdown-list-icons" style="height: 120%;">
                        @if ($pendingRequestsCount)
                            <a href="{{ route('inventory_admin.divisionrequests.index') }}" class="dropdown-item">
                                <div class="dropdown-item-icon bg-info text-white">
                                    <i class="fas fa-bell"></i>
                                </div>
                                <div class="dropdown-item-desc">
                                    Permintaan Barang
                                    <div class="time text-primary">{{ $pendingRequestsCount }} Menunggu Persetujuan
                                    </div>
                                </div>
                            </a>
                        @endif
                        @if (Auth::user()->role_id == 2 && $overdueBorrowedLoansCount)
                            <a href="{{ route('inventory_admin.divisionloans.index') }}" class="dropdown-item">
                                <div class="dropdown-item-icon bg-danger text-white">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <div class="dropdown-item-desc">
                                    Peminjaman Barang
                                    <div class="time text-primary">{{ $overdueBorrowedLoansCount }} Terlambat
                                        Dikembalikan</div>
                                </div>
                            </a>
                        @endif
                        @if (!$pendingRequestsCount && !$overdueBorrowedLoansCount)
                            <div class="dropdown-footer text-center">
                                <a class="text-primary">Tidak ada Pemberitahuan <i class="far fa-sad-tear"></i></a>
                            </div>
                        @endif
                    </div>
                </div>
            </li>
        @endif
        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                @if (Auth::user()->photo)
                    <img alt="image" src="{{ asset('storage/photos/user/' . Auth::user()->photo) }}"
                        style="width:30px; height:30px; object-fit:cover;" class="rounded-circle mr-1">
                @else
                    <img alt="image" src="{{ asset('assets/img/avatar/avatar-1.png') }}" class="rounded-circle mr-1">
                @endif
                <div class="d-sm-none d-lg-inline-block">Hi, {{ Auth::user()->name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">{{ Auth::user()->role->name }}</div>
                <a href="{{ route('profile') }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>
                <div class="dropdown-divider"></div>
                <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

                <a class="dropdown-item has-icon text-danger" href="#"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </li>
    </ul>
</nav>

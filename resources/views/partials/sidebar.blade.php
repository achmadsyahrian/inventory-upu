<div class="main-sidebar sidebar-style-2">
   <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
         <a href="/"><img src="{{ asset('assets/img/me/Logopotensiutama.png') }}" width="30" alt=""> Inventory UPU</a>
      </div>
      <div class="sidebar-brand sidebar-brand-sm">
         <a href="/">
            <img src="{{ asset('assets/img/me/Logopotensiutama.png') }}" width="30" alt="">
         </a>
      </div>
      <ul class="sidebar-menu">
         <li class="menu-header">Dashboard</li>
         <li class="{{ Request::is('/') ? 'active' : '' }}"><a class="nav-link" href="/"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a></li>

         @if (Auth::user()->role_id == 1)

         <li class="menu-header">Manajemen</li>
         <li class="{{ Request::is('*users*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('administrator.users.index') }}"><i class="fas fa-user"></i> <span>Pengguna</span></a></li>
         <li class="{{ Request::is('*buildings*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('administrator.buildings.index') }}"><i class="fas fa-map-marked-alt"></i> <span>Lokasi Bangunan</span></a></li>
         <li class="{{ Request::is('*divisions*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('administrator.divisions.index') }}"><i class="fas fa-building"></i> <span>Divisi</span></a></li>
         <li><a class="nav-link" href="/"><i class="fas fa-cubes"></i> <span>Barang</span></a></li>

         @elseif (Auth::user()->role_id == 2)

         <li class="menu-header">Manajemen</li>
         <li class="{{ Request::is('*users*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('inventory_admin.users.index') }}"><i class="fas fa-user"></i> <span>Pengguna</span></a></li>
         <li class="{{ Request::is('*divisions*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('inventory_admin.divisions.index') }}"><i class="fas fa-building"></i> <span>Divisi</span></a></li>

         <li class="menu-header">Inventaris</li>
         <li class="dropdown {{ Request::is('*inventory-items*', '*item-entries*') ? 'active' : '' }}">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-cubes"></i> <span>Inventaris</span></a>
            <ul class="dropdown-menu">
               <li class="{{ Request::is('*inventory-items*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('inventory_admin.inventoryitems.index') }}">Stok Barang</a></li>
               <li class="{{ Request::is('*item-entries*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('inventory_admin.itementries.index') }}">Pemasukan Barang</a></li>
            </ul>
         </li>
         <li class="{{ Request::is('*item-request*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('inventory_admin.divisionrequests.index') }}"><i class="fas fa-clipboard-list"></i> <span>Permintaan Barang</span></a></li>
         <li class="{{ Request::is('*item-loans*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('inventory_admin.divisionloans.index') }}"><i class="fas fa-handshake"></i> <span>Peminjaman Barang</span></a></li>

         <li class="menu-header">Divisi</li>
         <li class="{{ Request::is('*division-items*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('inventory_admin.divisionitems.index') }}"><i class="fas fa-cube"></i> <span>Barang Divisi</span></a></li>

         @elseif (Auth::user()->role_id == 3)
            <li class="menu-header">Inventaris</li>
            <li class="{{ Request::is('*inventory-items*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('division_admin.inventoryitems.index') }}"><i class="fas fa-cubes"></i> <span>Stok Barang</span></a></li>
            <li class="{{ Request::is('*item-request*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('division_admin.divisionrequests.index') }}"><i class="fas fa-clipboard-list"></i> <span>Permintaan Barang</span></a></li>
         @elseif (Auth::user()->role_id == 4)
            <li class="menu-header">Inventaris</li>
            {{-- <li class="{{ Request::is('*inventory-items*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('division_admin.inventoryitems.index') }}"><i class="fas fa-cubes"></i> <span>Stok Barang</span></a></li> --}}
            <li class="{{ Request::is('*item-request*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('vice_rector2.divisionrequests.index') }}"><i class="fas fa-clipboard-list"></i> <span>Permintaan Barang</span></a></li>
         @endif
      </ul>

      <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
         <a href="https://potensi-utama.ac.id/" target="_blank" class="btn btn-primary btn-lg btn-block btn-icon-split">
            <i class="fab fa-instagram"></i> Potensi Utama
         </a>
      </div>
   </aside>
</div>

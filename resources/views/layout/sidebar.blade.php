 <!-- Sidebar -->
 <div class="sidebar" data-background-color="dark">
     <div class="sidebar-logo">
         <!-- Logo Header -->
         <div class="logo-header" data-background-color="dark">
             <a href="index.html" class="logo">
                 <img src="{{ asset('assets/img/logo_edit.png') }}" alt="navbar brand" class="navbar-brand"
                     height="50" />
             </a>

             <div class="nav-toggle">
                 <button class="btn btn-toggle toggle-sidebar">
                     <i class="gg-menu-right"></i>
                 </button>
                 <button class="btn btn-toggle sidenav-toggler">
                     <i class="gg-menu-left"></i>
                 </button>
             </div>
             <button class="topbar-toggler more">
                 <i class="gg-more-vertical-alt"></i>
             </button>
         </div>
         <!-- End Logo Header -->
     </div>

     <div class="sidebar-wrapper scrollbar scrollbar-inner">
         <div class="sidebar-content">
             <ul class="nav nav-secondary">
                 <li class="nav-item active">
                     <a href="{{ route('dashboard') }}" class="collapsed" aria-expanded="false">
                         <i class="fas fa-home"></i>
                         <p>Dashboard</p>
                     </a>
                 </li>
                 <li class="nav-section">
                     <span class="sidebar-mini-icon">
                         <i class="fa fa-ellipsis-h"></i>
                     </span>
                     <h4 class="text-section">Surat Menyurat</h4>
                 </li>

                 <li
                     class="nav-item {{ request()->routeIs(['index.SuratMasuk', 'create.SuratMasuk', 'edit.SuratMasuk', 'index.SuratKeluar', 'create.SuratKeluar', 'edit.SuratKeluar']) ? 'active' : '' }}">
                     <a data-bs-toggle="collapse" href="#menuSurat"
                         class="{{ request()->routeIs(['index.SuratMasuk', 'create.SuratMasuk', 'edit.SuratMasuk', 'index.SuratKeluar', 'create.SuratKeluar', 'edit.SuratKeluar']) ? '' : 'collapsed' }}"
                         aria-expanded="{{ request()->routeIs(['index.SuratMasuk', 'create.SuratMasuk', 'edit.SuratMasuk', 'index.SuratKeluar', 'create.SuratKeluar', 'edit.SuratKeluar']) ? 'true' : 'false' }}">
                         <i class="fas fa-envelope"></i>
                         <p>Surat</p>
                         <span class="caret"></span>
                     </a>

                     <div class="collapse {{ request()->routeIs(['index.SuratMasuk', 'create.SuratMasuk', 'edit.SuratMasuk', 'index.SuratKeluar', 'create.SuratKeluar', 'edit.SuratKeluar']) ? 'show' : '' }}"
                         id="menuSurat">
                         <ul class="nav nav-collapse">
                             <li
                                 class="{{ request()->routeIs('index.SuratMasuk', 'create.SuratMasuk', 'edit.SuratMasuk') ? 'active' : '' }}">
                                 <a href="{{ route('index.SuratMasuk') }}">
                                     <span class="sub-item">Surat Masuk</span>
                                 </a>
                             </li>
                             <li
                                 class="{{ request()->routeIs('index.SuratKeluar', 'create.SuratKeluar', 'edit.SuratKeluar', 'edit.SuratKeluar') ? 'active' : '' }}">
                                 <a href="{{ route('index.SuratKeluar') }}">
                                     <span class="sub-item">Surat Keluar</span>
                                 </a>
                             </li>
                         </ul>
                     </div>

                 </li>

                 <li class="nav-item">
                     <a href="{{ route('index.DisposisiSuratMasuk') }}">
                         <i class="fas fa-sync"></i>
                         <p>Disposisi</p>
                     </a>
                 </li>

                 <li
                     class="nav-item {{ request()->routeIs(['index.AgendaSuratMasuk', 'index.EkspedisiSuratKeluar', 'index.ArsipDigital']) ? 'active' : '' }}">
                     <a data-bs-toggle="collapse" href="#base"
                         class="{{ request()->routeIs(['index.AgendaSuratMasuk', 'index.EkspedisiSuratKeluar', 'index.ArsipDigital']) ? '' : 'collapsed' }}"
                         aria-expanded="{{ request()->routeIs(['index.AgendaSuratMasuk', 'index.EkspedisiSuratKeluar', 'index.ArsipDigital']) ? 'true' : 'false' }}">
                         <i class="fas fa-layer-group"></i>
                         <p>Laporan</p>
                         <span class="caret"></span>
                     </a>
                     <div class="collapse {{ request()->routeIs(['index.AgendaSuratMasuk', 'index.EkspedisiSuratKeluar', 'index.ArsipDigital']) ? 'show' : '' }}"
                         id="base">
                         <ul class="nav nav-collapse">
                             <li class="{{ request()->routeIs('index.AgendaSuratMasuk') ? 'active' : '' }}">
                                 <a href="{{ route('index.AgendaSuratMasuk') }}">
                                     <span class="sub-item">Buku Agenda Surat Masuk</span>
                                 </a>
                             </li>
                             <li class="{{ request()->routeIs('index.EkspedisiSuratKeluar') ? 'active' : '' }}">
                                 <a href="{{ route('index.EkspedisiSuratKeluar') }}">
                                     <span class="sub-item">Buku Ekspedisi Surat Keluar</span>
                                 </a>
                             </li>

                         </ul>
                     </div>
                 </li>



                 <li class="nav-item">
                     <a href="{{ route('index.ArsipDigital') }}">
                         <i class="fa fa-archive"></i>
                         <p>Arsip Surat Digital</p>
                     </a>
                 </li>


                 @if (in_array(auth()->user()->role_id, [1, 2]))
                     <li class="nav-section">
                         <span class="sidebar-mini-icon">
                             <i class="fa fa-ellipsis-h"></i>
                         </span>
                         <h4 class="text-section">Manajemen Data</h4>
                     </li>

                     <li class="nav-item">
                         <a href="{{ route('index.User') }}">
                             <i class="fas fa-users"></i>
                             <p>User</p>
                         </a>
                     </li>

                     <li class="nav-item">
                         <a href="{{ route('index.Pegawai') }}">
                             <i class="fas fa-users"></i>
                             <p>Pegawai</p>
                         </a>
                     </li>

                     <li class="nav-item">
                         <a href="{{ route('index.Pangkat') }}">
                             <i class="fas fa-chart-line"></i>
                             <p>Pangkat/Gol</p>
                         </a>
                     </li>

                     <li class="nav-item">
                         <a href="{{ route('index.SifatSurat') }}">
                             <i class="far fa-envelope"></i>
                             <p>Sifat Surat</p>
                         </a>
                     </li>

                     <li class="nav-item">
                         <a href="{{ route('index.Instansi') }}">
                             <i class="fas fa-building"></i>
                             <p>Instansi</p>
                         </a>
                     </li>
                 @endif

                 <li class="nav-section">
                     <span class="sidebar-mini-icon">
                         <i class="fa fa-ellipsis-h"></i>
                     </span>
                     <h4 class="text-section">Logout</h4>
                 </li>

                 <li class="nav-item">
                     <a href="{{ route('logout') }}"
                         onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                         <i class="fas fa-sign-out-alt"></i>
                         <p>Keluar</p>
                     </a>

                     <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                         @csrf
                     </form>
                 </li>

             </ul>
         </div>
     </div>
 </div>
 <!-- End Sidebar -->

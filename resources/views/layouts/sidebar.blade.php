<!-- Sidebar -->
<!--
Sidebar Mini Mode - Display Helper classes

Adding 'smini-hide' class to an element will make it invisible (opacity: 0) when the sidebar is in mini mode
Adding 'smini-show' class to an element will make it visible (opacity: 1) when the sidebar is in mini mode
    If you would like to disable the transition animation, make sure to also add the 'no-transition' class to your element

Adding 'smini-hidden' to an element will hide it when the sidebar is in mini mode
Adding 'smini-visible' to an element will show it (display: inline-block) only when the sidebar is in mini mode
Adding 'smini-visible-block' to an element will show it (display: block) only when the sidebar is in mini mode
-->
<nav id="sidebar" aria-label="Main Navigation">
    <!-- Side Header -->
    <div class="bg-header-dark">
        <div class="content-header bg-white-5">
            <!-- Logo -->
            <a class="fw-semibold text-white tracking-wide" href="/">
                <span class="smini-visible">
                    USG<span class="opacity-75">aja</span>
                </span>
                <span class="smini-hidden">
                    USG<span class="opacity-75">aja</span>
                </span>
            </a>
            <!-- END Logo -->

            <!-- Options -->
            <div>
                <!-- Toggle Sidebar Style -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <!-- Class Toggle, functionality initialized in Helpers.dmToggleClass() -->
                <button type="button" class="btn btn-sm btn-alt-secondary" data-toggle="class-toggle"
                    data-target="#sidebar-style-toggler" data-class="fa-toggle-off fa-toggle-on"
                    onclick="Dashmix.layout('sidebar_style_toggle');Dashmix.layout('header_style_toggle');">
                    <i class="fa fa-toggle-off" id="sidebar-style-toggler"></i>
                </button>
                <!-- END Toggle Sidebar Style -->

                <!-- Dark Mode -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <button type="button" class="btn btn-sm btn-alt-secondary" data-toggle="class-toggle"
                    data-target="#dark-mode-toggler" data-class="far fa"
                    onclick="Dashmix.layout('dark_mode_toggle');">
                    <i class="far fa-moon" id="dark-mode-toggler"></i>
                </button>
                <!-- END Dark Mode -->

                <!-- Close Sidebar, Visible only on mobile screens -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <button type="button" class="btn btn-sm btn-alt-secondary d-lg-none" data-toggle="layout"
                    data-action="sidebar_close">
                    <i class="fa fa-times-circle"></i>
                </button>
                <!-- END Close Sidebar -->
            </div>
            <!-- END Options -->
        </div>
    </div>
    <!-- END Side Header -->

    <!-- Sidebar Scrolling -->
    <div class="js-sidebar-scroll">
        <!-- Side Navigation -->
        <div class="content-side content-side-full">
            <ul class="nav-main">
                <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('dashboard') ? ' active' : '' }}" href="/dashboard">
                        <i class="nav-main-link-icon fa fa-location-arrow"></i>
                        <span class="nav-main-link-name">Dashboard</span>
                        <span class="nav-main-link-badge badge rounded-pill bg-primary">5</span>
                    </a>
                </li>

                <li class="nav-main-heading">Pelayanan</li>
                <li class="nav-main-item{{ request()->is('pasien*') ? ' open' : '' }}">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                        aria-expanded="true" href="#">
                        <i class="nav-main-link-icon fa fa-user-injured"></i>
                        <span class="nav-main-link-name">Pasien</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('pasien/create') ? ' active' : '' }}"
                                href="{{ route('pasien.create') }}">
                                <span class="nav-main-link-name">Tambah Pasien Baru</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('pasien') ? ' active' : '' }}"
                                href="{{ route('pasien.index') }}">
                                <span class="nav-main-link-name">Data Pasien</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-main-item{{ request()->is('registrasi*') ? ' open' : '' }}">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                        aria-expanded="true" href="#">
                        <i class="nav-main-link-icon fa fa-book"></i>
                        <span class="nav-main-link-name">Registrasi</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('registrasi/create') ? ' active' : '' }}"
                                href="{{ route('registrasi.create') }}">
                                <span class="nav-main-link-name">Buat Registrasi Baru</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('registrasi') ? ' active' : '' }}"
                                href="{{ route('registrasi.index') }}">
                                <span class="nav-main-link-name">Data Registrasi</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-main-item{{ request()->is('pemeriksaan-*') ? ' open' : '' }}">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                        aria-expanded="true" href="#">
                        <i class="nav-main-link-icon fa fa-stethoscope"></i>
                        <span class="nav-main-link-name">Pemeriksaan</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('pemeriksaan-awal*') ? ' active' : '' }}"
                                href="{{ route('pemeriksaan-awal.index') }}">
                                <span class="nav-main-link-name">Pemeriksaan Awal</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('pemeriksaan-dokter*') ? ' active' : '' }}"
                                href="{{ route('pemeriksaan-dokter.index') }}">
                                <span class="nav-main-link-name">Pemeriksaan Dokter</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link {{ request()->is('kasir*') ? ' active' : '' }}" href="{{ route('kasir.index') }}">
                        <i class="nav-main-link-icon fa fa-cash-register"></i>
                        <span class="nav-main-link-name">Kasir</span>
                    </a>
                </li>
                <li class="nav-main-heading">Master Data</li>
                <li class="nav-main-item">
                    <a class="nav-main-link {{ request()->is('user*') ? ' active' : '' }}" href="{{ route('user.index') }}">
                        <i class="nav-main-link-icon fa fa-users"></i>
                        <span class="nav-main-link-name">Users</span>
                    </a>
                    <a class="nav-main-link {{ request()->is('gender*') ? ' active' : '' }}" href="{{ route('gender.index') }}">
                        <i class="nav-main-link-icon si si-symbol-female"></i>
                        <span class="nav-main-link-name">Gender</span>
                    </a>
                    <a class="nav-main-link {{ request()->is('role*') ? ' active' : '' }}" href="{{ route('role.index') }}">
                        <i class="nav-main-link-icon fa fa-user-gear"></i>
                        <span class="nav-main-link-name">Role</span>
                    </a>
                    <a class="nav-main-link {{ request()->is('room*') ? ' active' : '' }}"  href="{{ route('room.index') }}">
                        <i class="nav-main-link-icon fa fa-home"></i>
                        <span class="nav-main-link-name">Room</span>
                    </a>
                    <a class="nav-main-link {{ request()->is('agama*') ? ' active' : '' }}"  href="{{ route('agama.index') }}">
                        <i class="nav-main-link-icon fa fa-star-and-crescent"></i>
                        <span class="nav-main-link-name">Agama</span>
                    </a>
                    <a class="nav-main-link {{ request()->is('pendidikan*') ? ' active' : '' }}"  href="{{ route('pendidikan.index') }}">
                        <i class="nav-main-link-icon fa fa-school"></i>
                        <span class="nav-main-link-name">Pendidikan</span>
                    </a>
                    <a class="nav-main-link {{ request()->is('pekerjaan*') ? ' active' : '' }}"  href="{{ route('pekerjaan.index') }}">
                        <i class="nav-main-link-icon fa fa-briefcase"></i>
                        <span class="nav-main-link-name">Pekerjaan</span>
                    </a>
                    <a class="nav-main-link {{ request()->is('golongan-darah*') ? ' active' : '' }}"  href="{{ route('golongan-darah.index') }}">
                        <i class="nav-main-link-icon fa fa-droplet"></i>
                        <span class="nav-main-link-name">Golongan Darah</span>
                    </a>
                    <a class="nav-main-link {{ request()->is('hubungan-pasien*') ? ' active' : '' }}"  href="{{ route('hubungan-pasien.index') }}">
                        <i class="nav-main-link-icon fa fa-users-viewfinder"></i>
                        <span class="nav-main-link-name">Hubungan Pasien</span>
                    </a>
                </li>
                {{-- <li class="nav-main-heading">More</li>
                <li class="nav-main-item">
                    <a class="nav-main-link" href="/">
                        <i class="nav-main-link-icon fa fa-globe"></i>
                        <span class="nav-main-link-name">Landing</span>
                    </a>
                </li> --}}
            </ul>
        </div>
        <!-- END Side Navigation -->
    </div>
    <!-- END Sidebar Scrolling -->
</nav>
<!-- END Sidebar -->

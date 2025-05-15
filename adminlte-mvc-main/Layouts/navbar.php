<?php
// Tidak ada spasi kosong sebelum tag pembuka PHP
session_start();

// Kode navbar Anda
?>
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Navbar content -->
</nav>


<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="index3.html" class="nav-link">Home</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
    <a class="nav-link" href="#" role="button" id="navbarSearchToggle">
    </a>
</li>
<li class="nav-item d-none d-md-block" id="navbarSearchFormWrapper" style="width: 250px;">
    <form class="form-inline ml-2" method="get" action="search.php">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" name="q" placeholder="Cari..." aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-navbar bg-primary text-white" type="submit">
                    <i class="fas fa-search"></i>
                </button>
                
            </div>
        </div>
    </form>
</li>

   
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">15</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">15 Notifications</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i> 4 new messages
                    <span class="float-right text-muted text-sm">3 mins</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-users mr-2"></i> 8 friend requests
                    <span class="float-right text-muted text-sm">12 hours</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-file mr-2"></i> 3 new reports
                    <span class="float-right text-muted text-sm">2 days</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="dist/img/AdminLTELogo.png" alt="tiyah Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="../adminlte-mvc-main/dist/img/sy.jpeg" class="img-circle elevation-2" >
            </div>
            <div class="info">
                <a href="#" class="d-block">Fathiyah Selena Az Zahra</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-header">NAVIGASI UTAMA</li>

                <li class="nav-item">
                    <a href="../adminlte-mvc-main/views/home2.php" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Home</p>
                    </a>
                </li>

                 <li class="nav-item">
                    <a href="index.php" class="nav-link">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>To Do List</p>
                    </a>
                </li>
               
                <li class="nav-header">DATA DOSEN</li>

                <li class="nav-item">
                    <a href="../adminlte-mvc-main/views/prodi.php" class="nav-link">
                        <i class="nav-icon fas fa-university"></i>
                        <p>Prodi</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="../adminlte-mvc-main/views/dosen.php" class="nav-link">
                        <i class="nav-icon fas fa-chalkboard-teacher"></i>
                        <p>Dosen</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="../adminlte-mvc-main/views/bidang_ilmu.php" class="nav-link">
                        <i class="nav-icon fas fa-flask"></i>
                        <p>Bidang Ilmu</p>
                    </a>
                </li>

                <li class="nav-header">KEGIATAN</li>

                <li class="nav-item">
                    <a href="../adminlte-mvc-main/views/jenis_kegiatan.php" class="nav-link">
                        <i class="nav-icon fas fa-layer-group"></i>
                        <p>Jenis Kegiatan</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="../adminlte-mvc-main/views/kegiatan.php" class="nav-link">
                        <i class="nav-icon fas fa-calendar-check"></i>
                        <p>Kegiatan</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="../adminlte-mvc-main/views/dosen_kegiatan.php" class="nav-link">
                        <i class="nav-icon fas fa-user-friends"></i>
                        <p>Dosen Kegiatan</p>
                    </a>
                </li>

                <li class="nav-header">PENELITIAN</li>
                <li class="nav-item">
                    <a href="../adminlte-mvc-main/views/penelitian.php" class="nav-link">
                        <i class="nav-icon fas fa-book-open"></i>
                        <p>Penelitian</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="?url=tim_penelitian" class="nav-link">
                        <i class="nav-icon fas fa-people-arrows"></i>
                        <p>Tim Penelitian</p>
                    </a>
                </li>

                <li class="nav-header">LAINNYA</li>

                <li class="nav-item">
                    <a href="?url=logout" class="nav-link text-danger">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>

            </ul>
        </nav>

        

</aside>
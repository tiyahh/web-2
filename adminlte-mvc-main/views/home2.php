<?php
if (file_exists('config.php')) {
    require_once 'config.php';
} else {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbkegiatan_dosen";
}

$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$result = $conn->query("SHOW DATABASES LIKE '$dbname'");
if ($result->num_rows == 0) {
    $conn->query("CREATE DATABASE $dbname");
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Informasi Kegiatan Dosen</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
            padding-top: 40px;
        }
        .section-title {
            font-weight: bold;
            margin-bottom: 1rem;
        }
        .card-custom {
            transition: all 0.3s;
            border: none;
            border-radius: 1rem;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }
        .card-custom:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }
        .card-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            color: #0d6efd;
        }
        .category-label {
            font-size: 0.9rem;
            color: #6c757d;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="text-center mb-5">
        <h1 style="font-weight: bold;">HOME</h1>
        <p class="text-muted">Manajemen data dosen, kegiatan, penelitian, dan bidang ilmu dosen</p>
    </div>

    <!-- Data dosen -->
    <div class="mb-5">
        <h4 class="section-title">📚 Data Dosen</h4>
        <div class="row g-4">
            <div class="col-md-3">
                <a href="prodi.php" class="text-decoration-none text-dark">
                    <div class="card card-custom text-center p-3">
                        <div class="card-icon"><i class="bi bi-journal-bookmark-fill"></i></div>
                        <div class="fw-bold">Program Studi</div>
                        <div class="category-label">Kelola program studi</div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="dosen.php" class="text-decoration-none text-dark">
                    <div class="card card-custom text-center p-3">
                        <div class="card-icon"><i class="bi bi-person-lines-fill"></i></div>
                        <div class="fw-bold">Dosen</div>
                        <div class="category-label">Kelola data dosen</div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="bidang_ilmu.php" class="text-decoration-none text-dark">
                    <div class="card card-custom text-center p-3">
                        <div class="card-icon"><i class="bi bi-diagram-3-fill"></i></div>
                        <div class="fw-bold">Bidang Ilmu</div>
                        <div class="category-label">Kelola bidang ilmu</div>
                    </div>
                </a>
            </div>
            
        </div>
    </div>

      <!-- kegiatan -->
    <div class="mb-5">
        <h4 class="section-title">📈 Kegiatan</h4>
        <div class="row g-4">
            <div class="col-md-4">
                <a href="laporan_kegiatan.php" class="text-decoration-none text-dark">
                    <div class="card card-custom text-center p-3">
                        <div class="card-icon"><i class="bi bi-bar-chart-line-fill"></i></div>
                        <div class="fw-bold">Jenis Kegiatan</div>
                        <div class="category-label">Lihat jenis kegiatan</div>
                    </div>
                </a>
            </div>
             <div class="col-md-3">
                <a href="kegiatan.php" class="text-decoration-none text-dark">
                    <div class="card card-custom text-center p-3">
                        <div class="card-icon"><i class="bi bi-calendar-event-fill"></i></div>
                        <div class="fw-bold">Kegiatan</div>
                        <div class="category-label">Kelola kegiatan dosen</div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="#" class="text-decoration-none text-dark">
                    <div class="card card-custom text-center p-3">
                        <div class="card-icon"><i class="bi bi-layers-fill"></i></div>
                        <div class="fw-bold">Dosen Kegiatan</div>
                        <div class="category-label">Lihat dosen kegiatan</div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- penelitian -->
    <div class="mb-5">
        <h4 class="section-title">📋 Penelitian</h4>
        <div class="row g-4">
          
             <div class="col-md-4">
                <a href="laporan_penelitian.php" class="text-decoration-none text-dark">
                    <div class="card card-custom text-center p-3">
                        <div class="card-icon"><i class="bi bi-journal-text"></i></div>
                        <div class="fw-bold">Penelitian</div>
                        <div class="category-label">Kelola data penelitian</div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="penelitian.php" class="text-decoration-none text-dark">
                    <div class="card card-custom text-center p-3">
                        <div class="card-icon"><i class="bi bi-search"></i></div>
                        <div class="fw-bold">Tim Penelitian</div>
                        <div class="category-label">Lihat tim penelitian</div>
                    </div>
                </a>
            </div>
        </div>
    </div>

  
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

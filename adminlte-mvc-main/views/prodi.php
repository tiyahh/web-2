<?php
// Konfigurasi koneksi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbkegiatan_dosen";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Fungsi untuk membersihkan input
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Fungsi untuk menampilkan pesan alert dan redirect
function alert_redirect($message, $location) {
    echo "<script>
            alert('$message');
            window.location.href='$location';
          </script>";
}

// Inisialisasi variabel untuk form
$id = "";
$kode = $nama = $alamat = $telpon = $ketua = "";
$edit_mode = false;
$title = "Tambah Data Program Studi";
$button_text = "Simpan";

// Proses Edit: Ambil data dari database untuk form edit
if (isset($_GET['edit'])) {
    $edit_mode = true;
    $title = "Edit Data Program Studi";
    $button_text = "Update";
    
    $id = clean_input($_GET['edit']);
    $sql = "SELECT * FROM prodi WHERE id = '$id'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $kode = $row['kode'];
        $nama = $row['nama'];
        $alamat = $row['alamat'];
        $telpon = $row['telpon'];
        $ketua = $row['ketua'];
    } else {
        alert_redirect("Data tidak ditemukan!", "prodi.php");
    }
}

// Proses Hapus Data
if (isset($_GET['delete'])) {
    $id = clean_input($_GET['delete']);
    
    // Periksa apakah ada dosen yang terkait dengan prodi ini
    $check_dosen = "SELECT COUNT(*) as count FROM dosen WHERE prodi_id = '$id'";
    $result_check = $conn->query($check_dosen);
    $row_check = $result_check->fetch_assoc();
    
    if ($row_check['count'] > 0) {
        alert_redirect("Tidak dapat menghapus prodi karena masih ada dosen yang terkait!", "prodi.php");
    } else {
        $sql = "DELETE FROM prodi WHERE id = '$id'";
        if ($conn->query($sql) === TRUE) {
            alert_redirect("Data program studi berhasil dihapus", "prodi.php");
        } else {
            alert_redirect("Error: " . $sql . "<br>" . $conn->error, "prodi.php");
        }
    }
}

// Proses Form Submission (Create/Update)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kode = clean_input($_POST["kode"]);
    $nama = clean_input($_POST["nama"]);
    $alamat = clean_input($_POST["alamat"]);
    $telpon = clean_input($_POST["telpon"]);
    $ketua = clean_input($_POST["ketua"]);
    
    // Cek jika ini update atau tambah data baru
    if (isset($_POST["edit_mode"]) && $_POST["edit_mode"] == "true") {
        $id = clean_input($_POST["id"]);
        // Update data
        $sql = "UPDATE prodi SET 
                kode = '$kode',
                nama = '$nama', 
                alamat = '$alamat', 
                telpon = '$telpon', 
                ketua = '$ketua'
                WHERE id = '$id'";
        
        if ($conn->query($sql) === TRUE) {
            alert_redirect("Data program studi berhasil diupdate", "prodi.php");
        } else {
            alert_redirect("Error: " . $sql . "<br>" . $conn->error, "prodi.php");
        }
    } else {
        // Tambah data baru
        // Cek apakah Kode Prodi sudah ada
        $check = "SELECT * FROM prodi WHERE kode = '$kode'";
        $result = $conn->query($check);
        
        if ($result->num_rows > 0) {
            alert_redirect("Kode Prodi sudah terdaftar, silakan gunakan kode lain", "prodi.php");
        } else {
            $sql = "INSERT INTO prodi (kode, nama, alamat, telpon, ketua)
                    VALUES ('$kode', '$nama', '$alamat', '$telpon', '$ketua')";
            
            if ($conn->query($sql) === TRUE) {
                alert_redirect("Data program studi berhasil ditambahkan", "prodi.php");
            } else {
                alert_redirect("Error: " . $sql . "<br>" . $conn->error, "prodi.php");
            }
        }
    }
}

// Query untuk menampilkan data dosen untuk dropdown ketua prodi
$dosen_query = "SELECT nidn, nama FROM dosen ORDER BY nama ASC";
$dosen_result = $conn->query($dosen_query);

// Query untuk menampilkan data prodi
$sql = "SELECT * FROM prodi ORDER BY nama ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Program Studi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            padding-top: 20px;
            padding-bottom: 20px;
        }
        .container {
            max-width: 1200px;
        }
        .required {
            color: red;
        }
        .action-buttons {
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mb-4 text-center">Manajemen Program Studi</h2>
        
        <div class="row">
            <!-- Form Input/Edit -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0"><?= $title ?></h5>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <input type="hidden" name="edit_mode" value="<?= $edit_mode ? 'true' : 'false' ?>">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            
                            <div class="mb-3">
                                <label for="kode" class="form-label">Kode Prodi <span class="required">*</span></label>
                                <input type="text" class="form-control" id="kode" name="kode" value="<?= $kode ?>" <?= $edit_mode ? '' : '' ?> required maxlength="10">
                            </div>
                            
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Program Studi <span class="required">*</span></label>
                                <input type="text" class="form-control" id="nama" name="nama" value="<?= $nama ?>" required maxlength="100">
                            </div>
                            
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat" maxlength="100"><?= $alamat ?></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="telpon" class="form-label">Nomor Telepon</label>
                                <input type="text" class="form-control" id="telpon" name="telpon" value="<?= $telpon ?>" maxlength="20">
                            </div>
                            
                            <div class="mb-3">
                                <label for="ketua" class="form-label">Ketua Program Studi</label>
                                <input type="text" class="form-control" id="ketua" name="ketua" value="<?= $ketua ?>" maxlength="45">
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary"><?= $button_text ?></button>
                                <?php if ($edit_mode): ?>
                                    <a href="prodi.php" class="btn btn-secondary">Batal</a>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Tabel Data -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Data Program Studi</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Nama Program Studi</th>
                                        <th>Alamat</th>
                                        <th>Telepon</th>
                                        <th>Ketua</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        $no = 1;
                                        while($row = $result->fetch_assoc()) {
                                            echo "<tr>
                                                    <td>" . $no++ . "</td>
                                                    <td>" . $row["kode"] . "</td>
                                                    <td>" . $row["nama"] . "</td>
                                                    <td>" . ($row["alamat"] ? $row["alamat"] : '-') . "</td>
                                                    <td>" . ($row["telpon"] ? $row["telpon"] : '-') . "</td>
                                                    <td>" . ($row["ketua"] ? $row["ketua"] : '-') . "</td>
                                                    <td class='action-buttons'>
                                                        <a href='prodi.php?edit=" . $row["id"] . "' class='btn btn-warning btn-sm'>Edit</a>
                                                        <a href='prodi.php?delete=" . $row["id"] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>Hapus</a>
                                                    </td>
                                                </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='7' class='text-center'>Tidak ada data program studi</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Tutup koneksi database
$conn->close();
?>
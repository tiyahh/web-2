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
$nidn = $nama = $gelar_depan = $gelar_belakang = $jenis_kelamin = $tempat_lahir = "";
$tanggal_lahir = $alamat = $email = $tahun_masuk = $prodi_id = "";
$edit_mode = false;
$title = "Tambah Data Dosen";
$button_text = "Simpan";

// Proses Edit: Ambil data dari database untuk form edit
if (isset($_GET['edit'])) {
    $edit_mode = true;
    $title = "Edit Data Dosen";
    $button_text = "Update";
    
    $id = clean_input($_GET['edit']);
    $sql = "SELECT * FROM dosen WHERE id = '$id'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nidn = $row['nidn'];
        $nama = $row['nama'];
        $gelar_depan = $row['gelar_depan'];
        $gelar_belakang = $row['gelar_belakang'];
        $jenis_kelamin = $row['jenis_kelamin'];
        $tempat_lahir = $row['tempat_lahir'];
        $tanggal_lahir = $row['tanggal_lahir'];
        $alamat = $row['alamat'];
        $email = $row['email'];
        $tahun_masuk = $row['tahun_masuk'];
        $prodi_id = $row['prodi_id'];
    } else {
        alert_redirect("Data tidak ditemukan!", "dosen.php");
    }
}

// Proses Hapus Data
if (isset($_GET['delete'])) {
    $id = clean_input($_GET['delete']);
    
    $sql = "DELETE FROM dosen WHERE id = '$id'";
    if ($conn->query($sql) === TRUE) {
        alert_redirect("Data dosen berhasil dihapus", "dosen.php");
    } else {
        alert_redirect("Error: " . $sql . "<br>" . $conn->error, "dosen.php");
    }
}

// Proses Form Submission (Create/Update)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nidn = clean_input($_POST["nidn"]);
    $nama = clean_input($_POST["nama"]);
    $gelar_depan = clean_input($_POST["gelar_depan"]);
    $gelar_belakang = clean_input($_POST["gelar_belakang"]);
    $jenis_kelamin = clean_input($_POST["jenis_kelamin"]);
    $tempat_lahir = clean_input($_POST["tempat_lahir"]);
    $tanggal_lahir = !empty($_POST["tanggal_lahir"]) ? clean_input($_POST["tanggal_lahir"]) : null;
    $alamat = clean_input($_POST["alamat"]);
    $email = clean_input($_POST["email"]);
    $tahun_masuk = !empty($_POST["tahun_masuk"]) ? clean_input($_POST["tahun_masuk"]) : null;
    $prodi_id = !empty($_POST["prodi_id"]) ? clean_input($_POST["prodi_id"]) : null;
    
    // Cek jika ini update atau tambah data baru
    if (isset($_POST["edit_mode"]) && $_POST["edit_mode"] == "true") {
        $id = clean_input($_POST["id"]);
        // Update data
        $sql = "UPDATE dosen SET 
                nidn = '$nidn',
                nama = '$nama', 
                gelar_depan = '$gelar_depan',
                gelar_belakang = '$gelar_belakang',
                jenis_kelamin = '$jenis_kelamin', 
                tempat_lahir = '$tempat_lahir',
                tanggal_lahir = " . ($tanggal_lahir ? "'$tanggal_lahir'" : "NULL") . ",
                alamat = '$alamat', 
                email = '$email',
                tahun_masuk = " . ($tahun_masuk ? "'$tahun_masuk'" : "NULL") . ",
                prodi_id = " . ($prodi_id ? "'$prodi_id'" : "NULL") . "
                WHERE id = '$id'";
        
        if ($conn->query($sql) === TRUE) {
            alert_redirect("Data dosen berhasil diupdate", "dosen.php");
        } else {
            alert_redirect("Error: " . $sql . "<br>" . $conn->error, "dosen.php");
        }
    } else {
        // Tambah data baru
        // Cek apakah NIDN sudah ada
        $check = "SELECT * FROM dosen WHERE nidn = '$nidn'";
        $result = $conn->query($check);
        
        if ($result->num_rows > 0) {
            alert_redirect("NIDN sudah terdaftar, silakan gunakan NIDN lain", "dosen.php");
        } else {
            $sql = "INSERT INTO dosen (nidn, nama, gelar_depan, gelar_belakang, jenis_kelamin, tempat_lahir, tanggal_lahir, alamat, email, tahun_masuk, prodi_id)
                    VALUES ('$nidn', '$nama', '$gelar_depan', '$gelar_belakang', '$jenis_kelamin', '$tempat_lahir', " . 
                    ($tanggal_lahir ? "'$tanggal_lahir'" : "NULL") . ", '$alamat', '$email', " . 
                    ($tahun_masuk ? "'$tahun_masuk'" : "NULL") . ", " . 
                    ($prodi_id ? "'$prodi_id'" : "NULL") . ")";
            
            if ($conn->query($sql) === TRUE) {
                alert_redirect("Data dosen berhasil ditambahkan", "dosen.php");
            } else {
                alert_redirect("Error: " . $sql . "<br>" . $conn->error, "dosen.php");
            }
        }
    }
}

// Query untuk mendapatkan data prodi untuk dropdown
$prodi_query = "SELECT id, nama FROM prodi ORDER BY nama ASC";
$prodi_result = $conn->query($prodi_query);

// Query untuk menampilkan data dosen dengan join ke tabel prodi
$sql = "SELECT d.*, p.nama as nama_prodi 
        FROM dosen d 
        LEFT JOIN prodi p ON d.prodi_id = p.id 
        ORDER BY d.nama ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Data Dosen</title>
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
        /* Untuk tabel yang responsif dengan banyak kolom */
        .table {
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mb-4 text-center">Manajemen Data Dosen</h2>
        
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
                            <?php if ($edit_mode): ?>
                                <input type="hidden" name="id" value="<?= $_GET['edit'] ?>">
                            <?php endif; ?>
                            
                            <div class="mb-3">
                                <label for="nidn" class="form-label">NIDN <span class="required">*</span></label>
                                <input type="text" class="form-control" id="nidn" name="nidn" value="<?= $nidn ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama <span class="required">*</span></label>
                                <input type="text" class="form-control" id="nama" name="nama" value="<?= $nama ?>" required>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="gelar_depan" class="form-label">Gelar Depan</label>
                                    <input type="text" class="form-control" id="gelar_depan" name="gelar_depan" value="<?= $gelar_depan ?>">
                                </div>
                                <div class="col">
                                    <label for="gelar_belakang" class="form-label">Gelar Belakang</label>
                                    <input type="text" class="form-control" id="gelar_belakang" name="gelar_belakang" value="<?= $gelar_belakang ?>">
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="required">*</span></label>
                                <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="" <?= $jenis_kelamin == '' ? 'selected' : '' ?>>-- Pilih --</option>
                                    <option value="L" <?= $jenis_kelamin == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                    <option value="P" <?= $jenis_kelamin == 'P' ? 'selected' : '' ?>>Perempuan</option>
                                </select>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                    <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="<?= $tempat_lahir ?>">
                                </div>
                                <div class="col">
                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?= $tanggal_lahir ?>">
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3"><?= $alamat ?></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="required">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= $email ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="tahun_masuk" class="form-label">Tahun Masuk</label>
                                <input type="number" class="form-control" id="tahun_masuk" name="tahun_masuk" min="1900" max="<?= date('Y') ?>" value="<?= $tahun_masuk ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label for="prodi_id" class="form-label">Program Studi</label>
                                <select class="form-select" id="prodi_id" name="prodi_id">
                                    <option value="">-- Pilih Program Studi --</option>
                                    <?php
                                    if ($prodi_result && $prodi_result->num_rows > 0) {
                                        while($prodi = $prodi_result->fetch_assoc()) {
                                            $selected = ($prodi_id == $prodi["id"]) ? 'selected' : '';
                                            echo "<option value='" . $prodi["id"] . "' $selected>" . $prodi["nama"] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary"><?= $button_text ?></button>
                                <?php if ($edit_mode): ?>
                                    <a href="dosen.php" class="btn btn-secondary">Batal</a>
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
                        <h5 class="card-title mb-0">Data Dosen</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>NIDN</th>
                                        <th>Nama Lengkap</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Tempat, Tgl Lahir</th>
                                        <th>Alamat</th>
                                        <th>Email</th>
                                        <th>Tahun Masuk</th>
                                        <th>Program Studi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result && $result->num_rows > 0) {
                                        $no = 1;
                                        while($row = $result->fetch_assoc()) {
                                            // Format nama dengan gelar
                                            $nama_lengkap = ($row["gelar_depan"] ? $row["gelar_depan"] . ". " : "") . 
                                                           $row["nama"] . 
                                                           ($row["gelar_belakang"] ? ", " . $row["gelar_belakang"] : "");
                                            
                                            // Format tempat tanggal lahir
                                            $ttl = $row["tempat_lahir"];
                                            if (!empty($row["tanggal_lahir"]) && $row["tanggal_lahir"] != "0000-00-00") {
                                                $ttl .= !empty($ttl) ? ", " : "";
                                                $ttl .= date("d-m-Y", strtotime($row["tanggal_lahir"]));
                                            }
                                            
                                            echo "<tr>
                                                    <td>" . $no++ . "</td>
                                                    <td>" . $row["nidn"] . "</td>
                                                    <td>" . $nama_lengkap . "</td>
                                                    <td>" . ($row["jenis_kelamin"] == 'L' ? 'Laki-laki' : 'Perempuan') . "</td>
                                                    <td>" . ($ttl ? $ttl : '-') . "</td>
                                                    <td>" . ($row["alamat"] ? $row["alamat"] : '-') . "</td>
                                                    <td>" . $row["email"] . "</td>
                                                    <td>" . ($row["tahun_masuk"] ? $row["tahun_masuk"] : '-') . "</td>
                                                    <td>" . ($row["nama_prodi"] ? $row["nama_prodi"] : '-') . "</td>
                                                    <td class='action-buttons'>
                                                        <a href='dosen.php?edit=" . $row["id"] . "' class='btn btn-warning btn-sm'>Edit</a>
                                                        <a href='dosen.php?delete=" . $row["id"] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>Hapus</a>
                                                    </td>
                                                </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='10' class='text-center'>Tidak ada data dosen</td></tr>";
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
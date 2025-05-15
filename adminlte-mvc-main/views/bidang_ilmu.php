<?php
// Check if connection details file exists and include it
if (file_exists('config.php')) {
    require_once 'config.php';
} else {
    // Default connection details
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbkegiatan_dosen";
}

// Inisialisasi variabel
$id = $nama = $deskripsi = "";
$error = "";
$success = "";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Cek apakah tabel bidang_ilmu sudah ada, jika belum, buat tabel tersebut
$checkTable = $conn->query("SHOW TABLES LIKE 'bidang_ilmu'");
if ($checkTable->num_rows == 0) {
    // Tabel belum ada, buat tabel
    $create_table_sql = "CREATE TABLE bidang_ilmu (
        id INT(11) PRIMARY KEY,
        nama VARCHAR(45) NOT NULL,
        deskripsi TEXT
    )";
    
    if ($conn->query($create_table_sql) === TRUE) {
        $success = "Tabel bidang_ilmu berhasil dibuat";
    } else {
        $error = "Error membuat tabel: " . $conn->error;
    }
}

// Proses Hapus - Pindahkan ini ke atas sebelum header output
if (isset($_GET['delete']) && !empty($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    
    // Cek jika tabel penelitian sudah ada
    $checkPenelitianTable = $conn->query("SHOW TABLES LIKE 'penelitian'");
    
    if ($checkPenelitianTable->num_rows > 0) {
        // Cek jika bidang ilmu digunakan di tabel penelitian
        $check_sql = "SELECT COUNT(*) as count FROM penelitian WHERE bidang_ilmu_id = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("i", $delete_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        $check_row = $check_result->fetch_assoc();
        
        if ($check_row['count'] > 0) {
            $error = "Tidak dapat menghapus karena bidang ilmu sedang digunakan di penelitian";
        } else {
            $sql = "DELETE FROM bidang_ilmu WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $delete_id);
            
            if ($stmt->execute()) {
                $success = "Data berhasil dihapus";
            } else {
                $error = "Error: " . $stmt->error;
            }
        }
    } else {
        // Jika tabel penelitian belum ada, langsung hapus data
        $sql = "DELETE FROM bidang_ilmu WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $delete_id);
        
        if ($stmt->execute()) {
            $success = "Data berhasil dihapus";
        } else {
            $error = "Error: " . $stmt->error;
        }
    }
    
    // Gunakan JavaScript redirect daripada header() untuk menghindari "Headers already sent" error
    echo "<script>window.location.href='bidang_ilmu.php';</script>";
    exit();
}

// Proses Edit - Pindahkan ke sebelum output HTML
if (isset($_GET['edit']) && !empty($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $sql = "SELECT * FROM bidang_ilmu WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $edit_id);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $id = $row['id'];
            $nama = $row['nama'];
            $deskripsi = $row['deskripsi'];
        } else {
            $error = "Data tidak ditemukan";
        }
    } else {
        $error = "Error mengambil data: " . $stmt->error;
    }
}

// Jika form disubmit untuk menambah/mengupdate data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Mengambil nilai dari form
    $id = isset($_POST['id']) ? $_POST['id'] : "";
    $nama = isset($_POST['nama']) ? $_POST['nama'] : "";
    $deskripsi = isset($_POST['deskripsi']) ? $_POST['deskripsi'] : "";
    
    // Validasi data
    if (empty($nama)) {
        $error = "Nama bidang ilmu wajib diisi";
    } else {
        // Cek jika id sudah ada, update data jika ada
        if (!empty($id)) {
            $sql = "UPDATE bidang_ilmu SET nama=?, deskripsi=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $nama, $deskripsi, $id);
            
            if ($stmt->execute()) {
                $success = "Data berhasil diperbarui";
                // Reset form setelah update berhasil
                $id = $nama = $deskripsi = "";
                // Redirect untuk refresh halaman
                echo "<script>window.location.href='bidang_ilmu.php';</script>";
                exit();
            } else {
                $error = "Error: " . $stmt->error;
            }
        } else {
            // Jika id kosong, tambahkan data baru
            // Dapatkan ID tertinggi dan tambahkan 1 untuk ID baru
            $result = $conn->query("SELECT MAX(id) as max_id FROM bidang_ilmu");
            if ($result) {
                $row = $result->fetch_assoc();
                $new_id = ($row['max_id'] ?? 0) + 1;
                
                $sql = "INSERT INTO bidang_ilmu (id, nama, deskripsi) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iss", $new_id, $nama, $deskripsi);
                
                if ($stmt->execute()) {
                    $success = "Data berhasil ditambahkan";
                    // Reset form setelah insert berhasil
                    $id = $nama = $deskripsi = "";
                } else {
                    $error = "Error: " . $stmt->error;
                }
            } else {
                $error = "Error mengambil max ID: " . $conn->error;
            }
        }
    }
}

// Mengambil semua data bidang ilmu
$sql = "SELECT * FROM bidang_ilmu ORDER BY nama";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Bidang Ilmu</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            padding: 20px;
        }
        .container {
            max-width: 1000px;
        }
        h2 {
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        table {
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Manajemen Bidang Ilmu</h2>
        
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <form method="post" action="">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            
            <div class="form-group">
                <label for="nama">Nama Bidang Ilmu:</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($nama); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="deskripsi">Deskripsi:</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"><?php echo htmlspecialchars($deskripsi); ?></textarea>
            </div>
            
            <button type="submit" name="submit" class="btn btn-primary">
                <?php echo empty($id) ? "Tambah" : "Update"; ?> Bidang Ilmu
            </button>
            
            <?php if (!empty($id)): ?>
                <a href="bidangi_lmu.php" class="btn btn-secondary">Batal</a>
            <?php endif; ?>
        </form>
        
        <table class="table table-bordered table-hover mt-4">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nama Bidang Ilmu</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row["id"]; ?></td>
                        <td><?php echo htmlspecialchars($row["nama"]); ?></td>
                        <td><?php echo htmlspecialchars($row["deskripsi"]); ?></td>
                        <td>
                            <a href="bidang_ilmu.php?edit=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="bidang_ilmu.php?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada data yang tersedia</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        
        <div class="mt-4">
            <a href="index.php" class="btn btn-secondary">Kembali ke Menu Utama</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Script JS tidak diperlukan lagi karena konfirmasi sudah langsung pada atribut onclick -->
</body>
</html>

<?php
// Menutup koneksi
$conn->close();
?>
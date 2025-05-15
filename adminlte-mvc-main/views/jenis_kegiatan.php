<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "dbkegiatan_dosen";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$success = '';
$error = '';
$editMode = false;
$formData = ['id' => '', 'nama' => ''];

// Simpan data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : null;
    $nama = trim($_POST['nama']);

    if ($nama === '') {
        $error = "Nama tidak boleh kosong.";
    } else {
        if ($id) {
            $stmt = $conn->prepare("UPDATE jenis_kegiatan SET nama=? WHERE id=?");
            $stmt->bind_param("si", $nama, $id);
            $stmt->execute();
            $success = "Data berhasil diperbarui.";
        } else {
            $stmt = $conn->prepare("INSERT INTO jenis_kegiatan (nama) VALUES (?)");
            $stmt->bind_param("s", $nama);
            $stmt->execute();
            $success = "Data berhasil ditambahkan.";
        }
    }
}

// Hapus data
if (isset($_GET['hapus'])) {
    $hapus_id = intval($_GET['hapus']);
    $conn->query("DELETE FROM jenis_kegiatan WHERE id = $hapus_id");
    $success = "Data berhasil dihapus.";
}

// Ambil data untuk edit
if (isset($_GET['edit'])) {
    $editMode = true;
    $edit_id = intval($_GET['edit']);
    $result = $conn->query("SELECT * FROM jenis_kegiatan WHERE id = $edit_id");
    if ($result && $result->num_rows > 0) {
        $formData = $result->fetch_assoc();
    } else {
        $error = "Data tidak ditemukan.";
    }
}

// Ambil semua data
$jenis = $conn->query("SELECT * FROM jenis_kegiatan ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Jenis Kegiatan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h3 class="mb-4">Jenis Kegiatan</h3>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <!-- Form Tambah/Edit -->
    <div class="card mb-4">
        <div class="card-header"><?= $editMode ? "Edit Jenis" : "Tambah Jenis" ?></div>
        <div class="card-body">
            <form method="POST">
                <input type="hidden" name="id" value="<?= htmlspecialchars($formData['id']) ?>">
                <div class="form-group">
                    <label>Nama Jenis Kegiatan</label>
                    <input type="text" name="nama" class="form-control" required value="<?= htmlspecialchars($formData['nama']) ?>">
                </div>
                <button type="submit" class="btn btn-success"><?= $editMode ? "Update" : "Simpan" ?></button>
                <?php if ($editMode): ?>
                    <a href="jenis_kegiatan.php" class="btn btn-secondary">Batal</a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <!-- Tabel Jenis Kegiatan -->
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>No</th>
                <th>Nama Jenis</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($jenis->num_rows > 0): 
            $no = 1;
            while($row = $jenis->fetch_assoc()): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td>
                    <a href="?edit=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Hapus data ini?')" class="btn btn-danger btn-sm">Hapus</a>
                </td>
            </tr>
        <?php endwhile; else: ?>
            <tr><td colspan="3" class="text-center">Belum ada data</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>

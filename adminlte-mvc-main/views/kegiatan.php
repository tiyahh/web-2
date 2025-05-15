<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "dbkegiatan_dosen";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil jenis_kegiatan untuk dropdown
$jenis_result = $conn->query("SELECT id, nama FROM jenis_kegiatan");

// Handle form simpan (tambah/edit)
$success = '';
$error = '';
$editMode = false;
$formData = [
    'id' => '',
    'tanggal_mulai' => '',
    'tanggal_selesai' => '',
    'tempat' => '',
    'deskripsi' => '',
    'jenis_kegiatan_id' => ''
];

// Simpan data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : null;
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    $tempat = $_POST['tempat'];
    $deskripsi = $_POST['deskripsi'];
    $jenis_kegiatan_id = $_POST['jenis_kegiatan_id'];

    if ($id) {
        // Update
        $stmt = $conn->prepare("UPDATE kegiatan SET tanggal_mulai=?, tanggal_selesai=?, tempat=?, deskripsi=?, jenis_kegiatan_id=? WHERE id=?");
        $stmt->bind_param("ssssii", $tanggal_mulai, $tanggal_selesai, $tempat, $deskripsi, $jenis_kegiatan_id, $id);
        $stmt->execute();
        $success = "Data berhasil diperbarui.";
    } else {
        // Insert
        $stmt = $conn->prepare("INSERT INTO kegiatan (tanggal_mulai, tanggal_selesai, tempat, deskripsi, jenis_kegiatan_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $tanggal_mulai, $tanggal_selesai, $tempat, $deskripsi, $jenis_kegiatan_id);
        $stmt->execute();
        $success = "Data berhasil ditambahkan.";
    }
    $stmt->close();
}

// Handle hapus
if (isset($_GET['hapus'])) {
    $hapus_id = intval($_GET['hapus']);
    $conn->query("DELETE FROM kegiatan WHERE id = $hapus_id");
    $success = "Data berhasil dihapus.";
}

// Handle edit (load data ke form)
if (isset($_GET['edit'])) {
    $editMode = true;
    $edit_id = intval($_GET['edit']);
    $edit = $conn->query("SELECT * FROM kegiatan WHERE id = $edit_id");
    if ($edit && $edit->num_rows > 0) {
        $formData = $edit->fetch_assoc();
    } else {
        $error = "Data tidak ditemukan.";
    }
}

// Ambil semua data kegiatan
$kegiatan = $conn->query("
    SELECT k.*, jk.nama AS jenis_kegiatan 
    FROM kegiatan k 
    LEFT JOIN jenis_kegiatan jk ON k.jenis_kegiatan_id = jk.id
    ORDER BY k.tanggal_mulai DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Data Kegiatan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h3 class="mb-4">Data Kegiatan Dosen</h3>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <!-- Form Tambah/Edit -->
    <div class="card mb-4">
        <div class="card-header"><?= $editMode ? "Edit Kegiatan" : "Tambah Kegiatan" ?></div>
        <div class="card-body">
            <form method="POST">
                <input type="hidden" name="id" value="<?= htmlspecialchars($formData['id']) ?>">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" class="form-control" required value="<?= $formData['tanggal_mulai'] ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" class="form-control" required value="<?= $formData['tanggal_selesai'] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label>Tempat</label>
                    <input type="text" name="tempat" class="form-control" required value="<?= htmlspecialchars($formData['tempat']) ?>">
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" required><?= htmlspecialchars($formData['deskripsi']) ?></textarea>
                </div>
                <div class="form-group">
                    <label>Jenis Kegiatan</label>
                    <select name="jenis_kegiatan_id" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <?php while($jk = $jenis_result->fetch_assoc()): ?>
                            <option value="<?= $jk['id'] ?>" <?= ($jk['id'] == $formData['jenis_kegiatan_id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($jk['nama']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-success"><?= $editMode ? "Update" : "Simpan" ?></button>
                <?php if ($editMode): ?>
                    <a href="kegiatan.php" class="btn btn-secondary">Batal</a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <!-- Tabel Data -->
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Tempat</th>
            <th>Deskripsi</th>
            <th>Jenis</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        <?php if ($kegiatan->num_rows > 0): 
            $no = 1;
            while($row = $kegiatan->fetch_assoc()): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['tanggal_mulai'] ?> s/d <?= $row['tanggal_selesai'] ?></td>
                <td><?= htmlspecialchars($row['tempat']) ?></td>
                <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                <td><?= htmlspecialchars($row['jenis_kegiatan']) ?></td>
                <td>
                    <a href="kegiatan.php?edit=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="kegiatan.php?hapus=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus?')" class="btn btn-danger btn-sm">Hapus</a>
                </td>
            </tr>
        <?php endwhile; else: ?>
            <tr><td colspan="6" class="text-center">Belum ada data.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>

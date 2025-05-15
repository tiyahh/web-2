<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "dbkegiatan_dosen";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

function clean_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Tambah relasi
if (isset($_POST['tambah'])) {
    $dosen_id = $_POST['dosen_id'];
    $kegiatan_id = $_POST['kegiatan_id'];
    $stmt = $conn->prepare("INSERT INTO dosen_kegiatan (dosen_id, kegiatan_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $dosen_id, $kegiatan_id);
    $stmt->execute();
    header("Location: dosen_kegiatan.php?success=Relasi berhasil ditambahkan");
    exit;
}

// Update relasi
if (isset($_POST['update'])) {
    $old_dosen_id = $_POST['old_dosen_id'];
    $old_kegiatan_id = $_POST['old_kegiatan_id'];
    $new_dosen_id = $_POST['dosen_id'];
    $new_kegiatan_id = $_POST['kegiatan_id'];
    $stmt = $conn->prepare("UPDATE dosen_kegiatan SET dosen_id = ?, kegiatan_id = ? WHERE dosen_id = ? AND kegiatan_id = ?");
    $stmt->bind_param("iiii", $new_dosen_id, $new_kegiatan_id, $old_dosen_id, $old_kegiatan_id);
    $stmt->execute();
    header("Location: dosen_kegiatan.php?success=Relasi berhasil diubah");
    exit;
}

// Hapus relasi
if (isset($_GET['hapus'])) {
    $dosen_id = $_GET['dosen_id'];
    $kegiatan_id = $_GET['kegiatan_id'];
    $stmt = $conn->prepare("DELETE FROM dosen_kegiatan WHERE dosen_id = ? AND kegiatan_id = ?");
    $stmt->bind_param("ii", $dosen_id, $kegiatan_id);
    $stmt->execute();
    header("Location: dosen_kegiatan.php?success=Relasi berhasil dihapus");
    exit;
}

// Ambil data untuk ditampilkan
$sql = "SELECT dk.*, d.nama AS nama_dosen, k.tempat AS nama_kegiatan, k.tanggal_mulai 
        FROM dosen_kegiatan dk
        JOIN dosen d ON dk.dosen_id = d.id
        JOIN kegiatan k ON dk.kegiatan_id = k.id";
$result = $conn->query($sql);

// Ambil data dosen dan kegiatan untuk dropdown
$dosen = $conn->query("SELECT id, nama FROM dosen");
$kegiatan = $conn->query("SELECT id, tempat FROM kegiatan");

// Mode edit
$isEdit = isset($_GET['edit']);
$editRow = null;

if ($isEdit) {
    $edit_dosen_id = $_GET['dosen_id'];
    $edit_kegiatan_id = $_GET['kegiatan_id'];
    $editQuery = $conn->prepare("SELECT * FROM dosen_kegiatan WHERE dosen_id = ? AND kegiatan_id = ?");
    $editQuery->bind_param("ii", $edit_dosen_id, $edit_kegiatan_id);
    $editQuery->execute();
    $editRow = $editQuery->get_result()->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Relasi Dosen - Kegiatan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h2 class="mb-4">Relasi Dosen - Kegiatan</h2>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
    <?php endif; ?>

    <!-- Form Tambah/Edit -->
    <div class="card mb-4">
        <div class="card-header"><?= $isEdit ? 'Edit' : 'Tambah' ?> Relasi</div>
        <div class="card-body">
            <form method="post">
                <div class="form-row">
                    <div class="col-md-5 mb-3">
                        <label>Dosen</label>
                        <select name="dosen_id" class="form-control" required>
                            <option value="">-- Pilih Dosen --</option>
                            <?php foreach ($dosen as $d): ?>
                                <option value="<?= $d['id'] ?>" <?= $isEdit && $editRow['dosen_id'] == $d['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($d['nama']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-5 mb-3">
                        <label>Kegiatan</label>
                        <select name="kegiatan_id" class="form-control" required>
                            <option value="">-- Pilih Kegiatan --</option>
                            <?php foreach ($kegiatan as $k): ?>
                                <option value="<?= $k['id'] ?>" <?= $isEdit && $editRow['kegiatan_id'] == $k['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($k['tempat']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <?php if ($isEdit): ?>
                            <input type="hidden" name="old_dosen_id" value="<?= $editRow['dosen_id'] ?>">
                            <input type="hidden" name="old_kegiatan_id" value="<?= $editRow['kegiatan_id'] ?>">
                            <button type="submit" name="update" class="btn btn-warning btn-block">Update</button>
                        <?php else: ?>
                            <button type="submit" name="tambah" class="btn btn-primary btn-block">Tambah</button>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Relasi -->
    <table class="table table-bordered bg-white">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Dosen</th>
                <th>Kegiatan</th>
                <th>Tanggal Mulai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): $no = 1; ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['nama_dosen']) ?></td>
                        <td><?= htmlspecialchars($row['nama_kegiatan']) ?></td>
                        <td><?= $row['tanggal_mulai'] ?></td>
                        <td>
                            <a href="dosen_kegiatan.php?edit=1&dosen_id=<?= $row['dosen_id'] ?>&kegiatan_id=<?= $row['kegiatan_id'] ?>" class="btn btn-sm btn-info">Edit</a>
                            <a href="dosen_kegiatan.php?hapus=1&dosen_id=<?= $row['dosen_id'] ?>&kegiatan_id=<?= $row['kegiatan_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus relasi ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5" class="text-center">Belum ada data</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>

<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "dbkegiatan_dosen";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Tambah data tim penelitian
if (isset($_POST['tambah'])) {
    $dosen_id = $_POST['dosen_id'];
    $penelitian_id = $_POST['penelitian_id'];
    $peran = $_POST['peran'];

    $stmt = $conn->prepare("INSERT INTO tim_penelitian (dosen_id, penelitian_id, peran) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $dosen_id, $penelitian_id, $peran);
    $stmt->execute();
    $stmt->close();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Hapus data tim
if (isset($_GET['hapus'])) {
    $dosen_id = $_GET['hapus_dosen'];
    $penelitian_id = $_GET['hapus_penelitian'];
    $stmt = $conn->prepare("DELETE FROM tim_penelitian WHERE dosen_id=? AND penelitian_id=?");
    $stmt->bind_param("ii", $dosen_id, $penelitian_id);
    $stmt->execute();
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Ambil data
$result = $conn->query("
    SELECT tp.*, d.nama AS nama_dosen, p.judul AS judul_penelitian
    FROM tim_penelitian tp
    JOIN dosen d ON tp.dosen_id = d.id
    JOIN penelitian p ON tp.penelitian_id = p.id
");

$dosen_result = $conn->query("SELECT * FROM dosen");
$penelitian_result = $conn->query("SELECT * FROM penelitian");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tim Penelitian</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body class="p-4">
    <div class="container">
        <h2 class="mb-4">Data Tim Penelitian</h2>

        <!-- Form tambah -->
        <form method="POST" class="mb-4">
            <div class="form-row">
                <div class="col">
                    <select name="dosen_id" class="form-control" required>
                        <option value="">Pilih Dosen</option>
                        <?php while ($d = $dosen_result->fetch_assoc()): ?>
                            <option value="<?= $d['id'] ?>"><?= $d['nama'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col">
                    <select name="penelitian_id" class="form-control" required>
                        <option value="">Pilih Penelitian</option>
                        <?php while ($p = $penelitian_result->fetch_assoc()): ?>
                            <option value="<?= $p['id'] ?>"><?= $p['judul'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col">
                    <input type="text" name="peran" class="form-control" placeholder="Peran" required>
                </div>
                <div class="col">
                    <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
                </div>
            </div>
        </form>

        <!-- Tabel -->
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Nama Dosen</th>
                    <th>Judul Penelitian</th>
                    <th>Peran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nama_dosen']) ?></td>
                        <td><?= htmlspecialchars($row['judul_penelitian']) ?></td>
                        <td><?= htmlspecialchars($row['peran']) ?></td>
                        <td>
                            <a href="?hapus_dosen=<?= $row['dosen_id'] ?>&hapus_penelitian=<?= $row['penelitian_id'] ?>"
                               onclick="return confirm('Yakin hapus data ini?')"
                               class="btn btn-sm btn-danger">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

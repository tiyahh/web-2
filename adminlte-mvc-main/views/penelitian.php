<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "dbkegiatan_dosen";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Tambah data
if (isset($_POST['tambah'])) {
    $judul = $_POST['judul'];
    $mulai = $_POST['mulai'];
    $akhir = $_POST['akhir'];
    $tahun_ajaran = $_POST['tahun_ajaran'];
    $bidang_ilmu_id = $_POST['bidang_ilmu_id'];

    $stmt = $conn->prepare("INSERT INTO penelitian (judul, mulai, akhir, tahun_ajaran, bidang_ilmu_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $judul, $mulai, $akhir, $tahun_ajaran, $bidang_ilmu_id);
    $stmt->execute();
    $stmt->close();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Hapus data
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $conn->query("DELETE FROM penelitian WHERE id=$id");
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Ambil data penelitian
$result = $conn->query("SELECT p.*, b.nama as bidang_ilmu FROM penelitian p 
                        LEFT JOIN bidang_ilmu b ON p.bidang_ilmu_id = b.id");

$bidang_result = $conn->query("SELECT * FROM bidang_ilmu");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Penelitian</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body class="p-4">
    <div class="container">
        <h2 class="mb-4">Data Penelitian</h2>

        <!-- Form tambah -->
        <form method="POST" class="mb-4">
            <div class="form-row">
                <div class="col">
                    <input type="text" name="judul" class="form-control" placeholder="Judul" required>
                </div>
                <div class="col">
                    <input type="date" name="mulai" class="form-control" required>
                </div>
                <div class="col">
                    <input type="date" name="akhir" class="form-control" required>
                </div>
                <div class="col">
                    <input type="text" name="tahun_ajaran" class="form-control" placeholder="Tahun Ajaran" required>
                </div>
                <div class="col">
                    <select name="bidang_ilmu_id" class="form-control" required>
                        <option value="">Pilih Bidang Ilmu</option>
                        <?php while ($b = $bidang_result->fetch_assoc()): ?>
                            <option value="<?= $b['id'] ?>"><?= $b['nama'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col">
                    <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
                </div>
            </div>
        </form>

        <!-- Tabel data -->
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Judul</th>
                    <th>Mulai</th>
                    <th>Akhir</th>
                    <th>Tahun Ajaran</th>
                    <th>Bidang Ilmu</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['judul']) ?></td>
                        <td><?= $row['mulai'] ?></td>
                        <td><?= $row['akhir'] ?></td>
                        <td><?= $row['tahun_ajaran'] ?></td>
                        <td><?= $row['bidang_ilmu'] ?></td>
                        <td>
                            <a href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus?')" class="btn btn-sm btn-danger">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

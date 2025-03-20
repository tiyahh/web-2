<?php
require_once("Controllesrs/Prodi.php");

if (isset($_GET['ID'])){
$id = $_GET['id'];

$data = $prodi->show($id);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Prodi</title>
</head>
<body>
    <h1>Detail Prodi</h1>
    <? if($data): ?>
    <p>Kode: <?=$data['kode']?></p>
    <p>Nama: <?=$data['nama']?></p>
    <p>Kaprodi: <?=$data['kaprodi']?></p>
    <?php else; ?>
    <p>Data Tidak Ditemukan</p>
    <?php endif; ?>
    <p><a href="?url=prodi">Kembali</a></p>
</body>
</html>

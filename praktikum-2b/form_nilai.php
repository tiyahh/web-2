<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>form nilai</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>
    <form action="nilai_mahasiswa.php" menthod="POST">

    
<form>
<form method="POST" action="total_belanja.php" class="container mt-5">
    <fieldset class="border border-dark p-3 rounded" style="background-color: pink;">
      <legend class="float-none w-auto px-3 fw-bold h3">Belanja</legend>

  <div class="form-group row">
    <label for="nama lengkap" class="col-2 col-form-label">Nama Lengkap</label> 
    <div class="col-8">
      <div class="input-group">
        <div class="input-group-prepend">
          <div class="input-group-text">
            <i class="fa fa-address-card"></i>
          </div>
        </div> 
        <input id="nama lengkap" name="nama lengkap" placeholder="Nama Lengkap" type="text" class="form-control" required="required">
      </div>
    </div>
  </div>
  <div class="form-group row">
    <label for="mata kuliah" class="col-2 col-form-label">Mata Kuliah</label> 
    <div class="col-8">
      <select id="mata kuliah" name="mata kuliah" required="required" class="custom-select">
        <option value="dasar dasar pemrograman">Dasar Dasar Pemrograman</option>
        <option value="basis data">Basis Data</option>
        <option value="pemrograman web">Pemrograman Web</option>
      </select>
    </div>
  </div>
  <div class="form-group row">
    <label for="" class="col-2 col-form-label">Nilai UTS</label> 
    <div class="col-8">
      <div class="input-group">
        <div class="input-group-prepend">
          <div class="input-group-text">
            <i class="fa fa-sort-numeric-asc"></i>
          </div>
        </div> 
        <input id="" name="" placeholder="Nilai UTS" type="text" class="form-control" required="required">
      </div>
    </div>
  </div>
  <div class="form-group row">
    <label for="nilai uas" class="col-2 col-form-label">Nilai UAS</label> 
    <div class="col-8">
      <div class="input-group">
        <div class="input-group-prepend">
          <div class="input-group-text">
            <i class="fa fa-sort-numeric-asc"></i>
          </div>
        </div> 
        <input id="nilai uas" name="nilai uas" placeholder="Nilai UAS" type="text" class="form-control" required="required">
      </div>
    </div>
  </div>
  <div class="form-group row">
    <label for="text" class="col-2 col-form-label">Nilai Tugas</label> 
    <div class="col-8">
      <div class="input-group">
        <div class="input-group-prepend">
          <div class="input-group-text">
            <i class="fa fa-sort-numeric-asc"></i>
          </div>
        </div> 
        <input id="text" name="text" placeholder="Nilai Tugas" type="text" class="form-control" required="required">
      </div>
    </div>
  </div> 
  <div class="form-group row">
    <div class="offset-4 col-8">
      <button name="submit" type="submit" class="btn btn-primary">Submit</button>
    </div>
  </div>
</form>
    Nama : <input type="text" name="nama" value="" size="30" /></br>
    Mata kuliah :
    <select name="matkul">
        <option value="DDP">"Dasar Dasar Pemrograman"</option>
        <option value="BD1">"Basis Data"</option>
        <option value="WEB1">"Pemrograman Web"</option>
</select></br>
Nilai UTS : <input type="number" name="nilai_uts" value="" size="6" /></br>
Nilai UAS : <input type="number" name="nilai_uas" value="" size="6" /></br>
Nilai Tugas/Praktikum : <input type="number" name="nilai_tugas" value="" size="6" /></br>
        
<input type="submit" value="Simpan" name="proses" />
</form>
</body>
</html>

<?php
$proses = $_GET['proses'];
$nama_siswa = $_GET['nama'];
$mata_kuliah = $_GET['matkul'];
$nilai_uts = $_GET['nilai_uts'];
$nilai_uas = $_GET['nilai_uas'];
$nilai_tugas = $_GET['nilai_tugas'];

echo 'Proses : '.$proses;
echo '<br/> Nama : '.$nama_siswa;
echo '<br/> Mata Kuliah : '.$mata_kuliah;
echo '<br/> Nilai UTS : '.$nilai_uts;
echo '<br/> Nilai UAS : '.$nilali_uas;
echo '<br/> Nilai Tugas Praktikum : '.$nilai_tugas;


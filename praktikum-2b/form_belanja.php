<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>form belanja</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body style="font-size: 18px;">
<form method="POST" action="total_belanja.php" class="container mt-5">
    <fieldset class="border border-dark p-3 rounded" style="background-color: pink;">
      <legend class="float-none w-auto px-3 fw-bold h3">Belanja</legend>

     
<form>
  <div class="form-group row">
    <label for="customer" class="col-2 col-form-label">Customer</label> 
    <div class="col-4">
      <div class="input-group">
        <div class="input-group-prepend">
          <div class="input-group-text">
            <i class="fa fa-user"></i>
          </div>
        </div> 
        <input id="customer" name="customer" placeholder="Nama Customer" type="text" required="required" class="form-control">
      </div>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-2">Pilih Produk</label> 
    <div class="col-4">
      <div class="custom-control custom-radio custom-control-inline">
        <input name="produk" id="produk_0" type="radio" class="custom-control-input" value="laptop" required="required"> 
        <label for="produk_0" class="custom-control-label">Laptop</label>
      </div>
      <div class="custom-control custom-radio custom-control-inline">
        <input name="produk" id="produk_1" type="radio" class="custom-control-input" value="handphone" required="required"> 
        <label for="produk_1" class="custom-control-label">Handphone</label>
      </div>
      <div class="custom-control custom-radio custom-control-inline">
        <input name="produk" id="produk_2" type="radio" class="custom-control-input" value="tablet" required="required"> 
        <label for="produk_2" class="custom-control-label">Tablet</label>
      </div>
    </div>
  </div>
  <div class="form-group row">
    <label for="jumlah" class="col-2 col-form-label">Jumlah</label> 
    <div class="col-4">
      <div class="input-group">
        <div class="input-group-prepend">
          <div class="input-group-text">
            <i class="fa fa-shopping-cart"></i>
          </div>
        </div> 
        <input id="jumlah" name="jumlah" placeholder="Jumlah" type="text" class="form-control" required="required">
      </div>
    </div>
  </div> 
  <div class="form-group row">
    <div class="offset-2 col-8">
      <button name="submit" type="submit" class="btn btn-primary">Submit</button>
    </div>
  </div>

</form>

<div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">Daftar Harga</div>
                    <div class="card-body">
                        <p>TV : Rp 4.200.000</p>
                        <p>Kulkas : Rp 3.100.000</p>
                        <p>MESIN CUCI : Rp 3.800.000</p>
                    </div>
                    <div class="card-footer bg-primary text-white text-center">Harga Dapat Berubah Setiap Saat</div>
                </div>
            </div>
        </div>

        <script>
        document.getElementById("orderForm").addEventListener("submit", function(event) {
            event.preventDefault();
            
            const hargaProduk = {
                tv: 4200000,
                kulkas: 3100000,
                mesin_cuci: 3800000
            };

            let customer = document.getElementById("customer").value;
            let produkTerpilih = document.querySelector('input[name="produk"]:checked');
            let jumlah = parseInt(document.getElementById("jumlah").value);
            let totalHarga = 0;
            
            if (produkTerpilih && jumlah) {
                totalHarga = hargaProduk[produkTerpilih.value] * jumlah;
            }
            
            document.getElementById("result").innerHTML = `
                <p><strong>Nama Customer:</strong> ${customer}</p>
                <p><strong>Produk Pilihan:</strong> ${produkTerpilih.nextElementSibling.innerText}</p>
                <p><strong>Jumlah Beli:</strong> ${jumlah}</p>
                <p><strong>Total Belanja:</strong> Rp ${totalHarga.toLocaleString("id-ID")}</p>
            `;
        });
    </script>
   
</body>
</html>
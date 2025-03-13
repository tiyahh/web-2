<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Belanja Online</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>
<body>
    <div class="container mt-4">
        <h3>Belanja Online</h3>
        <div class="row">
            <div class="col-md-8">
                <form id="orderForm">
                    <div class="form-group row">
                        <label for="customer" class="col-4 col-form-label">Customer</label>
                        <div class="col-8">
                            <input id="customer" name="customer" placeholder="Nama Customer" type="text" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4">Pilih Produk</label>
                        <div class="col-8">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input name="produk" id="produk_tv" type="radio" class="custom-control-input" value="tv" required>
                                <label for="produk_tv" class="custom-control-label">TV</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input name="produk" id="produk_kulkas" type="radio" class="custom-control-input" value="kulkas" required>
                                <label for="produk_kulkas" class="custom-control-label">Kulkas</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input name="produk" id="produk_mesin_cuci" type="radio" class="custom-control-input" value="mesin_cuci" required>
                                <label for="produk_mesin_cuci" class="custom-control-label">MESIN CUCI</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jumlah" class="col-4 col-form-label">Jumlah</label>
                        <div class="col-8">
                            <input id="jumlah" name="jumlah" placeholder="Jumlah" type="number" class="form-control" required min="1">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="offset-4 col-8">
                            <button name="submit" type="submit" class="btn btn-success">Kirim</button>
                        </div>
                    </div>
                </form>
                <div id="result" class="mt-4"></div>
            </div>
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

<?php
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
?>
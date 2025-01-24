<?php
// mengembalikan serangkaian karakter (Memulai irisan pada indeks 6 dan akhiri irisan pada 5 posisi berikutnya dengan karakter pertama adalah 0:)
$x = "Indonesia Merdeka!";
echo substr($x, 6, 6);
echo "<br>";

// Potong Sampai Akhir(Dengan menghilangkan parameter panjang , rentang akan mencapai akhir dengan indeks pertama adalah 1 bukan 0)
echo substr($x, 8);
echo "<br>";

// Potongan Dari Akhir(Gunakan indeks negatif untuk memulai irisan dari akhir string)
echo substr($x, -5, 3);
echo "<br>";

// Negative Length (Ngitungngya angka "5" dari awal dan "-3" dari akhir)
echo substr($x, 5, -3);
echo "<br>";
?>
<?php
//  function returns the string in upper case:
    $x = "Hello World Man!";
    echo strtoupper($x);
    echo '<br>';

//  function returns the string in lower case:
    $r = "Aha";
    echo strtoLOWER($r);
    echo '<br>';

// mengganti beberapa karakter dengan beberapa karakter lain dalam sebuah string.
$x = "Hello World!";
echo str_replace("World", "Dolly Ikan", $x);
echo '<br>';

// membalikkan string.
$x = "Malang";
echo strrev($x);
echo '<br>';

// Menghapus spasi apa pun dari awal atau akhir
$x = "       Hello Namaku Yusril! ";
echo ($x);
echo '<br>';
echo trim($x);
echo '<br>';
echo "<input value='" . $x . "'>";
echo "<br>";
echo "<input value='" . trim($x) . "'>";
echo '<br>';

// Mengubah String menjadi Array
$x = "Hello, my name is Yusril!";
$y = explode(" ", $x);
print_r($y);

?>
<?php
// menggabungkan 2 string atau lebih tanpa spasi
$x = "Hello";
$y = "Namaku";
$z = "Yusril";
$a = $x . $y. $z;
echo $a;
echo "<br>";

// menggabungkan 2 string atau lebih dengan spasi
// versi 1
$a = "$x $y $z";
echo $a;
echo "<br>";
// versi 2
$b = $x. " " . $y. " " . $z;
echo $b;
echo "<br>";


?>
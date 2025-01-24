<?php
function hello(){
    echo "Thus Spoke Trailblazer";
}
hello();

echo "<br>";

function salam($nama="Trailblazer"){
    echo "Thus Spoke $nama";
}
salam("Apocalypse");
salam();

echo "<br>";

function tambah($x,$y){
    $hasil=$x+$y;
    echo $hasil;
}
echo "<br>";
function add($x,$y){
    $hasil=$x+$y;
    echo $hasil;
}
echo "<br>";
add(8,9);
echo "<br>";
echo tambah(9,10)+10;
$x=10;
echo "<br>";
echo "10";
echo "<br>";
echo $x;
?>
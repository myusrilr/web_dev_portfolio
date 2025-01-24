<?php

// class = templete = cetakan
class character{
    // properties(aset yang boleh di akses)
    public $name;
    public $weapon;
    public $armour;

    function info(){
        echo "Hello my name is".$this->name."<br>";
        echo "I use ".$this->weapon." and ".$this->armour."for protection <br>";
    }
}

// instance = pencetakan dari class menjadi object
$TomSamCong=new character();

$TomSamCong->name="Tom Sam Cong";
$TomSamCong->weapon="Sun Wukong";
$TomSamCong->armour="None";

// echo $TomSamCong->name;
$TomSamCong->info();

?>
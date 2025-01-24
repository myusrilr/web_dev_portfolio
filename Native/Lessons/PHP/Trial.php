<?php
require_once 'core.php';
use function \Player\User\salam as greeting;
use const \Player\Npc\AUTHOR as author;
use \PLayer\User\Character as character;
use \Player\Npc\Character as npc;

$Heroku=new character();
$Enemy=new npc();

// echo AUTHOR;
// salam();
echo author;
greeting();

echo $Heroku->name.PHP_EOL;
echo $Enemy->name.PHP_EOL;
?>
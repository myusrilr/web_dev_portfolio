<!-- https://edabit.com/challenge/yAxo88Pfe9hWhZdLt -->

<?php
function equal($a, $b, $c)
{
    if ($a == $b && $b == $c) {
        return 3;  
    } elseif ($a == $b || $a == $c || $b == $c) {
        return 2;  
    } else {
        return 0;  
    }
}

echo equal(3, 4, 3); 
echo "\n";
echo equal(1, 1, 1); 
echo "\n";
echo equal(3, 4, 1); 
echo "\n";


?>
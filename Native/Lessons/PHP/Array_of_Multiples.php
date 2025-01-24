<!-- https://edabit.com/challenge/HrzMnufZLgPRq3jRy -->

<?php
function arrayOfMultiples($num, $length) {
    $result = [];
    for ($i = 1; $i <= $length; $i++) {
        $result[] = $num * $i;
    }
    return $result;
}

echo implode(", ", arrayOfMultiples(7, 5)); 
echo "\n";
echo implode(", ", arrayOfMultiples(12, 10)); 
echo "\n";
echo implode(", ", arrayOfMultiples(17, 6)); 
echo "\n";


?>


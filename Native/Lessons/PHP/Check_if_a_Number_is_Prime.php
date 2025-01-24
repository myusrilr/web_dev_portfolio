<!-- https://edabit.com/challenge/Xqi73dZ8kLDegRcwQ -->

<?php
function isPrime($num) {
    if ($num <= 1) {
        return false;
    }
    for ($i = 2; $i <= sqrt($num); $i++) {
        if ($num % $i == 0) {
            return false;
        }
    }
    return true;
}

echo isPrime(31); 
echo "\n";
echo isPrime(18); 
echo "\n";
echo isPrime(11); 
echo "\n";
?>
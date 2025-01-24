<!-- https://edabit.com/challenge/d9ZiNFJjNP9SbTgRs -->

<?php
function halflifeCalculator($mass, $hlife, $n) {
    $remainingMass = $mass * (0.5 ** $n);
    $years = $hlife * $n;
    return [round($remainingMass, 3), $years];
}

echo implode(", ", halflifeCalculator(1600, 6, 3)); 
echo "\n";
echo implode(", ", halflifeCalculator(13, 500, 1)); 
echo "\n";
echo implode(", ", halflifeCalculator(100, 35, 5)); 
echo "\n";
?>

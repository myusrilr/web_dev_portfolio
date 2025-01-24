<!-- https://edabit.com/challenge/hA8BLACQf7SNW2PGy -->
<?php
 
function hurdleJump($hurdles, $jumpHeight) {
    foreach ($hurdles as $hurdle) {
        if ($jumpHeight < $hurdle) {
            return false;
        }
    }
    return true;
}

echo hurdleJump([1, 2, 3, 4, 5], 5); 
echo "\n";
echo "\n";
echo hurdleJump([5, 4, 5, 6], 10); 
echo "\n";
echo hurdleJump([1, 2, 1], 1); 
echo "\n";
?>

<!-- https://edabit.com/challenge/KyGyZAt7BLPpoCKdM -->

<?php
function nthSmallest($arr, $n) {
    sort($arr);
    if ($n > count($arr)) {
        return null;
    }
    return $arr[$n - 1];
}

echo nthSmallest([1, 3, 5, 7], 1); 
echo "\n";
echo nthSmallest([1, 3, 5, 7], 3);  
echo "\n";
echo nthSmallest([1, 3, 5, 7], 5);  
echo "\n";
echo nthSmallest([7, 3, 5, 1], 2);  
echo "\n";
?>

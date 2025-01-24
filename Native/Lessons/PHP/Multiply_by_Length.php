<!-- https://edabit.com/challenge/mTJWdDW6QAvfzdWdL -->

<?php
function MultiplyByLength($arr) {
    $length = count($arr);
    for ($i = 0; $i < $length; $i++) {
        $arr[$i] *= $length;
    }
    return $arr;
}

echo implode(", ", MultiplyByLength([2, 3, 1, 0]));
echo "\n";
echo implode(", ", MultiplyByLength([4, 1, 1])); 
echo implode(", ", MultiplyByLength([1, 0, 3, 3, 7, 2, 1])); 
echo "\n";
echo implode(", ", MultiplyByLength([0])); 
echo "\n";
?>
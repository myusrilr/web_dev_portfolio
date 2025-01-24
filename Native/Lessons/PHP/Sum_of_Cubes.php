<!-- https://edabit.com/challenge/auXndZS6XLdzfyxnr -->

<?php
function sumOfCubes($nums) {
    $sum = 0;
    foreach ($nums as $num) {
        $sum += pow($num, 3);
    }
    return $sum;
}

echo sumOfCubes([1, 5, 9]); 
echo "\n";
echo sumOfCubes([3, 4, 5]); 
echo "\n";
echo sumOfCubes([2]); 
echo "\n";
echo sumOfCubes([]);
echo "\n";
?>

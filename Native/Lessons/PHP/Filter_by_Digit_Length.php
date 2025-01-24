<!-- https://edabit.com/challenge/9h8dehaE24aW2xwcu -->

<?php
function filterDigitLength($arr, $num) {
    $filteredArr = array_filter($arr, function($number) use ($num) {
        return strlen((string)$number) == $num;
    });

    if (empty($filteredArr)) {
        return [];
    } else if (count($filteredArr) == count($arr)) {
        return $arr;
    } else {
        return array_values($filteredArr);
    }
}

echo implode(", ", filterDigitLength([88, 232, 4, 9721, 555], 3));
echo "\n";
echo implode(", ", filterDigitLength([2, 7, 8, 9, 1012], 1));
echo "\n";
echo implode(", ", filterDigitLength([32, 88, 74, 91, 300, 4050], 1));
echo "\n";
echo implode(", ", filterDigitLength([5, 6, 8, 9], 1));
echo "\n";





?>
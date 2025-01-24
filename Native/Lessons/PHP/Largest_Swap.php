<!-- https://edabit.com/challenge/6cy4ZoxMggJNCBjEa -->

<?php
function largestSwap($num) {
    $reversed = intval(strrev(strval($num)));
    return $num >= $reversed;
}

echo largestSwap(27); // Output: false
echo "\n";
echo largestSwap(43); // Output: true
echo "\n";
echo largestSwap(14); // Output: false
echo "\n";
echo largestSwap(53); // Output: true
echo "\n";
echo largestSwap(99); // Output: true
echo "\n";
?>

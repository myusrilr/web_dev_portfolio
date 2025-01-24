<!-- https://edabit.com/challenge/TxDwkxsHXZ3DzePBY -->

<?php
function intWithinBounds($n, $lower, $upper) {
    if (is_int($n) && $n >= $lower && $n < $upper) {
        return true;
    } else {
        return false;
    }
}

echo intWithinBounds(3, 1, 9); 
echo intWithinBounds(6, 1, 6); 
echo intWithinBounds(4.5, 3, 8);





?>
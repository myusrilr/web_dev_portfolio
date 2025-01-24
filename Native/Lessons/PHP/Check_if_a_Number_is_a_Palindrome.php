<!-- https://edabit.com/challenge/WdGZzzZHrJ8Mu5it3 -->

<?php
function isPalindrome($n) {
    $original = $n;
    $reversed = 0;
    while ($n > 0) {
        $digit = $n % 10;
        $reversed = $reversed * 10 + $digit;
        $n = intval($n / 10);
    }
    return $original === $reversed;
}

echo isPalindrome(838); 
echo "\n";
echo isPalindrome(4433); 
echo "\n";
echo isPalindrome(443344); 
echo "\n";
?>
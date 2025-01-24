<!-- https://edabit.com/challenge/yog5Y8WG6FMJ3XACK -->

<?php
function countVowels($str) {
    $count = 0;
    $vowels = ['a', 'e', 'i', 'o', 'u'];
    $str = strtolower($str);
    for ($i = 0; $i < strlen($str); $i++) {
        if (in_array($str[$i], $vowels)) {
            $count++;
        }
    }
    return $count;
}

echo countVowels("Celebration"); // Output: 5
echo "\n";
echo countVowels("Palm"); // Output: 1
echo "\n";
echo countVowels("Prediction"); // Output: 4
echo "\n";
?>

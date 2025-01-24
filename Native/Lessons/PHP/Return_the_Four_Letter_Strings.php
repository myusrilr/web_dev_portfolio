<!-- https://edabit.com/challenge/49Jj8gZqZhS9nWtwM -->

<?php

function isFourLetters($arr) {
    return array_filter($arr, function($word) {
        return strlen($word) == 4;
    });
}

echo implode(", ", isFourLetters(["Tomato", "Potato", "Pair"]));
echo "\n";
echo implode(", ", isFourLetters(["Kangaroo", "Bear", "Fox"]));
echo "\n";
echo implode(", ", isFourLetters(["Ryan", "Kieran", "Jason", "Matt"]));
echo "\n";



?>
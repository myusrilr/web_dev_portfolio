<!-- https://edabit.com/challenge/ccBNNo9gT2NknbC2W -->

<?php

function maximumScore($tileHand) {
    $totalScore = 0;
    foreach ($tileHand as $tile) {
        $totalScore += $tile["score"];
    }
    return $totalScore;
}

echo maximumScore([
    [ "tile" => "N", "score" => 1 ],
    [ "tile" => "K", "score" => 5 ],
    [ "tile" => "Z", "score" => 10 ],
    [ "tile" => "X", "score" => 8 ],
    [ "tile" => "D", "score" => 2 ],
    [ "tile" => "A", "score" => 1 ],
    [ "tile" => "E", "score" => 1 ]
]); 

echo maximumScore([
    [ "tile" => "B", "score" => 2 ],
    [ "tile" => "V", "score" => 4 ],
    [ "tile" => "F", "score" => 4 ],
    [ "tile" => "U", "score" => 1 ],
    [ "tile" => "D", "score" => 2 ],
    [ "tile" => "O", "score" => 1 ],
    [ "tile" => "U", "score" => 1 ]
]); 

?>



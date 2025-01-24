<!-- https://edabit.com/challenge/jRfdpKtQf9KqyfuCH -->

<?php
function greetPeople($names) {
    $greetings = [];
    foreach ($names as $name) {
        $greetings[] = "Hello " . $name;
    }
    return implode(", ", $greetings);
}

echo greetPeople(["Joe"]); 
echo "\n";
echo greetPeople(["Angela", "Joe"]); 
echo greetPeople(["Frank", "Angela", "Joe"]); 
echo "\n";
?>

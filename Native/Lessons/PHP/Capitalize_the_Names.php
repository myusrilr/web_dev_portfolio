<!-- https://edabit.com/challenge/4uEox3w945f8skbwN -->

<?php
function capMe($names) {
    $capitalizedNames = [];
    foreach ($names as $name) {
        $capitalizedNames[] = ucfirst(strtolower($name));
    }
    return $capitalizedNames;
}

echo implode(", ", capMe(["mavis", "senaida", "letty"])); 
echo "\n";
echo implode(", ", capMe(["samuel", "MABELLE", "letitia", "meridith"])); 
echo "\n";
echo implode(", ", capMe(["Slyvia", "Kristal", "Sharilyn", "Calista"])); 
echo "\n";
?>

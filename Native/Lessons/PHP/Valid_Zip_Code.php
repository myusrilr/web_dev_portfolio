<!-- https://edabit.com/challenge/JoPRJr6CarxY4KjA6 -->

<?php
function isValid($zip) {
    return preg_match('/^\d{5}(?:-\d{4})?$/', $zip);
}

echo isValid("59001");
echo isValid("853a7");
echo isValid("732 32");
echo isValid("393939");



?>


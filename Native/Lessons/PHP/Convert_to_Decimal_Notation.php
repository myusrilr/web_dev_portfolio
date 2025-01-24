<!-- https://edabit.com/challenge/oS8yH8oGfw5KbKHMp -->

<?php
function convertToDecimal($perc) {
    $decimals = [];
    foreach ($perc as $percentage) {
        $decimal = floatval(rtrim($percentage, "%")) / 100;
        $decimals[] = $decimal;
    }
    return $decimals;
}

echo implode(", ", convertToDecimal(["1%", "2%", "3%"])); 
echo "\n";
echo implode(", ", convertToDecimal(["45%", "32%", "97%", "33%"])); 
echo "\n";
echo implode(", ", convertToDecimal(["33%", "98.1%", "56.44%", "100%"])); 
echo "\n";
?>

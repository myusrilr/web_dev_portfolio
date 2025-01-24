<!-- https://edabit.com/challenge/6KoodWTcxo87SFpv6 -->

<?php
function hasSpaces($str) {
    return strpos($str, " ") !== false;
}

echo hasSpaces("hello"); 
echo hasSpaces("hello, world");
echo hasSpaces(" "); 
echo hasSpaces(""); 
echo hasSpaces(",./!@#"); 






?>
<?php

namespace Player\User{
    class Character{
        var $name="Player";
        function hai(){
            echo "hai";
        }
    }

    function salam(){
        echo " Assalamualaikum ";
    }
}

namespace Player\Npc{
    class Character{
        var $name="NPC";
    }

    const AUTHOR = "Satrio Karunia Akbar";
}

?>
<?php
class Character
{
    public string $name;
    public int $level;
    public string $gender;
    public int $power;

    function __construct($name, $level, $gender, $power)
    {
        $this->name = $name;
        $this->level = $level;
        $this->gender = $gender;
        $this->power = $power;
    }

    function info()
    {
        echo "Character Detail info" . "<br>";
        echo "1. Name: " . $this->name . "<br>";
        echo "2. Level: " . $this->level . "<br>";
        echo "3. Gender: " . $this->gender . "<br>";
        echo "4. Power: " . $this->power . "<br>";
    }
}

class Level2 extends Character
{
    public int $speed;

    function __construct($name, $level, $gender, $power, $speed)
    {
        parent::__construct($name, $level, $gender, $power);
        $this->speed = $speed;
    }

    function info()
    {
        parent::info();
        echo "5. Speed: " . $this->speed . "<br>";
    }
}

class Level3 extends Level2
{
    public int $ATK;

    function __construct($name, $level, $gender, $power, $speed, $ATK)
    {
        parent::__construct($name, $level, $gender, $power, $speed);
        $this->ATK = $ATK;
    }

    function info()
    {
        parent::info();
        echo "6. ATK: " . $this->ATK . "<br>";
    }
}


$Yusril1 = new Character("Yusril", 1, "laki-laki", 50);
$Yusril2 = new Level2("Yusril", 2, "laki-laki", 50, 60);
$Yusril3 = new Level3("Yusril", 3, "laki-laki", 50, 60, 70);


$Yusril1->info();
echo "<br>";
$Yusril2->info();
echo "<br>";
$Yusril3->info();
echo "<br>";

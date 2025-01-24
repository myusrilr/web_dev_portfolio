<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get</title>
</head>
<body>
    <form action="#" method="POST">
        <input type="text" name="nama"><br>
        <input type="text" name="email"><br>
        <input type="submit" name="submit" value="Submit">
    </form>

    <?php
    if($_POST){
        echo "Nama: " . $_POST['nama'];
        echo "<br>";
        echo "Email: " . $_POST['email'];
    }
    ?>
</body>
</html>
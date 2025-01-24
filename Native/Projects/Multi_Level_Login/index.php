<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>MULTI LEVEL LOGIN</h2>
    <?php
    if(isset($_GET['pesan'])){
        if($_GET['pesan']=="gagal"){
            echo "gagal login, username dan password salah";
        }
        
    }
        
        
        
        ?>
    <form action="auth.php" method="POST">
    <table>
        <tr>
            <td>USERNAME</td>
            <td>:</td>
            <td><input type="text" placeholder="username" name="Username"></td>
        </tr>
        <tr>
            <td>PASSWORD</td>
            <td>:</td>
            <td><input type="text" placeholder="password" name="Password"></td>
        </tr>
        <tr>
            <td>LEVEL</td>
            <td>:</td>
            <td><input type="text" placeholder="level" name="Level">
        </td>
        <tr>
            <td></td>
            <td></td>
            <td><input type="submit" value="login"></td>
            </tr>
        </tr>
    </table>
    </form>
    
</body>
</html>
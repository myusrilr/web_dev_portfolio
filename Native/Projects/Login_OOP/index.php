<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        if(isset($_POST['status'])){
            if($_POST['status']=='denied'){
                header("location:login/index.php?pesan='gagal'");
            }
        }else{
            
            header("location:login/index.php");
        }
    ?>
    <h1>HALAMAN UTAMA</h1>
</body>
</html>
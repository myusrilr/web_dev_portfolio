<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Data User</title>
</head>

<body>
    <h2>UPDATE DATA USER</h2>
    <br>
    <a href="index.php">KEMBALI</a>
    <br><br>

    <?php
    include 'database.php';
    $db = new database();  

   
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        
        $data = $db->get_data($id);  

    
        if (count($data) > 0) {
            $d = $data[0];  
    ?>

        <form method="post" action="proses.php?aksi=update">
            <table>
                <tr>
                    <td>Nama</td>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $d['id']; ?>">
                        <input type="text" name="nama" value="<?php echo $d['nama']; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td><input type="text" name="alamat" value="<?php echo $d['alamat']; ?>"></td>
                </tr>
                <tr>
                    <td>Usia</td>
                    <td><input type="number" name="usia" value="<?php echo $d['usia']; ?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="SIMPAN"></td>
                </tr>
            </table>
        </form>

    <?php
        } else {
            echo "Data not found!";
        }
    } else {
        echo "No ID provided!";
    }
    ?>

</body>
</html>

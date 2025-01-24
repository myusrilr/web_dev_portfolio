<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h2>UPDATE DATA USER</h2>
    <br>
    <a href="index.php">KEMBALI</a>
    <br>
    <br>
    <?php
    include 'koneksi.php';
    $id = $_GET['id'];
    $data = mysqli_query($koneksi, "SELECT * FROM user WHERE id='$id' ");

    while ($d = mysqli_fetch_array($data)) {
    ?>
        <form method="post" action="edit_controller.php">
            <table>
                <tr>
                    <td>Nama</td>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $d['id']; ?>">
                        <input type="text" name="nama" value="<?php echo $d['nama']; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>
                        <select name="status" id="status">
                            <option><?php echo $d['status']; ?></option>
                            <option value="aktif">aktif</option>
                            <option value="nonaktif">nonaktif</option>
                            <option value="banned">banned</option>
                        </select></td>
                </tr>
                <tr>
                    <td>Level</td>
                    <td><input type="text" name="level" value="<?php echo $d['level']; ?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="SIMPAN"></td>
                </tr>
            </table>
        </form>

    <?php
    }
    ?>

</body>

</html>
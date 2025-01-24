<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    session_start();

    if ($_SESSION['level'] == "") {
        header("location:index.php?pesan=gagal");
    }
    ?>
    <h1>SUPER ADMIN PAGE</h1>


        <table border=1>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Status</th>
                <th>Level</th>
                <th>OPSI</th>
            </tr>
            <?php
            include "koneksi.php";
            $no = 1;
            $data = mysqli_query($koneksi, "SELECT * FROM user");
            while ($d = mysqli_fetch_array($data)) {
            ?>
                <tr>
                    <td><?php echo $no++ ?></td>
                    <td><?php echo $d["nama"] ?></td>
                    <td><?php echo $d["status"] ?></td>
                    <td><?php echo $d["level"] ?></td>
                    <td>
                        <a href="edit_view.php?id=<?php echo $d['id'] ?>">EDIT</a>
                        <a href="hapus.php?id=<?php echo $d['id'] ?>">HAPUS</a>
                    </td>
                </tr>

            <?php
            }
            ?>
        </table>
        <br>
        <br>
        <a href="logout.php">LOGOUT</a>
</body>

</html>
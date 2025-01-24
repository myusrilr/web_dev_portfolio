<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    include "database.php";
    $db = new database();
    ?>

    <h1>CRUD SANTRI CODING</h1>
    <a href="input.php">INPUT</a>
    <table border="1">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Usia</th>
            <th>Opsi</th>
        </tr>
        <?php
        $no = 1;
        foreach ($db->show_data() as $d) {
            ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $d['nama']; ?></td>
                <td><?php echo $d['alamat']; ?></td>
                <td><?php echo $d['usia'];
                 ?></td>
                <td>
                    <a href="proses.php?aksi=hapus&id=<?php echo $d['id']; ?>">Hapus</a>
                    <a href="proses.php?aksi=update&id=<?php echo $d['id']; ?>">Update</a>
                </td>

            </tr>

            <?php

        }

        ?>
    </table>
</body>
</html>

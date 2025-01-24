<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    input {
        padding: 15px;
        font-size: 30px;
        font-weight: bold;
        cursor: pointer;
        border-radius: 10px;
        border: none;
        margin-top: 10px;



    }
</style>

<body>
<table border=1>
        <tr>
            <th>Nomor</th>
            <th>Item</th>
            <th>Harga</th>
            <th>Quantity</th>
        </tr>
        <?php
        include 'koneksi.php';
        $no=1;
        $data=mysqli_query($koneksi,"SELECT * FROM barang");
        while($d=mysqli_fetch_array($data)){
            ?>
            <tr>
                <td><?php echo $no++?></td>
                <td><?php echo $d["item"]?></td>
                <td><?php echo $d["harga"]?></td>
                <td><?php echo $d["quantity"]?></td>
            </tr>
        <?php
        }
        ?>
    </table>
    <form action="tambah.php">
            <input type="submit" value="+">
    </form>
    <form action="kurang.php">
            <input type="submit" value="-">
    </form>
    <form action="invoice.php" method="POST">
        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity">
        <br>
        <input type="submit" value="Create Invoice">
    </form>
   
</body>

</html>
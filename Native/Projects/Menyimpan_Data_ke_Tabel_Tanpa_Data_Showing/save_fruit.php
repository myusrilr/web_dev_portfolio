<?php
if (isset($_POST['fruit_name']) && isset($_POST['stores'])) {
    $fruitName = $_POST['fruit_name'];
    $stores = $_POST['stores'];

    // Connect to the database
    $mysqli = new mysqli('localhost', 'root', '', 'db_buah');
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Check if the fruit exists in the stock table
    $stmt = $mysqli->prepare("SELECT nama_buah FROM stok_buah WHERE nama_buah = ?");
    $stmt->bind_param("s", $fruitName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Determine which stores to save to
        $targetStores = [];
        if (in_array('all', $stores)) {
            $targetStores = ['store_1', 'store_2', 'store_3'];
        } else {
            $targetStores = array_intersect(['store_1', 'store_2', 'store_3'], $stores);
        }

        // Insert the fruit into each selected store table
        foreach ($targetStores as $store) {
            $insertStmt = $mysqli->prepare("INSERT INTO $store (nama_buah) VALUES (?)");
            $insertStmt->bind_param("s", $fruitName);
            $insertStmt->execute();
            $insertStmt->close();
        }

        echo "<script>alert('Buah berhasil tersimpan!');
        window.location.href='index.php'</script>";
        exit;
    } else {
        echo "<script>alert('Buah Terpilih tidak ditemukan di Tabel Stok Buah!');
        window.location.href='index.php'</script>";
        exit;
    }

    // Close connections
    $stmt->close();
    $mysqli->close();
} else {
    echo "<script>alert('Pilihlah setidaknya salah satu buah dan tabel buah!');
    window.location.href='index.php'</script>";
    exit;
}
?>

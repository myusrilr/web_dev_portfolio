<?php
if (isset($_POST['selected_fruits']) && isset($_POST['stores'])) {
    $selectedFruits = json_decode($_POST['selected_fruits'], true); // Decode JSON
    $stores = $_POST['stores'];

    // Connect to the database
    $mysqli = new mysqli('localhost', 'root', '', 'db_buah');
    if ($mysqli->connect_error) {
        die("Koneksi gagal: " . $mysqli->connect_error);
    }

    // Determine which stores to save to
    $targetStores = [];
    if (in_array('all', $stores)) {
        $targetStores = ['store_1', 'store_2', 'store_3'];
    } else {
        $targetStores = array_intersect(['store_1', 'store_2', 'store_3'], $stores);
    }

    // Insert each selected fruit into each chosen store table
    foreach ($selectedFruits as $fruitName) {
        foreach ($targetStores as $store) {
            $insertStmt = $mysqli->prepare("INSERT INTO $store (nama_buah) VALUES (?)");
            $insertStmt->bind_param("s", $fruitName);
            $insertStmt->execute();
            $insertStmt->close();
        }
    }

    echo "<script>alert('Buah terpilih Berhasil Tersimpan di dalam Tabel Buah Terpilih!');
        window.location.href='index.php'</script>";
        exit;
    // Close the connection
    $mysqli->close();
} else {
    echo "<script>alert('Pilihlah setidaknya salah satu buah dan tabel buah!');
        window.location.href='index.php'</script>";
        exit;
}
?>

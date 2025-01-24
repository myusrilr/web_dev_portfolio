<?php
if (isset($_POST['selected_fruits']) && isset($_POST['stores'])) {
    $selectedFruits = json_decode($_POST['selected_fruits'], true); // Decode JSON
    $stores = $_POST['stores'];

    // Connect to the database
    $mysqli = new mysqli('localhost', 'root', '', 'blox_fuit');
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
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
            $insertStmt = $mysqli->prepare("INSERT INTO $store (fruit) VALUES (?)");
            $insertStmt->bind_param("s", $fruitName);
            $insertStmt->execute();
            $insertStmt->close();
        }
    }

    echo "Fruits saved to the selected stores successfully.";

    // Close the connection
    $mysqli->close();
} else {
    echo "Please select fruits and at least one store.";
}
?>

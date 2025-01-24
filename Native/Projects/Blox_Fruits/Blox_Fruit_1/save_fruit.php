<?php
if (isset($_POST['fruit_name']) && isset($_POST['stores'])) {
    $fruitName = $_POST['fruit_name'];
    $stores = $_POST['stores'];

    // Connect to the database
    $mysqli = new mysqli('localhost', 'root', '', 'blox_fuit');
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Check if the fruit exists in the stock table
    $stmt = $mysqli->prepare("SELECT fruit FROM stock WHERE fruit = ?");
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
            $insertStmt = $mysqli->prepare("INSERT INTO $store (fruit) VALUES (?)");
            $insertStmt->bind_param("s", $fruitName);
            $insertStmt->execute();
            $insertStmt->close();
        }

        echo "Fruit saved to the selected stores successfully.";
    } else {
        echo "The selected fruit was not found in the stock table.";
    }

    // Close connections
    $stmt->close();
    $mysqli->close();
} else {
    echo "Please select a fruit and at least one store.";
}
?>

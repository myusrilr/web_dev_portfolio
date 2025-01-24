<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select and Save Fruit - Gaming Style</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Styles -->
    <style>
        body {
            background-color: #1c1c2b; /* Dark background for a gaming look */
            color: #fff; /* White text color for readability */
        }
        .container {
            max-width: 600px;
            background-color: #2d2d3e; /* Darker container background */
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.4);
        }
        .form-label, h3 {
            color: #f0f0f5;
        }
        .form-select, .btn-primary {
            background-color: #3d3d5c; /* Purple-ish input background */
            color: #fff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #5c5ca3; /* Hover effect with brighter purple */
        }
        .btn-primary {
            background-color: #c40233; /* Red button for emphasis */
        }
        .btn-primary:hover {
            background-color: #e0002d; /* Darker red on hover */
        }
        h3 {
            color: #ff4971; /* Accent color for title */
            text-align: center;
            margin-bottom: 20px;
            font-family: 'Arial Black', sans-serif;
            text-shadow: 2px 2px 10px rgba(255, 73, 113, 0.6);
        }
        .store-button-group .btn {
            width: 30%; /* Equal width for inline buttons */
            margin-right: 2%;
            background-color: #3d3d5c;
            color: white;
            border: none;
        }
        .store-button-group .btn:hover, .store-button-group .btn.active {
            background-color: #5c5ca3;
        }
        .store-button-group .btn.active-all {
            width: 96%; /* Full width button for 'All Stores' */
            margin-top: 10px;
            background-color: #3d3d5c;
            color: white;
            border: none;
        }
        .store-button-group .btn.active-all:hover, .store-button-group .btn.active-all.active {
            background-color: #5c5ca3;
        }
    </style>
</head>
<body>

<div class="container my-5">
    <h3>Select a Fruit to Store</h3>
    
    <!-- Form to select fruit and choose stores -->
    <form id="fruitForm" action="save_fruit.php" method="POST">
        <div class="mb-4">
            <label for="fruitDropdown" class="form-label">Select Fruit</label>
            <select id="fruitDropdown" name="fruit_name" class="form-select" required>
                <option value="">Select a Fruit</option>
                <?php
                // Connect to the database
                $mysqli = new mysqli('localhost', 'root', '', 'blox_fuit');
                if ($mysqli->connect_error) {
                    die("Connection failed: " . $mysqli->connect_error);
                }
                // Fetch fruits from the database
                $resultSet = $mysqli->query("SELECT fruit FROM stock");
                while ($row = $resultSet->fetch_assoc()) {
                    echo "<option value='{$row['fruit']}'>{$row['fruit']}</option>";
                }
                $mysqli->close();
                ?>
            </select>
        </div>
        
        <div class="mb-4">
            <label class="form-label">Select Store(s) to Save</label><br>
            <div class="store-button-group d-flex justify-content-between">
                <button type="button" class="btn store-btn" data-store="store1">Store 1</button>
                <button type="button" class="btn store-btn" data-store="store2">Store 2</button>
                <button type="button" class="btn store-btn" data-store="store3">Store 3</button>
            </div>
            <div class="store-button-group mt-2">
                <button type="button" class="btn active-all" id="allStoresButton">All Stores</button>
            </div>
            <!-- Hidden checkboxes to store selection -->
            <input type="checkbox" name="stores[]" value="store_1" id="store1" class="d-none">
            <input type="checkbox" name="stores[]" value="store_2" id="store2" class="d-none">
            <input type="checkbox" name="stores[]" value="store_3" id="store3" class="d-none">
            <input type="checkbox" name="stores[]" value="all" id="allStores" class="d-none">
        </div>

        <button type="submit" class="btn btn-primary w-100">Save Fruit</button
        <button type="submit" class="btn btn-primary w-100">Save Fruit</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Toggle individual store buttons
    document.querySelectorAll('.store-btn').forEach(button => {
        button.addEventListener('click', function() {
            const storeCheckbox = document.getElementById(this.dataset.store);
            if (!storeCheckbox) {
                console.error(`Checkbox for ${this.dataset.store} not found`);
                return;
            }
            storeCheckbox.checked = !storeCheckbox.checked;
            this.classList.toggle('active', storeCheckbox.checked);
            
            // Uncheck 'All Stores' if any individual store is unchecked
            if (!storeCheckbox.checked) {
                document.getElementById('allStores').checked = false;
                document.getElementById('allStoresButton').classList.remove('active');
            } else {
                // Check if all individual store checkboxes are checked
                const allStoresSelected = Array.from(document.querySelectorAll('.store-btn')).every(btn => {
                    return document.getElementById(btn.dataset.store).checked;
                });
                document.getElementById('allStores').checked = allStoresSelected;
                document.getElementById('allStoresButton').classList.toggle('active', allStoresSelected);
            }
        });
    });

    // Toggle all stores button
    document.getElementById('allStoresButton').addEventListener('click', function() {
        const allChecked = !document.getElementById('allStores').checked;
        document.getElementById('allStores').checked = allChecked;
        this.classList.toggle('active', allChecked);

        // Check or uncheck all individual store buttons
        document.querySelectorAll('.store-btn').forEach(button => {
            const storeCheckbox = document.getElementById(button.dataset.store);
            storeCheckbox.checked = allChecked;
            button.classList.toggle('active', allChecked);
        });
    });
</script>
</body>
</html>

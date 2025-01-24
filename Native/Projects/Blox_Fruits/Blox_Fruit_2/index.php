<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select and Save Multiple Fruits - Gaming Style</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1c1c2b;
            color: #fff;
        }
        .container {
            max-width: 600px;
            background-color: #2d2d3e;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.4);
        }
        .fruit-list-table {
            margin-top: 15px;
            background-color: #3d3d5c;
            width: 100%;
            border-radius: 5px;
            overflow: hidden;
        }
        .fruit-list-table th, .fruit-list-table td {
        color: #ff4971; /* Ubah warna teks menjadi pink cerah */
        padding: 8px;
        border-bottom: 1px solid #2d2d3e;
        text-align: left;
        }
        .fruit-list-table th {
            background-color: #5c5ca3;
        }
        .fruit-list-table tr:last-child td {
            border-bottom: none;
        }
        .btn-primary {
            background-color: #c40233;
        }
        .btn-primary:hover {
            background-color: #e0002d;
        }
        .store-button-group .btn {
            width: 30%;
            margin-right: 2%;
            background-color: #3d3d5c;
            color: white;
            border: none;
        }
        .store-button-group .btn:hover, .store-button-group .btn.active {
            background-color: #5c5ca3;
        }
        .store-button-group .btn.active-all {
            width: 96%;
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
    <h3>Select Fruits to Store</h3>
    
    <!-- Form to select fruit and choose stores -->
    <form id="fruitForm" method="POST">
        <div class="mb-4">
            <label for="fruitDropdown" class="form-label">Select Fruit</label>
            <div class="input-group">
                <select id="fruitDropdown" class="form-select">
                    <option value="">Select a Fruit</option>
                    <?php
                    // Connect to the database
                    $mysqli = new mysqli('localhost', 'root', '', 'blox_fuit');
                    if ($mysqli->connect_error) {
                        die("Connection failed: " . $mysqli->connect_error);
                    }
                    $resultSet = $mysqli->query("SELECT fruit FROM stock");
                    while ($row = $resultSet->fetch_assoc()) {
                        echo "<option value='{$row['fruit']}'>{$row['fruit']}</option>";
                    }
                    $mysqli->close();
                    ?>
                </select>
                <button type="button" class="btn btn-primary" onclick="addFruit()">Add Fruit</button>
            </div>
        </div>

        <!-- List of selected fruits in table format -->
        <div class="fruit-list-table">
            <table class="table mb-0" id="selectedFruitsTable">
                <thead>
                    <tr>
                        <th>Selected Fruits</th>
                    </tr>
                </thead>
                <tbody id="selectedFruits">
                    <!-- Fruits will be appended here dynamically -->
                </tbody>
            </table>
        </div>

        <!-- Hidden input to store selected fruits -->
        <input type="hidden" name="selected_fruits" id="selectedFruitsInput">

        <div class="mb-4 mt-3">
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

        <button type="button" class="btn btn-primary w-100" onclick="submitForm()">Save Fruit</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const selectedFruits = [];

function addFruit() {
    const fruitDropdown = document.getElementById('fruitDropdown');
    const selectedFruit = fruitDropdown.value;

    if (selectedFruit && !selectedFruits.includes(selectedFruit)) {
        selectedFruits.push(selectedFruit);
        displaySelectedFruits();
        fruitDropdown.value = ''; // Reset dropdown
    }
}

function displaySelectedFruits() {
    const selectedFruitsTable = document.getElementById('selectedFruits');
    selectedFruitsTable.innerHTML = ''; // Clear existing content

    selectedFruits.forEach(fruit => {
        const row = document.createElement('tr'); // Create a new row
        const cell = document.createElement('td'); // Create a new cell for fruit name
        cell.innerHTML = fruit; // Set the fruit name inside the cell
        row.appendChild(cell); // Append cell to row
        selectedFruitsTable.appendChild(row); // Append row to table body
    });

    // Update hidden input field with JSON string of selected fruits
    document.getElementById('selectedFruitsInput').value = JSON.stringify(selectedFruits);
}


    function submitForm() {
        const formData = new FormData(document.getElementById('fruitForm'));
        
        // AJAX request to save_fruit.php
        fetch('save_fruit.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert(data); // Display success message
        })
        .catch(error => console.error('Error:', error));
    }
    
    // Toggle individual store buttons
    document.querySelectorAll('.store-btn').forEach(button => {
        button.addEventListener('click', function() {
            const storeCheckbox = document.getElementById(this.dataset.store);
            storeCheckbox.checked = !storeCheckbox.checked;
            this.classList.toggle('active', storeCheckbox.checked);
            
            if (!storeCheckbox.checked) {
                document.getElementById('allStores').checked = false;
                document.getElementById('allStoresButton').classList.remove('active');
            }
        });
    });

    // Toggle all stores button
    document.getElementById('allStoresButton').addEventListener('click', function() {
        const allChecked = !document.getElementById('allStores').checked;
        document.getElementById('allStores').checked = allChecked;
        this.classList.toggle('active', allChecked);

        document.querySelectorAll('.store-btn').forEach(button => {
            const storeCheckbox = document.getElementById(button.dataset.store);
            storeCheckbox.checked = allChecked;
            button.classList.toggle('active', allChecked);
        });
    });
</script>
</body>
</html>

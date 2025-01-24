<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih dan Simpan Beberapa Buah</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #C2FFC7;
            color: #526E48;
        }

        .container {
            max-width: 600px;
            background-color: #9EDF9C;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.4);
        }

        h3{
            text-align: center;
        }
        .form-select {
            background-color: #62825D;
            color: #C2FFC7;
            border-color: #62825D;
        }

        .fruit-list-table {
            margin-top: 15px;
            background-color: #3d3d5c;
            width: 100%;
            border-radius: 5px;
            overflow: hidden;
        }

        .fruit-list-table th,
        .fruit-list-table td {
            background-color: #62825D;
            color: #C2FFC7;
            padding: 8px;
            border: 2px solid #C2FFC7;
            text-align: left;
        }

        .fruit-list-table th {
            background-color: #526E48;
        }

        .fruit-list-table tr:last-child td {
            border-bottom: none;
        }

        .btn-primary {
            background-color: #62825D;
            color: #C2FFC7;
            border: none;
        }

        .btn-primary:hover {
            background-color: #526E48;
            border-color: #C2FFC7;
        }

        .store-button-group .btn {
            width: 30%;
            margin-right: 2%;
            background-color: #62825D;
            color: #C2FFC7;
            border: none;
        }

        .store-button-group .btn:hover,
        .store-button-group .btn.active {
            background-color: #526E48;
            border-color: #C2FFC7;
        }

        .store-button-group .btn.active-all {
            width: 100%;
            margin-top: 10px;
            background-color: #62825D;
            color: #C2FFC7;
            border: none;
        }

        .store-button-group .btn.active-all:hover,
        .store-button-group .btn.active-all.active {
            background-color: #526E48;
            border-color: #C2FFC7;
        }
    </style>
</head>

<body>
    <br>
    <br>
    <h3>Piihlah Beberapa Buah ke dalam Tabel Buah</h3>
    <div class="container my-5">
        <!-- Form to select fruit and choose stores -->
        <form id="fruitForm" method="POST">
            <div class="mb-4">
                <label for="fruitDropdown" class="form-label">Pilih Buah</label>
                <div class="input-group">
                    <select id="fruitDropdown" class="form-select">
                        <option value="">Pilihlah Beberapa Buah</option>
                        <?php
                        // Connect to the database
                        $mysqli = new mysqli('localhost', 'root', '', 'db_buah');
                        if ($mysqli->connect_error) {
                            die("Connection failed: " . $mysqli->connect_error);
                        }
                        $resultSet = $mysqli->query("SELECT nama_buah FROM stok_buah");
                        while ($row = $resultSet->fetch_assoc()) {
                            echo "<option value='{$row['nama_buah']}'>{$row['nama_buah']}</option>";
                        }
                        $mysqli->close();
                        ?>
                    </select>
                    <button type="button" class="btn btn-primary" onclick="addFruit()">Tambah Buah</button>
                </div>
            </div>

            <!-- List of selected fruits in table format -->
            <div class="fruit-list-table">
                <table class="table mb-0" id="selectedFruitsTable">
                    <thead>
                        <tr>
                            <th>Buah Terpilih</th>
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
                <label class="form-label">Pilihlah Tabel untuk Meyimpan</label><br>
                <div class="store-button-group d-flex justify-content-between">
                    <button type="button" class="btn store-btn" data-store="store1">Tabel Buah 1</button>
                    <button type="button" class="btn store-btn" data-store="store2">Tabel Buah 2</button>
                    <button type="button" class="btn store-btn" data-store="store3">Tabel Buah 3</button>
                </div>
                <div class="store-button-group mt-2">
                    <button type="button" class="btn active-all" id="allStoresButton">Semua Tabel Buah</button>
                </div>
                <!-- Hidden checkboxes to store selection -->
                <input type="checkbox" name="stores[]" value="store_1" id="store1" class="d-none">
                <input type="checkbox" name="stores[]" value="store_2" id="store2" class="d-none">
                <input type="checkbox" name="stores[]" value="store_3" id="store3" class="d-none">
                <input type="checkbox" name="stores[]" value="all" id="allStores" class="d-none">
            </div>

            <button type="button" class="btn btn-primary w-100" onclick="submitForm()">Simpan Buah Terpilih</button>
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
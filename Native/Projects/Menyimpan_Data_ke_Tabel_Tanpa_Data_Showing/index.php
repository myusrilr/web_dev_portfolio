<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih dan Simpan Buah</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Styles -->
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
        .form-label, h3 {
            color: #526E48;
        }
        .form-select, .btn-primary {
            background-color: #62825D; 
            color: #C2FFC7;
            border: none;
        }
        .btn-primary:hover {
            background-color: #C2FFC7 
        }
        .btn-primary {
            background-color: #62825D; 
        }
        .btn-primary:hover {
            background-color: #526E48; 
        }
        h3 {
            color: #526E48; 
            text-align: center;
            margin-bottom: 20px;
        }
        .store-button-group .btn {
            width: 30%; 
            margin-right: 2%;
            background-color: #62825D;
            color: #C2FFC7;
            border: none;
        }
        .store-button-group .btn:hover, .store-button-group .btn.active {
            background-color: #526E48;
        }
        .store-button-group .btn.active-all {
            width: 100%; 
            margin-top: 10px;
            background-color: #62825D;
            color: #C2FFC7;
            border: none;
        }
        .store-button-group .btn.active-all:hover, .store-button-group .btn.active-all.active {
            background-color: #526E48;
        }
    </style>
</head>
<body>
    <br>
    <br>
<h3>Pilihlahlah Salah Satu Buah ke dalam Tabel Buah</h3>
<div class="container my-5">
    <!-- Form to select fruit and choose stores -->
    <form id="fruitForm" action="save_fruit.php" method="POST">
        <div class="mb-4">
            <label for="fruitDropdown" class="form-label">Pilih Buah</label>
            <select id="fruitDropdown" name="fruit_name" class="form-select" required>
                <option value="">Pilihlah Salah Satu Buah</option>
                <?php
                // Connect to the database
                $mysqli = new mysqli('localhost', 'root', '', 'db_buah');
                if ($mysqli->connect_error) {
                    die("Connection failed: " . $mysqli->connect_error);
                }
                // Fetch fruits from the database
                $resultSet = $mysqli->query("SELECT nama_buah FROM stok_buah");
                while ($row = $resultSet->fetch_assoc()) {
                    echo "<option value='{$row['nama_buah']}'>{$row['nama_buah']}</option>";
                }
                $mysqli->close();
                ?>
            </select>
        </div>
        
        <div class="mb-4">
            <label class="form-label">Pilihlah Salah Satu atau Beberapa Tabel Buah</label><br>
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

        <button type="submit" class="btn btn-primary w-100">Simpan Pilihan Buah</button
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

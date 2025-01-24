<?php
// Mulai sesi
session_start();

// Sertakan koneksi database
include 'connect.php';

// Periksa apakah pengguna telah login
if (!isset($_SESSION['username'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
    exit();
}

// Periksa apakah formulir telah disubmit
if (isset($_POST['submit'])) {
    // Ambil data dari formulir dengan pemeriksaan isset atau menggunakan null coalescing operator
    $user1 = trim($_POST['user1'] ?? '');
    $user2 = trim($_POST['user2'] ?? '');
    $user3 = trim($_POST['user3'] ?? '');
    $tugas = trim($_POST['tugas'] ?? '');
    $waktu = trim($_POST['waktu'] ?? '');

    // Validasi bahwa tugas dan waktu tidak kosong
    if (empty($tugas) || empty($waktu)) {
        echo "<div class='alert alert-danger'>Tugas dan Waktu tidak boleh kosong.</div>";
    } else {
        // Array untuk menyimpan nama pengguna yang diisi
        $usernames = [];

        if (!empty($user1)) {
            $usernames[] = $user1;
        }
        if (!empty($user2)) {
            $usernames[] = $user2;
        }
        if (!empty($user3)) {
            $usernames[] = $user3;
        }

        // Jika tidak ada user yang diisi
        if (empty($usernames)) {
            echo "<div class='alert alert-danger'>Silakan isi setidaknya satu nama pengguna.</div>";
        } else {
            // Tetapkan nilai default untuk status dan catatan
            $tahapan = 'belum';
            $catatan = 'tidak ada catatan';

            // Loop melalui setiap username yang diinput dan masukkan data ke tabel yang sesuai
            foreach ($usernames as $username) {
                // Cari urutan username di tabel `main` dengan hak akses 'user'
                $sql = "SELECT id FROM main WHERE username = ? AND hak_akses = 'user'";
                if ($stmt = $conn->prepare($sql)) {
                    $stmt->bind_param("s", $username);
                    $stmt->execute();
                    $stmt->bind_result($id);
                    $stmt->fetch();
                    $stmt->close();

                    // Tentukan nama tabel berdasarkan urutan (misalnya user1, user2, ...)
                    if ($id) {
                        $tableIndex = $id - 3; // Asumsikan user mulai dari id 4
                        $tableName = "user" . $tableIndex;

                        // Siapkan pernyataan SQL untuk memasukkan data ke tabel pengguna yang sesuai
                        $sqlInsert = "INSERT INTO `$tableName` (username, tugas, tahapan, waktu, catatan) VALUES (?, ?, ?, ?,?)";
                        if ($stmtInsert = $conn->prepare($sqlInsert)) {
                            $stmtInsert->bind_param("sssss", $username, $tugas, $tahapan, $waktu, $catatan);

                            if ($stmtInsert->execute()) {
                                echo "<div class='alert alert-success'>Tugas berhasil ditambahkan ke tabel $tableName untuk nama pengguna $username.</div>";
                            } else {
                                echo "<div class='alert alert-danger'>Error saat memasukkan data ke tabel $tableName: " . $stmtInsert->error . "</div>";
                            }
                            $stmtInsert->close();
                        } else {
                            echo "<div class='alert alert-danger'>Error saat menyiapkan pernyataan untuk tabel $tableName: " . $conn->error . "</div>";
                        }
                    } else {
                        echo "<div class='alert alert-danger'>Username $username tidak ditemukan atau tidak memiliki hak akses yang sesuai.</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>Error saat mencari urutan untuk pengguna $username: " . $conn->error . "</div>";
                }
            }
        }
    }
}
?>




<!DOCTYPE html>
<html>

<head>
    <title>Homepage</title>
    <!-- Sertakan CSS Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <!-- Custom fonts for this template-->
    <link href="./assets/css/sb-admin-2.css" rel="stylesheet" type="text/css">
    <link href="./assets/css/sb-admin-2.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/5a2597d9e6.js" crossorigin="anonymous"></script>
</head>

<body style="background-color: #C2FFC7;">
    <!-- Topbar -->
    <nav class="navbar navbar-expand navbar-light topbar mb-4 static-top shadow" style="background-color: #9EDF9C;">

        <!-- Sidebar Toggle (Topbar) -->
        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
        </button>

        <!-- Topbar Search -->
        <form
            class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
                <input type="text" class="form-control border-0 small" placeholder="Search for..."aria-label="Search" aria-describedby="basic-addon2" style="background-color: #62825D; color:#9EDF9C;">
                <div class="input-group-append">
                    <button class="btn" type="button" style="background-color: #526E48;">
                    <img src="./assets/img/search.png" style="height: 20px; width:auto;" alt="search">
                    </button>
                </div>
            </div>
        </form>

        <!-- Topbar Navbar -->
        <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
                <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="./assets/img/search.png" style="height: 20px; width:auto;" alt="search">
                </a>
                <!-- Dropdown - Messages -->
                <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                    aria-labelledby="searchDropdown">
                    <form class="form-inline mr-auto w-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small"
                                placeholder="Search for..." aria-label="Search"
                                aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                <img src="./assets/img/search.png" style="height: 20px; width:auto;" alt="search">
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>

            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="./assets/img/bell.png" style="height: 20px; width:auto;" alt="email">
                    <!-- Counter - Alerts -->
                    <span class="badge badge-danger badge-counter">3+</span>
                </a>
                <!-- Dropdown - Alerts -->
                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in bg-succes"
                    aria-labelledby="alertsDropdown">
                    <h6 class="dropdown-header bg-succes">
                        Alerts Center
                    </h6>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="mr-3">
                            <div class="icon-circle bg-primary">
                                <i class="fas fa-file-alt text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500">December 12, 2019</div>
                            <span class="font-weight-bold">A new monthly report is ready to download!</span>
                        </div>
                    </a>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="mr-3">
                            <div class="icon-circle bg-success">
                                <i class="fas fa-donate text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500">December 7, 2019</div>
                            $290.29 has been deposited into your account!
                        </div>
                    </a>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="mr-3">
                            <div class="icon-circle bg-warning">
                                <i class="fas fa-exclamation-triangle text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500">December 2, 2019</div>
                            Spending Alert: We've noticed unusually high spending for your account.
                        </div>
                    </a>
                    <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                </div>
            </li>

            <!-- Nav Item - Messages -->
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="./assets/img/email.png" style="height: 20px; width:auto;" alt="email">
                    <!-- Counter - Messages -->
                    <span class="badge badge-danger badge-counter">7</span>
                </a>
                <!-- Dropdown - Messages -->
                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                    aria-labelledby="messagesDropdown">
                    <h6 class="dropdown-header">
                        Message Center
                    </h6>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="./assets/img/undraw_profile_1.svg"
                                alt="...">
                            <div class="status-indicator bg-success"></div>
                        </div>
                        <div class="font-weight-bold">
                            <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                problem I've been having.</div>
                            <div class="small text-gray-500">Emily Fowler · 58m</div>
                        </div>
                    </a>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="./assets/img/undraw_profile_2.svg"
                                alt="...">
                            <div class="status-indicator"></div>
                        </div>
                        <div>
                            <div class="text-truncate">I have the photos that you ordered last month, how
                                would you like them sent to you?</div>
                            <div class="small text-gray-500">Jae Chun · 1d</div>
                        </div>
                    </a>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="./assets/img/undraw_profile_3.svg"
                                alt="...">
                            <div class="status-indicator bg-warning"></div>
                        </div>
                        <div>
                            <div class="text-truncate">Last month's report looks great, I am very happy with
                                the progress so far, keep up the good work!</div>
                            <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                        </div>
                    </a>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="./assets/img/undraw_profile_3.svg"

                                alt="...">
                            <div class="status-indicator bg-success"></div>
                        </div>
                        <div>
                            <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                                told me that people say this to all dogs, even if they aren't good...</div>
                            <div class="small text-gray-500">Chicken the Dog · 2w</div>
                        </div>
                    </a>
                    <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline small" style="color: #526E48;">Douglas McGee</span>
                    <img class="img-profile rounded-circle"
                        src="./assets/img/undraw_profile.svg">
                </a>
                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                    aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                        Profile
                    </a>
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                        Settings
                    </a>
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                        Activity Log
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="logout.php">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </a>
                </div>
            </li>

        </ul>

    </nav>
    <!-- End of Topbar -->

    <div class="container col-6" style="background-color: #C2FFC7;">
        <h2 class="mt-5 text-center" style="color: #526E48;">Halaman Admin </h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="user1" style="color: #526E48;">Nama Pengguna untuk User1</label>
                <input type="text" class="form-control" id="user1" name="user1" placeholder="Masukkan nama untuk User1" style="background-color: #9EDF9C; border-color: #9EDF9C; color: #526E48">
            </div>
            <div class="form-group">
                <label for="user2" style="color: #526E48;">Nama Pengguna untuk User2</label>
                <input type="text" class="form-control" id="user2" name="user2" placeholder="Masukkan nama untuk User2" style="background-color: #9EDF9C; border-color: #9EDF9C; color: #526E48">
            </div>
            <div class="form-group">
                <label for="user3" style="color: #526E48;">Nama Pengguna untuk User3</label>
                <input type="text" class="form-control" id="user3" name="user3" placeholder="Masukkan nama untuk User3" style="background-color: #9EDF9C; border-color: #9EDF9C; color: #526E48">
            </div>
            <div class="form-group">
                <label for="tugas" style="color: #526E48;">Tugas</label>
                <textarea type="text" class="form-control" id="tugas" name="tugas" required style="background-color: #9EDF9C; border-color: #9EDF9C; color: #526E48"></textarea>
            </div>
            <div class="form-group">
                <label for="waktu" style="color: #526E48;">Waktu</label>
                <input type="datetime-local" class="form-control" id="waktu" name="waktu" required style="background-color: #9EDF9C; border-color: #9EDF9C; color: #526E48">
            </div>
            <button type="submit" name="submit" class="btn" style="background-color: #9EDF9C; color: #526E48;">Submit</button>
        </form>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="./assets/js/sb-admin-2.js"></script>
    <script src="./assets/js/sb-admin-2.min.js"></script>


    <!-- Sertakan JS Bootstrap dan dependensinya (opsional untuk beberapa komponen) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
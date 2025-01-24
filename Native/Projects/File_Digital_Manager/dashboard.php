<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.2/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            /* Background image */
            background-image: url('Assets/img/DashboardBg.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            /* Background tetap saat scroll */
            background-repeat: no-repeat;
        }

        a.navbar-brand img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            margin-right: 10px;
        }

        .navbar {
            z-index: 1030;
            /* Pastikan navbar selalu di atas */
        }

        h1 {
            margin: 0;
            /* Hilangkan margin h1 agar posisinya tepat di tengah */
        }

        .profile-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }

        /* Tombol berjarak dengan opacity di hover */
        .btn-custom {
            transition: opacity 0.3s ease;
        }

        .btn-custom:hover {
            opacity: 0.8;
            /* Efek hover */
        }

        .dropdown-menu {
            width: 300px;
        }

        .dropdown-menu .profile-header {
            display: flex;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #eaeaea;
        }

        .dropdown-menu .profile-header img {
            margin-right: 10px;
        }

        .dropdown-menu .profile-header .info {
            line-height: 1.2;
        }

        .dropdown-menu .profile-header .info span {
            font-size: 14px;
        }

        .dropdown-menu .profile-header .info small {
            font-size: 12px;
        }

        .dropdown-menu .dropdown-item i {
            margin-right: 10px;
        }

        .table-container {
            background-color: rgba(255, 255, 255, 0.8);
            /* Putih dengan transparansi */
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            /* Bayangan lembut */
        }

        .table th,
        .table td {
            text-align: center;
            /* Text di tengah */
            vertical-align: middle;
        }

        .modal-content {
            background-color: rgba(255, 255, 255, 0.9);
            /* Modal transparan */
        }
    </style>
</head>

<body>
    <?php
    session_start();
    include 'db.php'; // Menghubungkan ke database

    if (!isset($_SESSION['username'])) {
        // Redirect jika belum login
        header("Location: index.php");
        exit();
    }
    // Ambil username dan tipe akun dari session
    $username = $_SESSION['username'];
    $account_type = $_SESSION['account_type']; // Pastikan session ini sudah diset

    // Tentukan URL gambar profil berdasarkan tipe akun
    $profile_image_url = ''; // Inisialisasi URL gambar
    if ($account_type === 'public') {
        $profile_image_url = 'Assets/img/public_profile_image.jpg'; // Gambar untuk akun Public
    } elseif ($account_type === 'private') {
        $profile_image_url = 'Assets/img/private_profile_image.png'; // Gambar untuk akun Private
    } elseif ($account_type === 'protected') {
        $profile_image_url = 'Assets/img/protected_profile_image.jpg'; // Gambar untuk akun Protected
    }
    ?>
    <nav class="navbar navbar-expand-lg bg-body-tertiary bg-primary fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="Assets/img/fileSphere.png" alt=""></a>
            <form class="d-flex align-items-center ms-auto" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?php echo $profile_image_url; ?>" alt="Profile Image" class="profile-icon" width="30" height="30">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end text-small shadow" aria-labelledby="profileDropdown">
                        <li class="profile-header text-center p-3">
                            <img src="<?php echo $profile_image_url; ?>" alt="Profile Image" class="profile-icon mb-2" width="50" height="50">
                            <div class="info">
                                <span>
                                    <?php
                                    if ($account_type === 'public') {
                                        echo "Email anda: muhammad@gmail.com";
                                        echo "<br>";
                                        echo "Selamat datang, pengguna dengan akun <strong>Public</strong>.";
                                    } elseif ($account_type === 'private') {
                                        echo "Email anda: yusril@gmail.com";
                                        echo "<br>";
                                        echo "Selamat datang, pengguna dengan akun <strong>Private</strong>.";
                                    } elseif ($account_type === 'protected') {
                                        echo "Email anda: romadhoni@gmail.com";
                                        echo "<br>";
                                        echo "Selamat datang, pengguna dengan akun <strong>Protected</strong>.";
                                    }
                                    ?>
                                </span>
                            </div>
                        </li>
                        <li><a class="dropdown-item" href="logout.php"><i class="bi bi-box-arrow-right"></i> Sign out</a></li>
                    </ul>
                </div>
            </form>
        </div>
    </nav>

    <?php
    $account_type = $_SESSION['account_type']; // Ambil level akun pengguna

    // Query dasar untuk mengambil file
    $query = "SELECT files.*, users.username FROM files JOIN users ON files.uploaded_by = users.id WHERE 1=1";

    // Cek apakah filter diterapkan, dan tambahkan kondisi ke query
    if (isset($_GET['access_type']) && !empty($_GET['access_type'])) {
        $access_type = $_GET['access_type'];
        $query .= " AND files.account_type = '$access_type'";
    }

    if (isset($_GET['document_status']) && !empty($_GET['document_status'])) {
        $document_status = $_GET['document_status'];
        $query .= " AND files.document_status = '$document_status'";
    }

    if (isset($_GET['file_name']) && !empty($_GET['file_name'])) {
        $file_name = $_GET['file_name'];
        $query .= " AND files.file_name LIKE '%$file_name%'";
    }

    if (isset($_GET['document_id']) && !empty($_GET['document_id'])) {
        $document_id = $_GET['document_id'];
        $query .= " AND files.document_id = '$document_id'";
    }

    if (isset($_GET['file_type']) && !empty($_GET['file_type'])) {
        $file_type = $_GET['file_type'];

        // Penyesuaian MIME type atau jenis file dengan tabel SQL yang Anda unggah
        switch ($file_type) {
            case 'image':
                $query .= " AND files.file_type IN ('image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/svg+xml', 'image/webp')";
                break;
            case 'pdf':
                $query .= " AND files.file_type = 'application/pdf'";
                break;
            case 'docx':
                $query .= " AND files.file_type IN ('application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/msword', 'text/plain')";
                break;
            case 'xlsx':
                $query .= " AND files.file_type = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'";
                break;
            case 'ppt':
                $query .= " AND files.file_type = 'application/vnd.openxmlformats-officedocument.presentationml.presentation'";
                break;
            case 'epub':
                $query .= " AND files.file_type = 'application/epub+zip'";
                break;
            case 'link':
                $query .= " AND files.file_type = 'text/html'";
                break;
            default:
                $query .= " AND files.file_type = '$file_type'";
                break;
        }
    }

    if (isset($_GET['upload_time']) && !empty($_GET['upload_time'])) {
        $upload_time = $_GET['upload_time'];
        $query .= " AND DATE(files.upload_time) = DATE('$upload_time')";
    }

    // Tambahkan pengurutan berdasarkan waktu unggah terbaru
    $query .= " ORDER BY files.upload_time DESC";

    // Eksekusi query
    $result = $conn->query($query);
    ?>


    <div class="container mt-5 content" style="padding-top: 100px;">
        <h1 class="text-center text-primary mx-auto mb-3 mt-10">Beranda Pengelola Berkas</h1>
        <!-- Tombol Unggah -->
        <div class="d-flex justify-content-between mb-3 gap-2">
            <button type="button" class="btn btn-primary btn-custom" data-bs-toggle="modal" data-bs-target="#uploadModal">
                <i class="bi bi-upload"></i> Unggah
            </button>

            <!-- Fitur Filter -->
            <form action="dashboard.php" method="GET" class="d-flex gap-2">
                <!-- Dropdown Hak Akses -->
                <select class="form-select" name="access_type">
                    <option value="">Hak Akses</option>
                    <option value="public">public</option>
                    <option value="private">private</option>
                    <option value="protected">protected</option>
                </select>

                <!-- Dropdown Visibilitas -->
                <select class="form-select" name="document_status">
                    <option value="">Visibilitas</option>
                    <option value="viewed">viewed</option>
                    <option value="archived">archived</option>
                    <option value="deleted">deleted</option>
                </select>

                <!-- Input Nama File -->
                <input type="text" class="form-control" name="file_name" placeholder="Nama Berkas">

                <!-- Input Document ID -->
                <input type="text" class="form-control" name="document_id" placeholder="No. Berkas">

                <!-- Dropdown Jenis File -->
                <select class="form-select" name="file_type">
                    <option value="">Jenis Berkas</option>
                    <option value="image">Image</option>
                    <option value="pdf">PDF</option>
                    <option value="docx">DOCX</option>
                    <option value="link">Link</option>
                    <option value="xlsx">XLSX</option>
                    <option value="ppt">PPT</option>
                    <option value="epub">EPUB</option>
                </select>

                <!-- Input Waktu Unggah -->
                <input type="datetime-local" class="form-control" name="upload_time" placeholder="Waktu Unggah">

                <!-- Tombol Cari -->
                <button type="submit" class="btn btn-primary btn-custom">
                    <i class="bi bi-search"></i> Cari
                </button>
            </form>
        </div>

        <!-- Modal untuk unggah file -->
        <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Nomor Berkas: <span id="generatedDocumentId"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="uploadForm" action="upload_file.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">

                            <!-- Hidden input untuk menyimpan Document ID yang dihasilkan -->
                            <input type="hidden" name="document_id" id="document_id_hidden">

                            <!-- Nama File -->
                            <div class="mb-3">
                                <label for="fileName" class="form-label">Nama Berkas</label>
                                <input type="text" class="form-control" id="fileName" name="file_name" placeholder="Masukkan Nama File Anda disini">
                            </div>

                            <!-- Akses -->
                            <div class="mb-3">
                                <label for="accountType" class="form-label">Akses</label>
                                <select class="form-select" id="accountType" name="account_type" disabled required>
                                    <option value="public">Public</option>
                                    <option value="private">Private</option>
                                    <option value="protected">Protected</option>
                                </select>
                            </div>

                            <!-- Icon Jenis File -->
                            <div class="mb-3">
                                <label for="fileType" class="form-label">Jenis Berkas</label>
                                <div class="row">
                                    <div class="col-6 d-flex align-items-center mt-2">
                                        <button type="button" id="fileTypeImage" class="btn btn-outline-secondary file-type-btn" data-filetype="image" data-accept=".jpg, .png, .jpeg" disabled>
                                            <i class="bi bi-file-earmark-image fs-1"></i><span class="ms-2 fs-2">Image</span>
                                        </button>
                                    </div>
                                    <div class="col-6 d-flex align-items-center">
                                        <button type="button" id="fileTypePdf" class="btn btn-outline-secondary file-type-btn" data-filetype="pdf" data-accept=".pdf" disabled>
                                            <i class="bi bi-file-earmark-pdf fs-1"></i><span class="ms-2 fs-2">PDF</span>
                                        </button>
                                    </div>
                                    <div class="col-6 d-flex align-items-center">
                                        <button type="button" id="fileTypeDocx1" class="btn btn-outline-secondary file-type-btn" data-filetype="docx" data-accept=".docx, .txt" disabled>
                                            <i class="bi bi-file-earmark-word fs-1"></i><span class="ms-2 fs-2">DOCX</span>
                                        </button>
                                    </div>
                                    <div class="col-6 d-flex align-items-center">
                                        <button type="button" id="fileTypeLink" class="btn btn-outline-secondary file-type-btn" data-filetype="link" data-accept=".url, .html, .webp" disabled>
                                            <i class="bi bi-link fs-1"></i><span class="ms-2 fs-2">LINK</span>
                                        </button>
                                    </div>
                                    <div class="col-6 d-flex align-items-center mt-2">
                                        <button type="button" id="fileTypeXlsx" class="btn btn-outline-secondary file-type-btn" data-filetype="xlsx" data-accept=".xlsx" disabled>
                                            <i class="bi bi-file-earmark-excel fs-1"></i><span class="ms-2 fs-2">XLSX</span>
                                        </button>
                                    </div>
                                    <div class="col-6 d-flex align-items-center mt-2">
                                        <button type="button" id="fileTypePpt" class="btn btn-outline-secondary file-type-btn" data-filetype="ppt" data-accept=".pptx, .ppt, .potx" disabled>
                                            <i class="bi bi-file-earmark-ppt fs-1"></i><span class="ms-2 fs-2">PPT</span>
                                        </button>
                                    </div>
                                    <div class="col-6 d-flex align-items-center mt-2">
                                        <button type="button" id="fileTypeEpub" class="btn btn-outline-secondary file-type-btn" data-filetype="epub" data-accept=".epub" disabled>
                                            <i class="bi bi-journal fs-1"></i><span class="ms-2 fs-2">e-PUB</span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Browse File -->
                            <div class="mb-3">
                                <label for="fileUpload" class="form-label">Telusuri Berkas</label>
                                <input class="form-control" type="file" id="fileUpload" name="file" disabled required>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="button" class="btn btn-success" id="uploadButton" data-bs-toggle="modal" data-bs-target="#confirmUploadModal">Unggah</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal untuk konfirmasi unggah file -->
        <div class="modal fade" id="confirmUploadModal" tabindex="-1" aria-labelledby="confirmUploadModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Unggah Berkas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="uploadForm" action="upload_file.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            <p><strong>Nama Berkas:</strong> <span id="confirmFileName"></span></p>
                            <p><strong>Nomor Berkas:</strong> <span id="confirmDocumentId"></span></p>
                            <p><strong>Nama Pengunggah:</strong> <span id="confirmUploaderName">Yusril</span></p>
                            <p><strong>Tipe Pengunggah:</strong> <span id="confirmAccountType"></span></p>
                            <p><strong>Waktu Unggah:</strong> <span id="confirmUploadTime"></span></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success" id="confirmUploadButton">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Tabel Bootstrap untuk menampilkan file yang diunggah -->
        <td>
            <div class="table-container">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th rowspan="2">Nomor</th>
                                <th colspan="6">Berkas</th>
                                <th colspan="2">Pengunggah</th>
                                <th colspan="4">Aksi</th>
                            </tr>
                            <tr>
                                <th>Nomor</th>
                                <th>Nama</th>
                                <th>Jenis</th>
                                <th>Ukuran</th>
                                <th>Visibilitas</th>
                                <th>Waktu Unggah</th>
                                <th>Nama</th>
                                <th>Tipe</th>
                                <th>Prantinjau</th>
                                <th>Arsip</th>
                                <th>Unduh</th>
                                <th>Hapus</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $num = 1; // Inisialisasi nomor urut file
                            while ($row = $result->fetch_assoc()) {
                                $file_id = $row['document_id'];
                                $file_name = $row['file_name'];
                                $file_type = $row['file_type'];
                                $file_size = $row['file_size'];
                                $uploaded_by = $row['username'];
                                $account_type_file = $row['account_type']; // Level akses file
                                $document_status = $row['document_status']; // Status file (viewed, archived, deleted)
                                $upload_time = $row['upload_time'];
                                $file_path = $row['file_path']; // Lokasi file untuk preview

                                // Tentukan apakah pengguna bisa melakukan aksi pada file berdasarkan level akun
                                $can_download = (
                                    ($account_type == 'public' && $account_type_file == 'public') ||
                                    ($account_type == 'private' && ($account_type_file == 'public' || $account_type_file == 'private')) ||
                                    $account_type == 'protected'
                                );
                            ?>
                                <tr>
                                    <td><?php echo $num++; ?></td>
                                    <td><?php echo $file_id; ?></td>
                                    <td><?php echo $file_name; ?></td>
                                    <td>
                                        <?php
                                        // Menampilkan icon berdasarkan tipe file (MIME type)
                                        switch ($file_type) {
                                            case 'application/pdf':
                                                echo '<i class="bi bi-file-earmark-pdf"></i> PDF';
                                                break;
                                            case "application/vnd.openxmlformats-officedocument.wordprocessingml.document":
                                            case 'application/msword':
                                            case 'text/plain':
                                            case 'application/vnd.openxmlformats-officedocument.wordprocessingml.template':
                                            case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document-template':
                                            case 'application/vnd.openxmlformats-officedocument.wordprocessingml.template-main':
                                            case 'application/vnd.openxmlformats-officedocument.wordprocessingml.template-main-document':

                                                echo '<i class="bi bi-file-earmark-word"></i> DOCX';
                                                break;
                                            case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
                                                echo '<i class="bi bi-file-earmark-excel"></i> XLSX';
                                                break;
                                            case 'image/jpeg':
                                            case 'image/png':
                                            case 'image/gif':
                                            case 'image/webp':
                                                echo '<i class="bi bi-file-earmark-image"></i> Image';
                                                break;
                                            case 'application/vnd.openxmlformats-officedocument.presentationml.presentation':
                                                echo '<i class="bi bi-file-earmark-ppt"></i> PPT';
                                                break;
                                            case 'application/epub+zip':
                                                echo '<i class="bi bi-file-earmark-text"></i> EPUB';
                                                break;
                                            default:
                                                echo '<i class="bi bi-file-earmark"></i> File';
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $file_size; ?> KB</td>
                                    <td>
                                        <?php
                                        // Menampilkan status dokumen (viewed, archived, deleted)
                                        switch ($document_status) {
                                            case 'viewed':
                                                echo '<span class="badge text-dark">viewed</span>';
                                                break;
                                            case 'archived':
                                                echo '<span class="badge text-dark">archived</span>';
                                                break;
                                            case 'deleted':
                                                echo '<span class="badge text-secondary">deleted</span>';
                                                break;
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $upload_time; ?></td>
                                    <td><?php echo $uploaded_by; ?></td>
                                    <td>
                                        <?php
                                        // Menampilkan tipe akses file
                                        switch ($account_type_file) {
                                            case 'public':
                                                echo '<span class="badge bg-dark">public</span>';
                                                break;
                                            case 'private':
                                                echo '<span class="badge bg-primary text-light">private</span>';
                                                break;
                                            case 'protected':
                                                echo '<span class="badge bg-danger text-light">protected</span>';
                                                break;
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <!-- Aksi Pratinjau -->
                                        <a href="#" class="btn btn-info btn-custom preview-btn text-light" data-bs-toggle="modal" data-bs-target="#previewModal" data-filepath="<?php echo $file_path; ?>" data-filetype="<?php echo $file_type; ?>">
                                            <i class="bi bi-zoom-in"></i> Pratinjau
                                        </a>
                                    </td>
                                    <td>
                                        <!-- Aksi Archieved -->
                                        <button type="button" class="btn btn-secondary btn-custom" data-bs-toggle="modal" data-bs-target="#archieveModal" data-file-id="<?php echo $row['id']; ?>" data-file-type="<?php echo $row['account_type']; ?>">
                                            <i class="bi bi-archive"></i> Arsipkan
                                        </button>
                                    </td>
                                    <td>
                                        <!-- Aksi download -->
                                        <a href="<?php echo $row['file_path']; ?>" class="btn btn-primary btn-custom" download>
                                            <i class="bi bi-download"></i> Unduh
                                        </a>
                                    </td>
                                    <td>
                                        <!-- Aksi hapus file -->
                                        <form action="delete_file.php" method="POST" id="deleteForm">
                                            <input type="hidden" name="file_id" value="<?php echo $row['id']; ?>">
                                            <button type="button" class="btn btn-danger btn-custom" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                        </tbody>
                    <?php } ?>
                    </table>
                </div>
            </div>
        </td>

        <!-- Modal untuk pratinjau berbagai macam berkas(semua tipe akun bisa mangakses) -->
        <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="previewModalLabel">Preview File</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Konten untuk preview file -->
                        <div id="previewContent">
                            <!-- Konten preview akan diisi oleh JavaScript berdasarkan jenis file -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Pop-up 2-step Verifikasi Mengarsipkan Berkas -->
        <div class="modal fade" id="archieveModal" tabindex="-1" aria-labelledby="archieveModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="archieveModalLabel">2-Step Verification</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="archieveForm">
                            <!-- Email Input -->
                            <div class="form-outline mb-4">
                                <label class="form-label" for="email"><i class="bi bi-envelope-fill"></i> Email</label>
                                <input type="email" id="email" name="email" class="form-control form-control-lg py-3" placeholder="Masukkan email" required />
                            </div>

                            <!-- Password Input -->
                            <div class="form-outline mb-4 position-relative">
                                <label class="form-label" for="password"><i class="bi bi-lock-fill"></i> Password</label>
                                <input type="password" id="password" name="password" class="form-control form-control-lg py-3" placeholder="Masukkan password" required />
                                <span class="position-absolute" style="top: 50%; right: 15px; cursor: pointer;">
                                    <i id="togglePassword" class="bi bi-eye-fill fs-4"></i>
                                </span>
                            </div>

                            <input type="hidden" id="fileId" name="file_id" value="">
                            <input type="hidden" id="fileType" name="file_type" value="">

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Verifikasi dan Arsipkan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Verifikasi Hapus -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="archieveModalLabel">2-Step Verification Penghapusan Berkas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="archieveForm">
                        <!-- Email Input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="email"><i class="bi bi-envelope-fill"></i> Email</label>
                            <input type="email" id="email" name="email" class="form-control form-control-lg py-3" placeholder="Masukkan email" required />
                        </div>

                        <!-- Password Input -->
                        <div class="form-outline mb-4 position-relative">
                            <label class="form-label" for="password"><i class="bi bi-lock-fill"></i> Password</label>
                            <input type="password" id="password" name="password" class="form-control form-control-lg py-3" placeholder="Masukkan password" required />
                            <span class="position-absolute" style="top: 50%; right: 15px; cursor: pointer;">
                                <i id="togglePassword" class="bi bi-eye-fill fs-4"></i>
                            </span>
                        </div>

                        <input type="hidden" id="fileId" name="file_id" value="">
                        <input type="hidden" id="fileType" name="file_type" value="">

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Verifikasi dan Arsipkan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>





        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"></script>
        <!-- Custom JS -->
        <script src="Assets/js/script.js"></script>
</body>

</html>
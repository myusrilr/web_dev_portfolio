<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <style>
        .container {
            max-width: 800px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <!-- CONTAINER -->
    <div class="container">
        <!-- Flash Message -->
        <?php if (session()->getFlashdata('message')): ?>
            <div class="alert alert-info">
                <?php echo session()->getFlashdata('message'); ?>
            </div>
        <?php endif; ?>

        <!-- Card -->
        <div class="card">
            <div class="card-header bg-secondary text-white">
                Data Siswa
            </div>
            <div class="card-body">
                <!-- Search Form -->
                <form action="" method="get">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" value="<?php echo $katakunci ?>" name="katakunci" placeholder="Masukkan Kata Kunci" aria-label="Masukkan Kata Kunci" aria-describedby="button-addon2">
                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Cari</button>
                    </div>
                </form>

                <!-- Button to Trigger Add Modal -->
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">
                    + Tambah Data Siswa
                </button>

                <!-- Modal for Add Student -->
                <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addModalLabel">Form Tambah Siswa</h5>
                                <button type="button" class="btn-close tombol-tutup" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-danger error" role="alert" style="display: none;"></div>
                                <div class="alert alert-primary sukses" role="alert" style="display: none;"></div>

                                <!-- Add Form -->
                                <input type="hidden" id="addId">
                                <div class="mb-3 row">
                                    <label for="addNama" class="col-sm-2 col-form-label">Nama</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="addNama">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="addEmail" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="addEmail">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary tombol-tutup" data-bs-dismiss="modal">Tutup</button>
                                <button type="button" class="btn btn-primary" id="tombolSimpanAdd">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal for Edit Student -->
                <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Form Edit Siswa</h5>
                                <button type="button" class="btn-close tombol-tutup" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-danger error" role="alert" style="display: none;"></div>
                                <div class="alert alert-primary sukses" role="alert" style="display: none;"></div>

                                <!-- Edit Form -->
                                <input type="hidden" id="editId">
                                <div class="mb-3 row">
                                    <label for="editNama" class="col-sm-2 col-form-label">Nama</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="editNama">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="editEmail" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="editEmail">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary tombol-tutup" data-bs-dismiss="modal">Tutup</button>
                                <button type="button" class="btn btn-primary" id="tombolSimpanEdit">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table to Display Student Data -->
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($dataSiswa as $k => $v) {
                            $nomor = $nomor + 1;
                        ?>
                            <tr>
                                <td><?php echo $nomor ?></td>
                                <td><?php echo $v['nama'] ?></td>
                                <td><?php echo $v['email'] ?></td>
                                <td>
                                    <!-- Button to Trigger Edit Modal -->
                                    <button type="button" class="btn btn-warning btn-sm" onclick="edit(<?php echo $v['id'] ?>)">Edit</button>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="hapus(<?php echo $v['id'] ?>)">Delete</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <!-- Pagination -->
                <?php
                $linkPagination = $pager->links();
                $linkPagination = str_replace('<li class="active">', '<li class="page-item active">', $linkPagination);
                $linkPagination = str_replace('<li>', '<li class="page-item">', $linkPagination);
                $linkPagination = str_replace("<a", "<a class='page-link'", $linkPagination);
                echo $linkPagination;
                ?>
            </div>
        </div>
    </div>

    <!-- JavaScript Files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script>
      $(document).ready(function () {
    // Fungsi hapus siswa
    function hapus(id) {
        if (confirm('Yakin mau melakukan proses delete?')) {
            window.location = "<?php echo site_url('siswa/hapus') ?>/" + id;
        }
    }

    // Fungsi untuk mengambil data siswa dan menampilkan di modal edit
    function edit(id) {
        $.ajax({
            url: "<?php echo site_url('siswa/getDataSiswa') ?>/" + id,
            type: "GET",
            success: function (response) {
                try {
                    let siswa = JSON.parse(response);
                    if (siswa.error) {
                        alert("Data siswa tidak ditemukan.");
                    } else {
                        $('#editId').val(siswa.id);
                        $('#editNama').val(siswa.nama);
                        $('#editEmail').val(siswa.email);
                        $('#editModal').modal('show'); // Tampilkan modal edit
                    }
                } catch (error) {
                    alert("Terjadi kesalahan dalam parsing data.");
                }
            },
            error: function () {
                alert("Terjadi kesalahan saat mengambil data.");
            }
        });
    }

    // Fungsi untuk menyimpan data (tambah atau edit)
    function simpanData(url, data, isEdit = false) {
        $.ajax({
            url: url,
            type: "POST",
            data: data,
            success: function (response) {
                try {
                    let result = JSON.parse(response);
                    if (result.error) {
                        alert(result.error);
                    } else {
                        alert(result.sukses);
                        location.reload(); // Refresh halaman
                    }
                } catch (error) {
                    alert("Terjadi kesalahan dalam parsing data.");
                }
            },
            error: function () {
                alert("Terjadi kesalahan saat menyimpan data.");
            }
        });
    }

    // Event listener untuk tambah siswa
    $('#tombolSimpanAdd').off('click').on('click', function () {
        let nama = $('#addNama').val();
        let email = $('#addEmail').val();
        simpanData("<?php echo site_url('siswa/simpan') ?>", { nama: nama, email: email });
    });

    // Event listener untuk edit siswa
    $('#tombolSimpanEdit').off('click').on('click', function () {
        let id = $('#editId').val();
        let nama = $('#editNama').val();
        let email = $('#editEmail').val();
        simpanData("<?php echo site_url('siswa/simpan') ?>", { id: id, nama: nama, email: email }, true);
    });

    // Assign fungsi ke global scope untuk tombol hapus dan edit
    window.hapus = hapus;
    window.edit = edit;
});

    </script>
</body>

</html>

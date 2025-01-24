// 1. Event listener untuk membuka modal pop-up unggah dan menghasilkan document_id
document.addEventListener("DOMContentLoaded", function () {

    document.querySelector(".btn-custom").addEventListener("click", function () {
        // Fetch document_id terbaru dari database
        fetch('get_latest_document_id.php')
            .then(response => response.text())
            .then(latestDocumentId => {
                // Memecah document_id untuk mendapatkan nomor urutnya (misal: D-001)
                const currentCounter = parseInt(latestDocumentId.split('-')[1], 10);

                // Tambahkan nomor urut untuk membuat document_id baru
                const newCounter = currentCounter + 1;
                const newDocumentId = `D-${String(newCounter).padStart(3, '0')}`;

                // Tampilkan document_id baru di dalam modal
                document.getElementById("generatedDocumentId").textContent = newDocumentId;

                // Setel input tersembunyi dengan document_id yang dihasilkan
                document.getElementById("document_id_hidden").value = newDocumentId;
            })
            .catch(error => {
                console.error('Error fetching latest document ID:', error);
                // Jika terjadi error, mulai dari D-001
                document.getElementById("generatedDocumentId").textContent = 'D-001';
                document.getElementById("document_id_hidden").value = 'D-001';
            });
    });
});

// 2. Event listener untuk mengaktifkan satu-per satu fitur dalam modal pop-up unggah
document.addEventListener("DOMContentLoaded", function () {
    // Ambil elemen input
    const fileNameInput = document.getElementById("fileName");
    const accountTypeSelect = document.getElementById("accountType");
    const fileTypeButtons = document.querySelectorAll(".file-type-btn");
    const fileUploadInput = document.getElementById("fileUpload");
    const uploadButton = document.getElementById("uploadButton");

    // Disable semua input yang tergantung kecuali Nama File
    accountTypeSelect.disabled = true;
    fileTypeButtons.forEach(button => button.disabled = true);
    fileUploadInput.disabled = true;
    uploadButton.disabled = true;

    // Aktifkan Dropdown Akses setelah Nama File diisi
    fileNameInput.addEventListener("input", function () {
        if (fileNameInput.value.trim() !== "") {
            accountTypeSelect.disabled = false;
        } else {
            accountTypeSelect.disabled = true;
            fileTypeButtons.forEach(button => button.disabled = true);
            fileUploadInput.disabled = true;
            uploadButton.disabled = true;
        }
    });

    // Aktifkan Tombol Jenis File setelah Akses dipilih
    accountTypeSelect.addEventListener("change", function () {
        if (accountTypeSelect.value) {
            fileTypeButtons.forEach(button => button.disabled = false);
        } else {
            fileTypeButtons.forEach(button => button.disabled = true);
            fileUploadInput.disabled = true;
            uploadButton.disabled = true;
        }
    });

    // Aktifkan input Browse File setelah pengguna memilih jenis file
    fileTypeButtons.forEach(button => {
        button.addEventListener("click", function () {
            // Nonaktifkan semua tombol terlebih dahulu
            fileTypeButtons.forEach(btn => {
                btn.classList.remove("active"); // Hapus kelas 'active' pada semua tombol
                btn.disabled = false; // Aktifkan semua tombol kembali
            });

            // Aktifkan input Browse File dan aktifkan tombol yang dipilih
            fileUploadInput.disabled = false;
            fileUploadInput.accept = this.getAttribute("data-accept"); // Set accepted file types
            this.classList.add("active"); // Tambahkan kelas 'active' pada tombol yang dipilih
            this.disabled = false; // Tombol yang dipilih tetap aktif
            fileTypeButtons.forEach(btn => {
                if (btn !== this) {
                    btn.disabled = true; // Nonaktifkan tombol lainnya
                }
            });
        });
    });

    // Aktifkan tombol Unggah setelah file dipilih
    fileUploadInput.addEventListener("change", function () {
        const maxFileSize = 25 * 1024 * 1024; // Ukuran maksimal 25 MB

        if (fileUploadInput.files.length > 0) {
            const selectedFile = fileUploadInput.files[0];

            // Cek apakah ukuran file melebihi batas maksimal
            if (selectedFile.size > maxFileSize) {
                alert("Maaf, ukuran file yang anda unggah melebihi batas maksimal unggah file! (25 MB)");
                uploadButton.disabled = true;
                fileUploadInput.value = ''; // Reset input file
            } else {
                uploadButton.disabled = false;
            }
        } else {
            uploadButton.disabled = true;
        }
    });
});

// Fungsi untuk membuat waktu terkini
document.addEventListener("DOMContentLoaded", function () {

    const uploadForm = document.getElementById('uploadForm');
    const localTimeInput = document.createElement('input');
    localTimeInput.type = 'hidden';
    localTimeInput.name = 'upload_time';
    uploadForm.appendChild(localTimeInput);

    uploadForm.addEventListener('submit', function () {
        const now = new Date();
        const localTime = now.toISOString().slice(0, 19).replace('T', ' ');
        localTimeInput.value = localTime;
    });
});

// 3. Event listener untuk membuka modal pop-up konfirmasi unggah
document.addEventListener('DOMContentLoaded', function () {

    // Find the upload button and add a click event listener
    const uploadButton = document.getElementById('uploadButton');

    uploadButton.addEventListener('click', function () {
        // Make an AJAX request to fetch data from the database
        fetch('fetch_file_data.php')
            .then(response => response.json())
            .then(data => {
                // Populate the modal with the fetched data
                document.getElementById('confirmFileName').textContent = data.file_name;
                document.getElementById('confirmDocumentId').textContent = data.document_id;
                document.getElementById('confirmUploaderName').textContent = data.uploaded_by;
                document.getElementById('confirmAccountType').textContent = data.account_type;
                document.getElementById('confirmUploadTime').textContent = data.upload_time;
            })
            .catch(error => {
                console.error('Error fetching file data:', error);
            });
    });

    // Confirm button action
    const confirmUploadButton = document.getElementById('confirmUploadButton');
    confirmUploadButton.addEventListener('click', function () {
        alert('File confirmed for upload!');
        // Here you can add the code to handle the actual file upload process if necessary.
    });

});

// 4.Event listener untuk tombol Pratinjau
document.querySelectorAll('.preview-btn').forEach(function (button) {
    button.addEventListener('click', function () {
        var filePath = this.getAttribute('data-filepath');
        var fileType = this.getAttribute('data-filetype');
        var previewContent = document.getElementById('previewContent');

        // Kosongkan konten preview sebelumnya
        previewContent.innerHTML = '';
        // Menampilkan preview berdasarkan tipe file
        if (fileType.startsWith('image/')) {
            // Jika file adalah gambar
            previewContent.innerHTML = '<img src="' + filePath + '" class="img-fluid" alt="Preview Gambar">';
        } else if (fileType === 'application/pdf') {
            // Jika file adalah PDF
            previewContent.innerHTML = '<iframe src="' + filePath + '" width="100%" height="500px"></iframe>';
        } else if (fileType === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ||
            fileType === 'application/msword') {
            // Jika file adalah DOC atau DOCX
            previewContent.innerHTML = '<iframe src="https://view.officeapps.live.com/op/view.aspx?src=' + encodeURIComponent(filePath) + '" width="100%" height="500px"></iframe>';
        } else {
            // Untuk file yang tidak didukung, tampilkan pesan
            previewContent.innerHTML = '<p>Preview tidak tersedia untuk file jenis ini. Silakan unduh untuk melihat konten.</p>';
        }
    });
});

// 5. Event listener untuk tombol Arsip
// Toggle show/hide password
const togglePassword = document.getElementById('togglePassword');
const passwordField = document.getElementById('password');

togglePassword.addEventListener('click', function () {
    const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordField.setAttribute('type', type);
    this.classList.toggle('bi-eye-fill');
    this.classList.toggle('bi-eye-slash-fill');
});

// Event listener ketika modal dibuka
document.querySelectorAll('[data-bs-toggle="modal"]').forEach(function (button) {
    button.addEventListener('click', function () {
        const fileId = this.getAttribute('data-file-id');
        const fileType = this.getAttribute('data-file-type');

        // Set nilai fileId dan fileType di dalam modal
        document.getElementById('fileId').value = fileId;
        document.getElementById('fileType').value = fileType;
    });
});

// Form Submission Handling
document.getElementById('archieveForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const fileId = document.getElementById('fileId').value;
    const fileType = document.getElementById('fileType').value;

    // Lakukan request AJAX ke server untuk memverifikasi email dan password
    fetch('archive_file.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}&file_id=${fileId}&file_type=${fileType}`
    })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.success) {
                window.location.reload(); // Reload halaman jika berhasil
            }
        })
        .catch(error => console.error('Error:', error));
});

// 6. popup modal konfirmasi hapus
document.addEventListener('DOMContentLoaded', function () {
    // Toggle show/hide password
    const togglePassword = document.getElementById('togglePassword');
    const passwordField = document.getElementById('password');

    togglePassword.addEventListener('click', function () {
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        this.classList.toggle('bi-eye-fill');
        this.classList.toggle('bi-eye-slash-fill');
    });
    const deleteModal = document.getElementById('deleteModal');
    const fileIdInput = document.getElementById('fileId');
    const fileTypeInput = document.getElementById('fileType');

    // Menangkap data dari tombol Hapus dan memasukkan ke modal
    deleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const fileId = button.getAttribute('data-file-id');
        const fileType = button.getAttribute('data-file-type');

        // Masukkan nilai file_id dan file_type ke dalam input tersembunyi
        fileIdInput.value = fileId;
        fileTypeInput.value = fileType;
    });

    // Event listener untuk tombol "Hapus"
    const confirmDeleteButton = document.getElementById('confirmDeleteButton');
    confirmDeleteButton.addEventListener('click', function () {
        const form = document.getElementById('deleteForm');
        form.submit(); // Submit form secara manual
    });
});












// Inisialisasi variabel
let countdownTime = 10; // Mulai dari detik ke-10
let button = document.getElementById('waktu');
let interval; // Variabel untuk interval
let modal = document.getElementById('resultModal');

// Fungsi untuk memperbarui countdown
function updateCountdown() {
    // Menampilkan detik saat ini di tombol
    button.innerHTML = countdownTime;

    if (countdownTime > 0) {
        countdownTime--; // Kurangi countdown setiap detik
    } else {
        clearInterval(interval); // Hentikan countdown ketika selesai
        button.innerHTML = "OPEN"; // Ubah tombol menjadi "OPEN"
        button.disabled = false; // Aktifkan tombol
        button.style.cursor = 'pointer'; // Ubah kursor menjadi pointer
        button.style.backgroundColor = '#4CAF50';
        button.addEventListener('click', openModal); // Tambahkan event listener untuk membuka modal
    }
}
// Fungsi untuk membuka modal
function openModal() {
    if (!button.disabled) {
        modal.style.display = 'block';
    }
}

// Fungsi untuk menutup modal
function closeModal() {
    modal.style.display = 'none';
}

// Memulai countdown setelah halaman dimuat
let countdownInterval = setInterval(updateCountdown, 1000);

// Disable tombol di awal
button.disabled = true;

// Event listener untuk tombol "OPEN"
button.addEventListener('click', openModal);
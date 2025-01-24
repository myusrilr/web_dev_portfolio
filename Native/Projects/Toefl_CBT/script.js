// Fungsi regex validasi email
function validateEmail(email) {
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    return emailPattern.test(email);
}

// Fungsi regex validasi nomor telepon (dengan atau tanpa kode negara)
function validatePhone(phone) {
    const phonePattern = /^(\+?\d{1,3})?[\s-]?\d{9,13}$/;
    return phonePattern.test(phone);
}

// Fungsi untuk pindah ke halaman kuis pertama atau memberikan alert jika input salah
function nextPage() {
    const name = document.getElementById("name").value.trim();
    const email = document.getElementById("email").value.trim();
    const phone = document.getElementById("phone").value.trim();

    // Validasi input
    if (!name) {
        alert("Name must be filled!");
        return;
    }

    if (!validateEmail(email)) {
        alert("Please enter the correct email. The format must have '@' and a valid domain!.");
        return;
    }

    if (!validatePhone(phone)) {
        alert("Please enter the correct phone number. The length of the number should be between 9 to 13 digits!");
        return;
    }

    // Jika validasi berhasil, simpan data ke localStorage dan pindah ke halaman berikutnya
    localStorage.setItem("name", name);
    localStorage.setItem("email", email);
    localStorage.setItem("phone", phone);

    // Alihkan ke halaman kuis pertama
    window.location.href = "quiz1.html";
}
// countdown
function getCurrentPage() {
    const path = window.location.pathname;
    const page = path.split("/").pop();
    return page;
}

// Menghitung mundur waktu (60 detik) dengan setTimeout
function countdown(seconds) {
    const countdownElement = document.getElementById("waktu");
    const submitButton = document.getElementById("submitButton");

    function updateCountdown() {
        // Jika waktu tersisa 1 detik atau 0, tampilkan "second" tanpa "s"
        if (seconds === 1 || seconds === 0) {
            countdownElement.innerHTML = `Waktu: ${seconds} detik`;
        } else {
            countdownElement.innerHTML = `Waktu: ${seconds} detik`; // Tampilkan "seconds"
        }

        // Ubah warna menjadi merah saat tersisa 10 detik atau kurang
        if (seconds <= 10) {
            countdownElement.style.color = "red";
        } else {
            countdownElement.style.color = ""; // Kembalikan ke warna semula jika > 10
        }

        seconds--; // Kurangi waktu setiap detik

        if (seconds >= 0) {
            // Panggil ulang fungsi setelah 1 detik (1000 ms)
            setTimeout(updateCountdown, 1000);
        } else {
            // Aktifkan tombol submit setelah countdown selesai
            submitButton.disabled = false;
        }
    }

    // Mulai hitungan mundur
    updateCountdown();
}

// Jalankan countdown saat halaman dimuat
window.onload = function () {
    countdown(60); // Mengatur waktu 60 detik
};

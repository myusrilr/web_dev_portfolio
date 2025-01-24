// Mendapatkan nama file saat ini
function getCurrentPage() {
    const path = window.location.pathname;
    const page = path.split("/").pop();
//     Fungsi split() di JavaScript memisahkan sebuah string berdasarkan pemisah tertentu, dalam hal ini adalah / (garis miring).
// Dengan memanggil path.split("/"), kita memecah string jalur URL menjadi array berdasarkan posisi setiap garis miring /.
// Misalnya, untuk path /folder/halaman1.html, pemecahannya akan menghasilkan array seperti berikut: [ "", "folder", "halaman1.html" ]
// pop() adalah fungsi array di JavaScript yang mengambil (menghapus dan mengembalikan) elemen terakhir dari array.
// Dalam contoh ini, array yang dihasilkan dari split("/") adalah [ "", "folder", "halaman1.html" ]. Elemen terakhir dari array tersebut adalah "halaman1.html", yang merupakan nama file HTML yang sedang diakses.
// Dengan memanggil pop(), kita mendapatkan "halaman1.html" dari array, yang kemudian disimpan di dalam variabel page.
    return page;
    // Fungsi ini akan mengembalikan "halaman1.html".
}

// Menghitung mundur waktu (5 detik) dengan setTimeout
function countdown(seconds) {
    const countdownElement = document.getElementById("waktu");

    function updateCountdown() {
        countdownElement.textContent = seconds; // Tampilkan waktu tersisa
        seconds--; // Kurangi waktu setiap detik

        if (seconds >= 0) {
            // Panggil ulang fungsi setelah 1 detik (1000 ms)
            setTimeout(updateCountdown, 1000);
        } else {
            // Pindah halaman setelah hitungan mundur selesai
            moveToNextPage();
        }
    }

    // Mulai hitungan mundur
    updateCountdown();
}

// Fungsi untuk berpindah ke halaman berikutnya
function moveToNextPage() {
    const currentPage = getCurrentPage();

    // Tentukan halaman berikutnya berdasarkan halaman saat ini
    if (currentPage === "halaman1.html") {
        window.location.href = "halaman2.html";
    } else if (currentPage === "halaman2.html") {
        window.location.href = "halaman3.html";
    } else if (currentPage === "halaman3.html") {
        window.location.href = "halaman4.html";
    }
}

// Jalankan countdown saat halaman dimuat
window.onload = function () {
    countdown(10); // Mengatur waktu 5 detik
};
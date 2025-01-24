let currentPage = 1;
let totalSatisfaction = 0;

document.addEventListener("DOMContentLoaded", function() {
    showPage(currentPage);
});

// Fungsi untuk menampilkan halaman sesuai dengan currentPage
function showPage(page) {
    const allPages = document.querySelectorAll(".form-page");
    allPages.forEach(p => p.classList.remove("active"));
    document.getElementById(`page-${page}`).classList.add("active");
}

// Fungsi untuk melanjutkan ke halaman berikutnya
function nextPage() {
    if (validatePage(currentPage)) {
        currentPage++;
        showPage(currentPage);
    }
}

// Fungsi untuk kembali ke halaman sebelumnya
function prevPage() {
    currentPage--;
    showPage(currentPage);
}

// Fungsi untuk memvalidasi halaman
function validatePage(page) {
    let isValid = true;

    // Validasi halaman penilaian (halaman 2 hingga 5)
    if (page > 1 && page < 6) {
        let numQuestions = 6;  // Jumlah pertanyaan default adalah 6
        
        // Jumlah pertanyaan di halaman 5 hanya 3
        if (page === 5) {
            numQuestions = 3;
        }

        // Memeriksa apakah semua pertanyaan di halaman telah dijawab
        for (let i = 1; i <= numQuestions; i++) {
            const radioGroup = document.querySelectorAll(`#page-${page} input[name="q${i}"]:checked`);
            if (radioGroup.length === 0) {
                isValid = false;
                alert(`Harap pilih salah satu opsi pada pertanyaan ${i} di halaman ${page}.`);
                break;  // Jika salah satu pertanyaan tidak dijawab, hentikan validasi
            }
        }

        // Jika semua radio button terisi, tambahkan nilai kepuasan ke totalSatisfaction
        if (isValid) {
            const radios = document.querySelectorAll(`#page-${page} input[type="radio"]:checked`);
            radios.forEach(radio => {
                totalSatisfaction += parseInt(radio.value);
            });
        }
    }

    // Validasi halaman pertama untuk email dan nomor telepon
    if (page === 1) {
        const email = document.getElementById("email").value;
        const phone = document.getElementById("phone").value;

        // Validasi email
        if (!validateEmail(email)) {
            alert("Harap masukkan email yang valid dengan format yang benar (harus mengandung @ dan domain yang benar).");
            isValid = false;
        }

        // Validasi nomor telepon
        if (!validatePhone(phone)) {
            alert("Harap masukkan nomor telepon dengan format internasional yang valid (misalnya, +621234567890).");
            isValid = false;
        }
    }

    return isValid;
}

// Fungsi untuk memvalidasi format email
function validateEmail(email) {
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    return emailPattern.test(email);
}

// Fungsi untuk memvalidasi format nomor telepon
function validatePhone(phone) {
    const phonePattern = /^\+\d{1,3}\d{9,}$/;  // Contoh: +621234567890 (Indonesia)
    return phonePattern.test(phone);
}

// Fungsi untuk mengirim form setelah semua halaman selesai diisi
function submitForm() {
    const feedback = document.getElementById("feedback").value;

    if (!feedback) {
        alert("Harap isi kritik dan saran");
        return;
    }

    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    const phone = document.getElementById("phone").value;

    let averageSatisfaction = totalSatisfaction / 21;  // Rata-rata dari 21 pertanyaan

    let resultText = `
        Nama: ${name}<br>
        Email: ${email}<br>
        Nomor HP: ${phone}<br><br>
        Rata-rata Kepuasan: ${averageSatisfaction.toFixed(2)}%<br><br>
        Kritik dan Saran: ${feedback}
    `;

    document.getElementById("modal-content").innerHTML = resultText;
    openModal();
}

// Fungsi untuk menampilkan modal hasil survey
function openModal() {
    document.getElementById("resultModal").style.display = "block";
}

// Fungsi untuk menutup modal hasil survey
function closeModal() {
    document.getElementById("resultModal").style.display = "none";
}

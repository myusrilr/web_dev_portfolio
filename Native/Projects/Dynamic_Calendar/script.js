const currentDate = document.querySelector(".current-date"),
// Mendapatkan elemen dengan kelas .current-date dan menyimpannya dalam variabel currentDate

    daysTag = document.querySelector(".days"),
    // Mendapatkan elemen dengan kelas .days yang akan digunakan untuk menampung hari-hari dalam bulan

    prevNextIcon = document.querySelectorAll(".icons span");
    // Mengambil semua elemen span di dalam elemen .icons sebagai NodeList (array-like object) dan menyimpannya dalam variabel prevNextIcon

let date = new Date(),
// Membuat objek Date baru untuk mendapatkan tanggal saat ini, yang disimpan dalam variabel date

    curYear = date.getFullYear(),
    // Mendapatkan tahun saat ini dari objek Date dan menyimpannya dalam variabel curYear

    curMonth = date.getMonth();
    // Mendapatkan bulan saat ini dari objek Date (berbasis 0, di mana Januari adalah 0 dan Desember adalah 11) dan menyimpannya dalam variabel curMonth

const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
// Array yang berisi nama bulan-bulan dari Januari hingga Desember untuk digunakan dalam menampilkan bulan dalam teks

const renderCalendar = () => {
// Fungsi untuk merender kalender berdasarkan bulan dan tahun yang saat ini disimpan dalam curMonth dan curYear

    let firstDayofMonth = new Date(curYear, curMonth, 1).getDay(),
    // Membuat objek Date baru untuk hari pertama dalam bulan saat ini, dan mendapatkan hari pertama dalam minggu (berbasis 0, di mana 0 adalah Minggu)

        lastDateofMonth = new Date(curYear, curMonth + 1, 0).getDate(),
        // Mendapatkan tanggal terakhir dalam bulan saat ini dengan membuat objek Date baru yang mengacu pada hari 0 di bulan berikutnya

        lastDayofMonth = new Date(curYear, curMonth, lastDateofMonth).getDay(),
        // Mendapatkan hari terakhir dalam bulan saat ini

        lastDateofLastMonth = new Date(curYear, curMonth, 0).getDate();
        // Mendapatkan tanggal terakhir dari bulan sebelumnya dengan mengatur hari ke 0 pada bulan saat ini (bulan sebelumnya)

    let liTag = "";
    // Membuat variabel liTag kosong untuk menyimpan elemen-elemen <li> yang akan dirender dalam kalender

    for (let i = firstDayofMonth; i > 0; i--) {
    // Loop untuk menampilkan tanggal-tanggal dari bulan sebelumnya yang muncul di awal kalender pada bulan ini (jika hari pertama bukan hari Minggu)

        liTag += `<li class="inactive">${lastDateofLastMonth - i + 1}</li>`;
        // Menambahkan elemen <li> dengan kelas "inactive" untuk setiap hari dari bulan sebelumnya
    }

    for (let i = 1; i <= lastDateofMonth; i++) {
        // Loop untuk menampilkan semua tanggal dalam bulan saat ini

        let isToday = i === date.getDate() && curMonth === new Date().getMonth() && curYear === new Date().getFullYear() ? "active" : "";
        // Mengecek apakah tanggal ini adalah hari ini (current day), dan jika iya, tambahkan kelas "active" untuk menandainya

        liTag += `<li class="${isToday}">${i}</li>`;
        // Menambahkan elemen <li> dengan kelas "active" jika ini adalah hari ini, atau tanpa kelas jika bukan
    }

    for (let i = lastDayofMonth; i < 6; i++) {
        // Loop untuk menampilkan tanggal dari bulan berikutnya yang muncul di akhir kalender pada bulan ini (jika hari terakhir bukan Sabtu)

        liTag += `<li class="inactive">${i - lastDayofMonth + 1}</li>`;
        // Menambahkan elemen <li> dengan kelas "inactive" untuk setiap hari dari bulan berikutnya
    }

    currentDate.innerText = `${months[curMonth]} ${curYear}`;
    // Menampilkan bulan dan tahun saat ini dalam elemen currentDate

    daysTag.innerHTML = liTag;
    // Memasukkan elemen-elemen <li> yang telah dibuat ke dalam elemen .days untuk ditampilkan dalam kalender
}

renderCalendar();
// Memanggil fungsi renderCalendar untuk merender kalender pertama kali


const modal = document.getElementById("modal"),
// Mengambil elemen dengan id "modal" dan menyimpannya dalam variabel modal

closeModal = document.querySelector(".close"),
// Mengambil elemen dengan kelas "close" (tombol close modal) dan menyimpannya dalam variabel closeModal

modalText = document.getElementById("modal-text");
// Mengambil elemen dengan id "modal-text" dan menyimpannya dalam variabel modalText


const showModal = (date) => {
// Fungsi untuk menampilkan modal dengan tanggal yang diklik sebagai parameter

    modal.style.display = "block";
    // Menampilkan modal dengan mengubah CSS display dari "none" menjadi "block"

    modalText.textContent = `Tanggal yang dipilih: ${date}`;
    // Menampilkan tanggal yang dipilih di dalam modal
};


closeModal.onclick = function() {
// Fungsi untuk menutup modal ketika tombol close diklik

    modal.style.display = "none";
    // Menutup modal dengan mengubah CSS display menjadi "none"
}


window.onclick = function(event) {
// Fungsi untuk menutup modal jika pengguna mengklik area di luar modal

    if (event.target == modal) {
    // Jika elemen yang diklik adalah modal (bukan konten modal)

        modal.style.display = "none";
        // Menutup modal dengan mengubah CSS display menjadi "none"
    }
}


const addDateClickListeners = () => {
// Fungsi untuk menambahkan event listener klik pada setiap tanggal setelah renderCalendar() dipanggil

    const days = document.querySelectorAll(".days li");
    // Mengambil semua elemen <li> di dalam elemen .days yang berisi tanggal-tanggal kalender

    days.forEach(day => {
    // Melakukan looping untuk setiap elemen <li> (setiap tanggal dalam kalender)

        day.addEventListener("click", () => {
        // Menambahkan event listener untuk mendeteksi klik pada setiap elemen <li>

            if (!day.classList.contains('inactive')) {
            // Jika elemen <li> tidak memiliki kelas "inactive" (hanya tanggal aktif yang dapat diklik)

                showModal(day.textContent); 
                // Menampilkan modal dengan teks yang berisi tanggal yang diklik
            }
        });
    });
};

renderCalendar();
// Memanggil fungsi renderCalendar untuk pertama kali menampilkan kalender

addDateClickListeners();
// Memanggil fungsi addDateClickListeners untuk menambahkan event listener ke setiap tanggal setelah renderCalendar dipanggil


prevNextIcon.forEach(icon => {
    // Looping untuk kedua ikon navigasi (prev dan next)

    icon.addEventListener("click", () => {
        // Menambahkan event listener untuk mendeteksi klik pada ikon prev dan next

        curMonth = icon.id == "prev" ? curMonth - 1 : curMonth + 1;
        // Jika ikon yang diklik adalah "prev", kurangi curMonth, jika "next", tambahkan curMonth

        if (curMonth < 0 || curMonth > 11) {
            // Jika curMonth di luar rentang 0-11 (di luar Januari atau Desember)

            date = new Date(curYear, curMonth);
            // Membuat objek Date baru dengan tahun dan bulan yang diperbarui

            curYear = date.getFullYear();
            // Memperbarui curYear dengan tahun baru

            curMonth = date.getMonth();
            // Memperbarui curMonth dengan bulan baru
        } else {
            date = new Date();
            // Jika bulan tidak keluar dari rentang 0-11, gunakan tanggal saat ini
        }

        renderCalendar();
        // Memanggil fungsi renderCalendar untuk memperbarui tampilan kalender

        addDateClickListeners();
        // Memanggil fungsi addDateClickListeners untuk menambahkan event listener klik pada tanggal setelah kalender diperbarui
    });
});

// Ambil elemen wrapper (kontainer kalender) dan elemen icon kalender
const calendarWrapper = document.querySelector(".wrapper");
const calendarIcon = document.querySelector(".calendar-icon");

// Fungsi untuk membuka dan menutup kalender
const toggleCalendar = () => {
    if (calendarWrapper.style.display === "none" || calendarWrapper.style.display === "") {
        // Jika kalender disembunyikan, maka tampilkan
        calendarWrapper.style.display = "block";
    } else {
        // Jika kalender ditampilkan, maka sembunyikan
        calendarWrapper.style.display = "none";
    }
};

// Tambahkan event listener ke ikon kalender
calendarIcon.addEventListener("click", toggleCalendar);

// Saat pertama kali, sembunyikan kalender
calendarWrapper.style.display = "none";

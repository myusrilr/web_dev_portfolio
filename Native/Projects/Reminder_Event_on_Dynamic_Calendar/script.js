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


// Get necessary elements from the DOM
const modal = document.getElementById("modal"),
    closeModal = document.querySelector(".close"),
    modalText = document.getElementById("modal-text"),
    eventForm = document.getElementById("eventForm"),
    startTimeSelect = document.getElementById("startTime"),
    endTimeSelect = document.getElementById("endTime"),
    startTimePeriodSelect = document.getElementById("startTimePeriod"),
    endTimePeriodSelect = document.getElementById("endTimePeriod"),
    eventTitle = document.getElementById("eventTitle"),
    eventDetails = document.getElementById("eventDetails"),
    cancelBtn = document.getElementById("cancelBtn"),
    saveBtn = document.getElementById("saveBtn"); // Get the save button by ID

// Function to populate the start and end time dropdowns with 12-hour format
const populateTimeOptions = () => {
    let times = [];
    for (let h = 1; h <= 12; h++) {
        for (let m = 0; m < 60; m += 15) {
            const hour = h < 10 ? `0${h}` : h; // Format hours with leading zeros
            const minute = m < 10 ? `0${m}` : m; // Format minutes with leading zeros
            times.push(`${hour}:${minute}`);
        }
    }

    // Add options to both start and end time dropdowns
    times.forEach(time => {
        startTimeSelect.add(new Option(time, time));
        endTimeSelect.add(new Option(time, time));
    });
};
let events = JSON.parse(localStorage.getItem('events')) || [];
// Handle the form submission when the "Save" button is clicked
saveBtn.onclick = function () {
    const startTime = document.getElementById('startTime').value;
    const endTime = document.getElementById('endTime').value;
    const judul = document.getElementById('eventTitle').value;
    const deskripsi = document.getElementById('eventDetails').value;

    // Check if start time is before end time
    if (new Date('1970-01-01T' + startTime) >= new Date('1970-01-01T' + endTime)) {
        alert('Waktu Akhir Harus diatur Lebih Besar daripada Waktu Awal!');
        return;
    }    

    // Save event to local storage
    const event = { startTime, endTime, judul, deskripsi };
    events.push(event);
    localStorage.setItem('events', JSON.stringify(events));

    // Close modal
    modal.style.display = 'none';
    alert('Event saved!');
}


// Function to clear all input fields in the form
const clearForm = () => {
    eventForm.reset(); // Reset the form
};

// Handle cancel button click
cancelBtn.addEventListener("click", () => {
    if (confirm('Apakah anda yakin menghapus catatan?')) {
        events = [];
        localStorage.removeItem('events');
        alert('Catatan berhasil dihapus!');
      }
    modal.style.display = "none";// Hide the modal
});

// Close the modal when the close (x) button is clicked
closeModal.onclick = function () {
    modal.style.display = "none";
};

// Close the modal when clicking outside of it
window.onclick = function (event) {
    if (event.target === modal) {
        modal.style.display = "none";
    }
};

// Populate time options in the dropdowns when the page loads
populateTimeOptions();

// Function to show the modal with the selected date
const showModal = (date) => {
    modal.style.display = "block"; // Show the modal
    modalText.textContent = `Tanggal yang dipilih: ${date}`; // Display the selected date
    modalText.setAttribute("data-date", date); // Store the date as a data attribute for later use
};

// Add click listeners to all the days in the calendar
const addDateClickListeners = () => {
    const days = document.querySelectorAll(".days li"); // Get all day elements
    days.forEach(day => {
        day.addEventListener("click", () => {
            if (!day.classList.contains('inactive')) { // Ensure the day is clickable (not inactive)
                showModal(day.textContent); // Show the modal with the selected date
            }
        });
    });
};

// Render the calendar and add click listeners to dates when the page loads
renderCalendar();
addDateClickListeners();



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

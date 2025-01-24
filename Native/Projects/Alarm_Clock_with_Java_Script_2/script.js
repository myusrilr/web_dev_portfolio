const currentTime = document.querySelector("h1"),
    // Waktu saat ini (currentTime) dari tag <h1>.
    content = document.querySelector(".content"),
    // Kontainer (content) untuk alarm.
    selectMenu = document.querySelectorAll("select"),
    // Dropdown menu untuk jam, menit, dan AM/PM (selectMenu).
    setAlarmBtn = document.querySelector("button"),
    // Tombol untuk menyetel alarm (setAlarmBtn).
    remainingTimeDisplay = document.getElementById("remaining");
    // Elemen yang menampilkan waktu sisa (remainingTimeDisplay).

let alarmTime, isAlarmSet, alarmInterval,
    ringtone = new Audio("./files/ringtone.mp3");

for (let i = 12; i > 0; i--) {
    //     let i = 12: kita mulai dari angka 12. Bayangkan kita punya papan angka, dan angka pertama yang kita tulis adalah 12.

    // i > 0: Loop ini akan terus berulang selama nilai i lebih besar dari 0. Jika sudah 0, loop akan berhenti. Jadi ini seperti asisten yang terus bekerja selama masih ada angka di papan (dari 12 hingga 1).

    // i--: Setiap kali loop selesai satu kali, nilai i akan berkurang 1. Ini seperti menghitung mundur. Dari 12, kemudian 11, 10, dan seterusnya sampai 1.
    i = i < 10 ? `0${i}` : i;
    // Ini adalah ternary operator. Bayangkan kita meminta komputer untuk memeriksa angka:

    // Jika angka lebih kecil dari 10 (contoh: 9, 8, dst.), maka tambahkan "0" di depannya.
    // Misalnya, angka 9 akan menjadi "09".
    // Jika angka lebih besar atau sama dengan 10, biarkan seperti itu.
    // Misalnya, angka 12 tetap "12".
    // Jadi, untuk angka yang lebih kecil dari 10, kita tambahkan "0" di depannya, sehingga terlihat rapi dan dalam format dua digit (contoh: "09", "08").
    let option = `<option value="${i}">${i}</option>`;
    //     Bagian ini membuat elemen HTML baru yang akan dimasukkan ke dalam dropdown. Elemen ini adalah tag <option>, yang biasanya digunakan di dalam tag <select> (dropdown).

    // Bayangkan ini seperti menambahkan kartu kecil dengan tulisan angka di dalamnya, lalu kita memasukkannya ke dalam dropdown.
    // Misalnya, jika i = 09, maka akan menghasilkan HTML seperti ini:
    // <option value="09">09</option>
    // Ini adalah elemen <option> yang berisi angka 09.

    selectMenu[0].firstElementChild.insertAdjacentHTML("afterend", option);
}
    // selectMenu[0]: Ini mengambil dropdown pertama dari elemen-elemen <select> di halaman. Bayangkan kita memilih kolom dropdown pertama dari tiga kolom yang tersedia (kolom untuk jam).
    // firstElementChild: Bayangkan dropdown ini seperti sebuah kotak yang punya beberapa elemen anak (anak-anak elemen di dalam kotak). firstElementChild adalah anak pertama di dalam kotak dropdown ini, yaitu elemen pertama <option>, yang biasanya merupakan opsi default (seperti "Hour").
    // insertAdjacentHTML(): Fungsi ini digunakan untuk menambahkan HTML baru ke dalam dokumen tanpa mengganti elemen yang sudah ada.
    // "afterend": Ini memberitahu program untuk menambahkan elemen HTML setelah elemen yang ditargetkan. Dalam hal ini, kita ingin menambahkan opsi jam baru setelah anak pertama di dropdown, yaitu opsi default "Hour".
    // Bayangkan dropdown seperti rak buku, dan firstElementChild adalah buku pertama di rak (judulnya "Hour").
    // insertAdjacentHTML("afterend", option): Artinya, buku-buku baru (angka jam, misalnya "12", "11", dst.) akan ditambahkan satu per satu setelah buku pertama ("Hour"). Setiap kali loop berjalan, kita menambahkan buku baru ke rak, satu di belakang yang lainnya.
    // - kita punya angka mulai dari 12 hingga 1.
    // - Setiap angka dituliskan pada kartu kecil yang berbentuk elemen <option>.
    // - Setiap kartu ini kemudian dimasukkan ke dalam sebuah rak dropdown setelah kartu pertama yang bertuliskan "Hour".
    // - Proses ini diulang sampai semua angka (12 hingga 1) selesai ditambahkan.

for (let i = 59; i >= 0; i--) {
    // Ini adalah bagian dari loop for.

    // let i = 59: Loop dimulai dengan nilai i = 59. Ini artinya, loop pertama kali akan bekerja dengan angka 59.

    // Visualisasi: Bayangkan papan angka yang dimulai dari 59.
    // i >= 0: Kondisi ini memeriksa apakah nilai i lebih besar atau sama dengan 0. Jika benar, loop akan terus berulang. Jika salah, loop akan berhenti.

    // Visualisasi: Bayangkan asisten kita akan terus bekerja selagi angka di papan masih di atas 0.
    // i--: Setiap kali loop selesai menjalankan instruksi di dalamnya, nilai i berkurang 1.

    // Visualisasi: Setiap kali asisten kita mengambil angka dari papan, dia akan mengurangi angka 1 (59, 58, 57, dst.), seperti countdown mundur.
    // Kesimpulan: Loop ini berjalan 60 kali, dari angka 59 hingga 0.

    i = i < 10 ? `0${i}` : i;
    // Ini adalah ternary operator yang digunakan untuk memeriksa apakah nilai i kurang dari 10.

    // i < 10: Jika nilai i lebih kecil dari 10 (misalnya 9, 8, dst.), kita akan menambahkan "0" di depannya agar tampil sebagai dua digit.

    // Contoh:
    // Jika i = 9, hasilnya akan menjadi "09".
    // Jika i = 7, hasilnya akan menjadi "07".
    // ? \0${i}` : i;`: Ini adalah kondisi ternary, yang bisa kita anggap sebagai "if-else" yang disingkat. Jika kondisi benar (i < 10), tambahkan "0". Jika salah (i >= 10), biarkan i tetap seperti aslinya.

    // Visualisasi:

    // Bayangkan kita punya beberapa kartu angka dari 0 sampai 59. Ketika angka di bawah 10, kita tambahkan "0" di depannya agar terlihat rapi dalam dua digit (contoh: "01", "02").

    let option = `<option value="${i}">${i}</option>`;

    //<option value="${i}">${i}</option>: Ini membuat sebuah tag < option > untuk HTML.Setiap angka i dimasukkan ke dalam tag ini, baik sebagai atribut value maupun teks yang ditampilkan kepada pengguna.

    // Misalnya, jika i = 09, maka akan dihasilkan HTML seperti ini:
    // < option value = "09" >09</ >
    //  Ini adalah elemen < option > yang nanti akan muncul di dropdown menu menit dengan angka 09.
    //     Visualisasi:

    // Bayangkan kita menulis angka 09 di selembar kartu kecil yang akan dimasukkan ke dalam kotak dropdown menit.
    selectMenu[1].firstElementChild.insertAdjacentHTML("afterend", option);
}

    // Bagian ini menambahkan elemen <option> yang baru saja dibuat ke dalam dropdown.

    // selectMenu[1]: Ini mengacu pada dropdown kedua di halaman (karena selectMenu[1] berarti elemen <select> kedua, yang merupakan dropdown untuk menit).

    // Visualisasi: Bayangkan ada tiga kolom dropdown di halaman: satu untuk jam, satu untuk menit, dan satu untuk AM/PM. selectMenu[1] menunjuk ke kolom menit.
    // firstElementChild: Ini mengambil anak pertama dari dropdown tersebut. Dalam hal ini, anak pertama mungkin adalah opsi default (misalnya, "Minute").

    // Visualisasi: Jika dropdown adalah sebuah rak buku, firstElementChild adalah buku pertama di rak yang bertuliskan "Minute".
    // insertAdjacentHTML("afterend", option);: Ini adalah fungsi yang digunakan untuk menyisipkan HTML ke dalam halaman. Instruksi ini memberitahu agar elemen HTML baru (angka menit) disisipkan setelah elemen pertama (yaitu setelah opsi "Minute").

    // Visualisasi:
    // Bayangkan kamu punya rak buku dengan buku pertama bertuliskan "Minute". Sekarang, kamu menyisipkan buku baru bertuliskan angka (contoh: "59") setelah buku pertama.

for (let i = 2; i > 0; i--) {
    let ampm = i == 1 ? "AM" : "PM";
    let option = `<option value="${ampm}">${ampm}</option>`;
    selectMenu[2].firstElementChild.insertAdjacentHTML("afterend", option);
}

setInterval(() => {
    let date = new Date(),
        h = date.getHours(),
        m = date.getMinutes(),
        s = date.getSeconds(),
        ampm = "AM";
    if (h >= 12) {
        h = h - 12;
        ampm = "PM";
    }
    h = h == 0 ? h = 12 : h;
    h = h < 10 ? "0" + h : h;
    m = m < 10 ? "0" + m : m;
    s = s < 10 ? "0" + s : s;
    currentTime.innerText = `${h}:${m}:${s} ${ampm}`;

    if (alarmTime === `${h}:${m} ${ampm}`) {
        ringtone.play();
        ringtone.loop = true;
    }
}, 1000);

function setAlarm() {
    if (isAlarmSet) {
        alarmTime = "";
        ringtone.pause();
        clearInterval(alarmInterval);
        content.classList.remove("disable");
        setAlarmBtn.innerText = "Set Alarm";
        remainingTimeDisplay.innerText = "00:00:00";
        remainingTimeDisplay.style.color = "";
        return isAlarmSet = false;
    }

    let time = `${selectMenu[0].value}:${selectMenu[1].value} ${selectMenu[2].value}`;
    if (time.includes("Hour") || time.includes("Minute") || time.includes("AM/PM")) {
        return alert("Please, select a valid time to set Alarm!");
    }

    alarmTime = time;
    isAlarmSet = true;
    content.classList.add("disable");
    setAlarmBtn.innerText = "Clear Alarm";

    startCountdown();
}

function startCountdown() {
    const alarmParts = alarmTime.split(/[: ]/);
    let alarmHour = parseInt(alarmParts[0]);
    let alarmMinute = parseInt(alarmParts[1]);
    let alarmAmpm = alarmParts[2];


    if (alarmAmpm === "PM" && alarmHour !== 12) {
        alarmHour += 12;
    } else if (alarmAmpm === "AM" && alarmHour === 12) {
        alarmHour = 0;
    }

    alarmInterval = setInterval(() => {
        const now = new Date();
        let remainingMs = new Date(now.getFullYear(), now.getMonth(), now.getDate(), alarmHour, alarmMinute, 0) - now;

        if (remainingMs <= 0) {
            clearInterval(alarmInterval);
            ringtone.play();
            ringtone.loop = true;
            remainingTimeDisplay.innerText = "00:00:00";
            remainingTimeDisplay.style.color = "red";
            return;
        }


        let remainingHours = Math.floor(remainingMs / (1000 * 60 * 60));
        let remainingMinutes = Math.floor((remainingMs % (1000 * 60 * 60)) / (1000 * 60));
        let remainingSeconds = Math.floor((remainingMs % (1000 * 60)) / 1000);

        remainingHours = remainingHours < 10 ? "0" + remainingHours : remainingHours;
        remainingMinutes = remainingMinutes < 10 ? "0" + remainingMinutes : remainingMinutes;
        remainingSeconds = remainingSeconds < 10 ? "0" + remainingSeconds : remainingSeconds;

        remainingTimeDisplay.innerText = `${remainingHours}:${remainingMinutes}:${remainingSeconds}`;


        if (remainingMs <= 6000) {
            remainingTimeDisplay.style.color = "red";
        } else {
            remainingTimeDisplay.style.color = "";
        }
    }, 1000);
}

setAlarmBtn.addEventListener("click", setAlarm);

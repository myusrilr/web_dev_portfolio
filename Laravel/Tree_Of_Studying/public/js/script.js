// preloader
// login
document.getElementById('btn_login').addEventListener('click', function (e) {
    e.preventDefault();

    // Sembunyikan login form dan bg-video
    document.getElementById('login_wrapper').style.display = 'none';
    document.getElementById('bg-video').style.display = 'none';

    // Tampilkan loader
    document.getElementById('loader').style.display = 'block';

    // Tunggu 3 detik sebelum melanjutkan
    setTimeout(() => {
        document.getElementById('loginForm').submit();
    }, 2000);
});

function removeCheckbox(checkboxId) {
    // Ambil elemen checkbox dan container-nya
    const checkbox = document.getElementById(checkboxId);
    const container = checkbox.closest('.position-relative');

    // Sembunyikan container yang berisi checkbox dan label
    if (container) {
        container.style.display = 'none';
    }
}

// date and time picker
$(function () {
    $("#datepicker").datepicker();
});

$(".clockpicker").clockpicker();

$.fn.datepicker.dates["en"] = {
    days: ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"],
    daysShort: ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"],
    daysMin: ["Mi", "Sen", "Sel", "Ra", "Ka", "Ju", "Sa"],
    months: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
    monthsShort: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agus", "Sep", "Ock", "Nov", "Des"],
    today: "Hari ini",
    clear: "bersihkan",
    format: "dd/mm/yyyy",
    titleFormat: "MM yyyy" /* Leverages same syntax as 'format' */,
    weekStart: 0,
};

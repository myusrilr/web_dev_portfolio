'use strict';



/**
 * add event on element. Fungsi ini sangat berguna ketika kita ingin menambahkan event listener pada satu elemen atau banyak elemen sekaligus. Misalnya, kita bisa menambahkan fungsi yang sama untuk semua tombol dalam halaman, atau hanya satu tombol, dengan menggunakan satu fungsi ini.
 */

const addEventOnElem = function (elem, type, callback) {
  if (elem.length > 1) {
    for (let i = 0; i < elem.length; i++) {
      elem[i].addEventListener(type, callback);
    }
  } else {
    elem.addEventListener(type, callback);
  }
}



/**
 * navbar toggle. Kode ini membuat sebuah navbar yang dapat dibuka dan ditutup dengan menggunakan tombol toggle (biasanya ikon hamburger). Saat pengguna mengklik salah satu link di dalam navbar, navbar akan otomatis tertutup. Perubahan pada tampilan biasanya dikendalikan oleh kelas active yang ditambahkan atau dihapus dari elemen-elemen tertentu.
 */

const navbar = document.querySelector("[data-navbar]");
const navbarLinks = document.querySelectorAll("[data-nav-link]");
const navToggler = document.querySelector("[data-nav-toggler]");

const toggleNavbar = function () {
  navbar.classList.toggle("active");
  navToggler.classList.toggle("active");
  document.body.classList.toggle("active");
}

addEventOnElem(navToggler, "click", toggleNavbar);

const closeNavbar = function () {
  navbar.classList.remove("active");
  navToggler.classList.remove("active");
  document.body.classList.remove("active");
}

addEventOnElem(navbarLinks, "click", closeNavbar);



/**
 * header active. Kode ini berfungsi untuk mengubah tampilan atau perilaku header ketika pengguna menggulir halaman web. Saat pengguna menggulir lebih dari 300 piksel, header akan mendapatkan kelas active, yang mungkin mengubah tampilannya (misalnya, menjadi lebih kecil atau berubah warna). Saat pengguna menggulir kembali ke atas, perubahan ini akan dihapus.
 */

const header = document.querySelector("[data-header]");

const activeHeader = function () {
  if (window.scrollY > 300) {
    header.classList.add("active");
  } else {
    header.classList.remove("active");
  }
}

addEventOnElem(window, "scroll", activeHeader);



/**
 * toggle active on add to fav. Kode ini memungkinkan pengguna untuk menandai atau membatalkan penandaan suatu item sebagai favorit dengan mengklik tombol tertentu. Saat tombol diklik, kelas active akan ditambahkan atau dihapus dari tombol tersebut, yang mungkin mengubah tampilannya (misalnya, mengubah warna atau ikon) untuk menunjukkan status favorit.
 */

// const addToFavBtns = document.querySelectorAll("[data-add-to-fav]");

// const toggleActive = function () {
//   this.classList.toggle("active");
// }

// addEventOnElem(addToFavBtns, "click", toggleActive);



/**
 * scroll reveal effect. Kode ini digunakan untuk mengungkapkan elemen-elemen tertentu pada halaman web saat pengguna menggulir ke bawah. Saat elemen-elemen ini muncul di sekitar 66.67% dari viewport, kelas active ditambahkan untuk mengubah tampilan mereka, sering kali digunakan untuk animasi atau efek visual. Ketika elemen keluar dari viewport (misalnya, saat pengguna menggulir ke atas), kelas active dihapus.
 */

// const sections = document.querySelectorAll("[data-section]");

// const scrollReveal = function () {
//   for (let i = 0; i < sections.length; i++) {
//     if (sections[i].getBoundingClientRect().top < window.innerHeight / 1.5) {
//       sections[i].classList.add("active");
//     } else {
//       sections[i].classList.remove("active");
//     }
//   }
// }

// scrollReveal();

// addEventOnElem(window, "scroll", scrollReveal);
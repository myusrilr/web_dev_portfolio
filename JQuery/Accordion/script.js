// JS STYLE
// ready digunakan untuk menunggu html karena jika tidak ada html maka tidak ada yang dimanipulasi
$(document).ready(function () {
  $(".accordion1").click(function () {
    $(".panel1").toggleClass("change1");
    $(".panel1").removeClass("panel1");
  });

  $(".accordion2").click(function () {
    $(".panel2").toggleClass("change2");
    $(".panel2").removeClass("panel2");
  });

  $(".accordion3").click(function () {
    $(".panel3").toggleClass("change3");
    $(".panel3").removeClass("panel3");
  });
});

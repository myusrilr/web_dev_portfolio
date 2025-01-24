// JS STYLE
// ready digunakan untuk menunggu html karena jika tidak ada html maka tidak ada yang dimanipulasi
$(document).ready(function () {
  document.getElementById("demo1").style.color = "BLUE";

  //   JQUERY STYLE
  $("#demo2").css("color", "red");

  let btn = document.getElementById("btn");
  let text = document.getElementById("output");
  //   fungsi dari variabel let text agar mudah untuk dipanggil atau digunakan kembali

  btn.addEventListener("click", function () {
    text.style.color = "RED";
    text.style.fontSize = "32px";
    text.style.fontWeight = "Bold";
  });

  let btn1 = document.getElementById("btn1");
  let text1 = document.getElementById("output1");

  btn1.addEventListener("click", function () {
    text1.classList.toggle("change");
  });

  //   JQUERY STYLE
  $("#btn2").click(function () {
    $("#output2").toggleClass("change");
  });

  $("#btn2").mouseover(function () {
    $("#btn2").css("background-color", "red");
    $("#btn2").css("color", "white");
  });
  $("#btn2").mouseout(function () {
    $("#btn2").css("background-color", "white");
    $("#btn2").css("color", "black");
  });
});

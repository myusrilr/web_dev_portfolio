var txt = "Sakinah Mawadah Warahmah";
var speed = 200;
var i = 0;
const text = document.getElementById("text");
const btn = document.getElementById("btn");

function type() {
  if (i < txt.length) {
    text.innerHTML += txt[i];
    i++;
    setTimeout(type, speed);
  }
}

btn.addEventListener("click", type);

var modal = document.getElementById("myModal");
var btn = document.getElementById("myBtn");
var span = document.getElementsByClassName("close")[0];


btn.onclick = function () {
    var text = document.getElementById("textInput");
    var input = document.getElementById("inputNumber").value;
    var number = parseInt(input);
    if (number >= 1 && number <= 10) {
        modal.style.display = "none";
        text.innerHTML = "You entered: " + number;
    } else {
        modal.style.display = "block";
    }
}

span.onclick = function () {
    modal.style.display = "none";
}

window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

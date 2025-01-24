function checkInput() {
    const username = document.getElementById("username").value;
    const email = document.getElementById("email").value;
    const password = document.getElementById("password1").value;
    const confirm = document.getElementById("password2").value;

    if (username =="") {
        console.log("username tidak boleh kosong");
    }
}

function click() {
    checkInput();
}

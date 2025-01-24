const signUpButton=document.getElementById('signUpButton');
const signInButton=document.getElementById('signInButton');
const signInForm=document.getElementById('signIn');
const signUpForm=document.getElementById('signup');
const username = document.getElementById("username");
const email = document.getElementById("email");
const password = document.getElementById("password");
const rePassword = document.getElementById("re-password");
const error_username = document.getElementById("error-username");
const error_email = document.getElementById("error-email");
const error_password = document.getElementById("error-password");
const error_rePassword = document.getElementById("error-re-password");

let regex = /^[a-zA-Z]+$/;
let regex_whitespace = /\s+/;
let regex_email = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
let regex_password = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/; 

signUpButton.addEventListener('click',function(){
    signInForm.style.display="none";
    signUpForm.style.display="block";
})
signInButton.addEventListener('click', function(){
    signInForm.style.display="block";
    signUpForm.style.display="none";
})
function check() {
    let user = username.value.trim();
    let userEmail = email.value.trim();
    let userPassword = password.value.trim();
    let userRePassword = rePassword.value.trim();

    check_username(user);
    check_email(userEmail);
    check_password(userPassword);
    check_rePassword(userPassword, userRePassword);
}

function check_username(user) {
    if (user.length != 0) {
        if (user.length >= 8) { 
            if (regex.test(user[0])) { 
                if (!(regex_whitespace.test(user))) { 
                    error_username.style.color = "GREEN";
                    error_username.innerHTML = "username granted";
                } else {
                    error_username.style.color = "RED";
                    error_username.innerHTML = "cannot contain any whitespace";
                }
            } else {
                error_username.style.color = "RED";
                error_username.innerHTML = "first character must be alphabetic";
            }
        } else {
            error_username.style.color = "RED";
            error_username.innerHTML = "username minimum character is 8";
        }
    } else {
        error_username.style.color = "RED";
        error_username.innerHTML = "username cannot be empty";
    }
    username.value = "";
}

function check_email(userEmail) {
    if (userEmail.length != 0) {
        if (regex_email.test(userEmail)) {
            error_email.style.color = "GREEN";
            error_email.innerHTML = "email granted";
        } else {
            error_email.style.color = "RED";
            error_email.innerHTML = "email must contain '@' and '.com'";
        }
    } else {
        error_email.style.color = "RED";
        error_email.innerHTML = "email cannot be empty";
    }
    email.value = "";
}
    


function check_password(userPassword) {
    if (userPassword.length != 0) {
        if (regex_password.test(userPassword)) {
            error_password.style.color = "GREEN";
            error_password.innerHTML = "password granted";
        } else {
            error_password.style.color = "RED";
            error_password.innerHTML = "password must be at least 8 characters, contain one uppercase letter, one lowercase letter, and one number";
        }
    } else {
        error_password.style.color = "RED";
        error_password.innerHTML = "password cannot be empty";
    }
    password.value = "";
}

function check_rePassword(userPassword, userRePassword) {
    if (userRePassword.length != 0) {
        if (userPassword == userRePassword) {
            error_rePassword.style.color = "GREEN";
            error_rePassword.innerHTML = "passwords match";
        } else {
            error_rePassword.style.color = "RED";
            error_rePassword.innerHTML = "passwords do not match";
        }
    } else {
        error_rePassword.style.color = "RED";
        error_rePassword.innerHTML = "re-password cannot be empty";
    }
    rePassword.value = "";
}

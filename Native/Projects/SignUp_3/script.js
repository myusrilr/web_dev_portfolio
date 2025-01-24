const username=document.getElementById("username");
const email=document.getElementById("email");
const error_username=document.getElementById("error-username");
const error_email=document.getElementById("error-email");
let regex=/^[a-zA-Z]+$/
let regex_whitespace=/\s+/ // simbol single spasi \s lebih dari satu spasi \s+
function check(){
    let user=username.value.trim()
    let mail=email.value.trim()
    check_username(user);
    check_email(mail);

}

function check_username(user){

    if(user.length!=0){
        if(user.length>=8){// check 8 char minimum
            if(regex.test(user[0])){ // check first char is alphabetic
                if(!(regex_whitespace.test(user))){ // check whitespace
                    username.value="";
                    error_username.style.color="GREEN";
                    error_username.innerHTML="username granted";
                }else{
                    username.value="";
                    error_username.style.color="RED";
                    error_username.innerHTML="cannot contain any whitespace";
                }
            }else{
            username.value="";
            error_username.style.color="RED";
            error_username.innerHTML="first charcater must be alphabetic";
            }
        }else{
            username.value="";
            error_username.style.color="RED";
            error_username.innerHTML="username minimum character is 8";
        }
    }else{
        username.value="";
        error_username.style.color="RED";
        error_username.innerHTML="username cannot be empty";
    }
}

function check_email(mail){
    if(mail.length!=0){
        if(!(mail.match(/@/gi))){
            if(!(mail.match(/.com/gi))){
                email.value="";
                error_email.style.color="GREEN";
                error_email.innerHTML="email granted";
            }else{
                email.value="";
                error_email.style.color="RED";
                error_email.innerHTML="missing .com";
            }

        }else{
        email.value="";
        error_email.style.color="RED";
        error_email.innerHTML="missing @";
        }
        

    }else{
        email.value="";
        error_email.style.color="RED";
        error_email.innerHTML="email cannot be empty";
    }

    
}
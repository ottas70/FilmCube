var loginDialog = document.querySelector("#login-dialog")
var loginBtn = document.querySelector("#login-btn")

var registerDialog = document.querySelector("#register-dialog")
var registerBtn = document.querySelector("#register-btn")

var loggedUserBtn = document.querySelector("#logged-user")
var dropMenu = document.querySelector(".dropdown")

var loginForm = document.querySelector("#login-form")
var registerForm = document.querySelector("#register-form")

var exitLoginBtn = document.querySelector("#loginExit");
var exitRegisterBtn = document.querySelector("#registerExit");

var dropdownOut = false;


function validateLoginForm(e){
    validateUsername(e,document.querySelector("#username"))
    validatePassword(e,document.querySelector("#password"))
}

function validateRegisterForm(e){
    validateUsername(e,document.querySelector("#username-register"))
    validateEmail(e,document.querySelector("#email"))
    validatePassword(e,document.querySelector("#passwordRegister"))
    confirmPassword(e,document.querySelector("#passwordRegister"), document.querySelector("#confirm"))
}

function validateUsername(e,username) {

    username.classList.remove("error")

    isEmpty(e,username)

    if(username.value.length < 4 && username.id != "username" && username.value.length > 15){
        username.classList.add("error")
        username.placeholder = "Username must have 4-15 characters"
        username.value = ""
        e.preventDefault()
    }
}

function validatePassword(e,password) {

    password.classList.remove("error")

    isEmpty(e,password)

    if(password.value.length < 8 && password.id != "password" && password.value != ""){
        password.classList.add("error")
        password.placeholder = "Minimum is 8 characters"
        password.value = ""
        e.preventDefault()
    }
}

//checks if input field is emptyi
function isEmpty(e,input){
    if(input.value == ""){
        input.classList.add("error")
        e.preventDefault()
    }
}

function validateEmail(e, email) {

    email.classList.remove("error")

    isEmpty(e,email)

    var re = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
    if(!re.test(email.value)  && email.value != ""){
        email.classList.add("error")
        email.placeholder = "Invalid email adress"
        email.value = ""
        e.preventDefault()
    }
}

function confirmPassword(e, firstPassword, confirmedPassword) {

    confirmedPassword.classList.remove("error")

    if(confirmedPassword.value != firstPassword.value){
        confirmedPassword.classList.add("error")
        confirmedPassword.placeholder = "Passwords don't match"
        confirmedPassword.value = ""
        e.preventDefault()
    }
}


loginForm.addEventListener("submit", function (e) {
    validateLoginForm(e)
})

registerForm.addEventListener("submit", function (e) {
    validateRegisterForm(e)
})

loginBtn.addEventListener("click",function () {
     loginDialog.style.display = "block"
})

registerBtn.addEventListener("click", function () {
    registerDialog.style.display = "block"
})

exitLoginBtn.addEventListener("click",function () {
    loginDialog.style.display = "none";
})

exitRegisterBtn.addEventListener("click",function () {
    registerDialog.style.display = "none";
})

loggedUserBtn.addEventListener("click", function (e) {
    if(dropdownOut){
        dropMenu.style.display = "none"
        dropdownOut = false;
    }else {
        dropMenu.style.display = "block"
        dropdownOut = true;
    }
})

window.addEventListener("click", function (e) {
    if(e.target == loginDialog){
        loginDialog.style.display = "none"
    }

    if(e.target == registerDialog){
        registerDialog.style.display = "none"
    }

    if(e.target != loggedUserBtn){
        dropMenu.style.display = "none"
    }

})







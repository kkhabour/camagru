
var loginLink = document.getElementById("login-link");
var registerLink = document.getElementById("register-link");


loginLink.addEventListener('click', showRegisterForm);
registerLink.addEventListener('click', showLoginForm);


function showLoginForm() {
    var loginForm = document.getElementsByClassName("main-wrapper-content-div-form-login")[0];
    var registerForm = document.getElementsByClassName("main-wrapper-content-div-form-register")[0];

    registerForm.style.display = "none";
    loginForm.style.display = "flex";
}

function showRegisterForm() {
    var loginForm = document.getElementsByClassName("main-wrapper-content-div-form-login")[0];
    var registerForm = document.getElementsByClassName("main-wrapper-content-div-form-register")[0];

    loginForm.style.display = "none";
    registerForm.style.display = "flex";
}
const navLogin = document.querySelector(".forms__nav__login");
const navReg = document.querySelector(".forms__nav__reg");

const formLogin = document.querySelector(".forms__login");
const formReg = document.querySelector(".forms__reg");

const agreement = document.querySelector("#agreement")

const regBtn = document.querySelector(".reg__enter");

navLogin.addEventListener("click", showLoginForm);
navReg.addEventListener("click", showRegForm);

const form = document.querySelector("#form");

if(form.innerText === " login" || form.innerText === " ")
    navLogin.click();
else if (form.innerText === " reg")
    navReg.click();
function showLoginForm(){
    formLogin.classList.add("form__active");
    navLogin.classList.add("forms__nav__active")

    formReg.classList.remove("form__active");
    navReg.classList.remove("forms__nav__active")
}

function showRegForm(){
    formReg.classList.add("form__active");
    navReg.classList.add("forms__nav__active")

    formLogin.classList.remove("form__active");
    navLogin.classList.remove("forms__nav__active");
}

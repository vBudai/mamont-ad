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

// Проверка данных формы
class LoginForm{

    form;

    loginField;
    loginErrField;

    passwordField;
    passwordErrField;

    constructor(form, loginField, passwordField, loginErr, passErr)
    {
        this.form = form;
        this.loginField = loginField;
        this.loginErrField = loginErr;

        this.passwordField = passwordField;
        this.passwordErrField = passErr;

        form.addEventListener('submit', this.SubmitForm.bind(this));
    }

    SubmitForm(event)
    {
        event.preventDefault(); // Отменяем отправку формы по умолчанию

        if(this.CheckForm())
            this.form.submit();
    }

    CheckForm()
    {
        if(this.loginField.value.trim() === ""){
            this.loginErrField.textContent = "Введите логин!";
            this.loginField.focus();
            return false;
        }
        else
            this.loginErrField.textContent = "";

        if(this.passwordField.value.trim() === ""){
            this.passwordErrField.textContent = "Введите пароль!";
            this.passwordErrField.focus();
            return false;
        }
        else
            this.passwordErrField.textContent = "";

        return true;
    }

}


class RegistrationForm{

    form;

    emailField;
    emailFieldErr;

    phoneField;
    phoneFieldErr;

    loginField;
    loginFieldErr;

    passwordField;
    passwordRepeatField;
    passwordFieldErr;

    agreementField;


    constructor(form, emailField, emailFieldErr, phoneField, phoneFieldErr, loginField, loginFieldErr, passwordField, passwordRepeatField, passwordFieldErr, agreementField)
    {
        this.form = form;

        this.emailField = emailField;
        this.emailFieldErr = emailFieldErr;

        this.phoneField = phoneField;
        this.phoneFieldErr = phoneFieldErr;

        this.loginField = loginField;
        this.loginFieldErr = loginFieldErr;

        this.passwordField = passwordField;
        this.passwordRepeatField = passwordRepeatField;
        this.passwordFieldErr = passwordFieldErr;

        this.agreementField = agreementField;

        this.form.addEventListener('submit', this.SubmitForm.bind(this));
    }

    SubmitForm(event)
    {
        event.preventDefault();

        if(this.CheckForm())
            this.form.submit();
    }

    CheckForm()
    {
        let result = true;

        // Проверка почты
        if(this.emailField.value.trim() === ""){
            this.emailFieldErr.textContent = "Введите email!"
            result = false;
        }
        else
            this.emailFieldErr.textContent = ""

        // Проверка телефона
        if(this.phoneField.value.trim() === ""){
            this.phoneFieldErr.textContent = "Введите телефон!"
            result = false;
        }
        else
            this.phoneFieldErr.textContent = ""

        // Проверка логина
        if(this.loginField.value.trim() === ""){
            this.loginFieldErr.textContent = "Введите телефон!"
            result = false;
        }
        else
            this.loginFieldErr.textContent = ""

        // Проверка пароля
        if(this.passwordField.value.trim() === ""){
            this.passwordFieldErr.textContent = "Введите пароль!"
            result = false;
        }
        else if (this.passwordField.value !== this.passwordRepeatField.value){
            this.passwordFieldErr.textContent = "Пароли не совпадают!"
            result = false;
        }
        else
            this.passwordFieldErr.textContent = ""

        // Проверка согласия
        if(!agreement.checked)
            result = false;





        return result;
    }

}


const loginForm = new LoginForm(
    document.getElementsByClassName("forms__login")[0],
    document.getElementById("login_login"),
    document.getElementById("login_password"),
    document.getElementById("login_login_err"),
    document.getElementById("login_password_err")
)
//form, emailField, emailFieldErr, phoneField, phoneFieldErr, loginField, loginFieldErr, passwordField, passwordRepeatField, passwordFieldErr, agreementField
const regForm = new RegistrationForm(
    document.getElementsByClassName("forms__reg")[0], // form
    document.getElementById("reg_email"), //emailField
    document.getElementById("reg_mail_err"), //emailFieldErr
    document.getElementById("reg_phone"), //phoneField
    document.getElementById("reg_phone_err"), //phoneFieldErr
    document.getElementById("reg_login"), //loginField
    document.getElementById("reg_login_err"), //loginFieldErr
    document.getElementById("reg_pass1"), //passwordField
    document.getElementById("reg_pass2"), //passwordRepeatField
    document.getElementById("reg_pass_err"), //passwordFieldErr
    document.getElementById("agreement") //agreementField
)
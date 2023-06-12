class SettingsFormChecker
{
    form;

    passwordField;
    newPasswordField;
    newPasswordRepeatField;
    passwordErrField;

    emailField;
    emailErrField;

    phoneField;
    phoneErrField;

    constructor(form, passwordField, newPasswordField, newPasswordRepeatField, passwordErrField, emailField, emailErrField, phoneField, phoneErrField) {
        this.form = form;

        this.passwordField = passwordField;
        this.newPasswordField = newPasswordField;
        this.newPasswordRepeatField = newPasswordRepeatField;
        this.passwordErrField = passwordErrField;

        this.emailField = emailField;
        this.emailErrField = emailErrField;

        this.phoneField = phoneField;
        this.phoneErrField = phoneErrField;

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

        // Проверка полей с паролями
        if(this.passwordField.value.trim() === "" && (this.newPasswordField.value !== "" || this.newPasswordRepeatField.value !== "")){
            this.passwordErrField.textContent = "Введите ваш пароль!";
            this.passwordField.value = "";
            this.passwordField.focus();
            result = false;
        }
        else if(this.passwordField.value.trim() !== "" && this.newPasswordField.value.trim() === ""){
            this.passwordErrField.textContent = "Введите новый пароль!";
            this.newPasswordField.value = "";
            this.newPasswordField.focus();
            result = false;
        }
        else if(this.passwordField.value.trim() !== "" && this.newPasswordField.value.trim() !== "" && this.newPasswordRepeatField.value.trim() === ""){
            this.passwordErrField.textContent = "Повторите пароль!";
            this.newPasswordRepeatField.value = "";
            this.newPasswordField.focus();
            result = false;
        }
        else if(this.newPasswordField.value !== this.newPasswordRepeatField.value){
            this.passwordErrField.textContent = "Пароли не совпадают!";
            result = false;
        }
        else
            this.passwordErrField.textContent = "";

        // Проверка телефона
        if(this.phoneField.value !== "" &&  !this.isValidPhone(this.phoneField.value)){
            this.phoneErrField.textContent = "Неккоректный формат номера!"
            this.phoneField.focus();
            result = false;
        }
        else{
            this.phoneErrField.textContent = ""
        }


        // Проверка телефона
        if(this.emailField.value !== "" && !this.isValidEmail(this.emailField.value)){
            this.emailErrField.textContent = "Неккоректный формат почты!"
            this.emailErrField.focus();
            result = false;
        }
        else{
            this.emailErrField.textContent = "";
        }

        return result;
    }

    isValidEmail(email)
    {
        const emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
        return emailRegex.test(email);
    }

    isValidPhone(phoneNumber)
    {
        const phoneRegex = /^[1-9]\d{1,14}$/;
        return phoneRegex.test(phoneNumber);
    }


}


let formChecker = new SettingsFormChecker(
    document.querySelector(".profile__settings"),

    document.querySelector("#password"),
    document.querySelector("#newPassword"),
    document.querySelector("#newPasswordRepeat"),
    document.querySelector(".settings__password .form__error"),

    document.querySelector(".settings__email input"),
    document.querySelector(".settings__email .form__error"),

    document.querySelector(".settings__phone input"),
    document.querySelector(".settings__phone .form__error")
)


















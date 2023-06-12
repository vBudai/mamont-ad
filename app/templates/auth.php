<?php

$login_name = "";
$login_name_err = "";
$login_password_err = "";

$default_form = "";

if(isset($_SESSION['form']) && $_SESSION['form'] === "login"){
    $default_form = "login";

    unset($_SESSION['form']);

    if(isset($_SESSION['login'])){
        $login_name = $_SESSION['login'];
        unset($_SESSION['login']);
    }
    if(isset($_SESSION['login_err'])){
        $login_name_err = $_SESSION['login_err'];
        unset($_SESSION['login_err']);
    }
    if(isset($_SESSION['password_err'])){
        $login_password_err = $_SESSION['password_err'];
        unset($_SESSION['password_err']);
    }
}

$reg_name = "";
$reg_name_err = "";

$reg_email = "";
$reg_email_err = "";

$reg_phone = "";
$reg_phone_err = "";

if(isset($_SESSION['form']) && $_SESSION['form'] === "reg"){
    $default_form = "reg";

    unset($_SESSION['form']);

    if(isset($_SESSION['login'])){
        $reg_name = $_SESSION['login'];
        $reg_name_err = "Такой логин уже используется";
        unset($_SESSION['login']);
    }
    if(isset($_SESSION['email'])){
        $reg_email = $_SESSION['email'];
        $reg_email_err = "Такая почта уже используется";
        unset($_SESSION['email']);
    }
    if(isset($_SESSION['phone_number'])){
        $reg_phone = $_SESSION['phone_number'];
        $reg_phone_err = "Такой номер уже используется";
        unset($_SESSION['phone_number']);
    }
}




?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Вход</title>

    <link href="styles/reset.css" rel="stylesheet" type="text/css">
    <link href="styles/page.css" rel="stylesheet" type="text/css">
    <link href="styles/header.css" rel="stylesheet" type="text/css">
    <link href="styles/auth.css" rel="stylesheet" type="text/css">

</head>
<body>
<?php require_once __DIR__ . "/header.php"; ?>

<span id="form" style="display: none; position: absolute;"> <?=$default_form ?></span>

<div class="forms">

    <nav class="forms__nav">
        <button class="forms__nav__login">Логин</button>
        <button class="forms__nav__reg">Регистрация</button>
    </nav>

    <form action="auth/login" class="forms__login" method="post">
        <span class="login__title">Вход</span>

        <div class="form__container">
            <input id="login_login" type="text" class="form__input" placeholder="Логин, email, телефон" name="login" value="<?= $login_name ?>">
            <span id="login_login_err" class="form__error"><?= $login_name_err ?></span>
        </div>

        <div class="form__container">
            <input id="login_password" type="password" class="form__input" placeholder="Введите пароль" name="password">
            <span id="login_password_err" class="form__error"><?= $login_password_err ?> </span>
        </div>

        <input type="submit" class="login__enter" value="ВОЙТИ">
    </form>


    <form action="auth/registration" class="forms__reg" method="post">

        <span class="reg__title-question">Ещё не мамонт?</span>
        <span class="reg__title-reg">Регистрируйся</span>

        <div class="form__container">
            <input id="reg_email" type="text" class="form__input" placeholder="Почта" name="email" value="<?= $reg_email ?>">
            <span id="reg_mail_err" class="form__error"><?= $reg_email_err ?></span>
        </div>

        <div class="form__container">
            <input id="reg_phone" type="text" class="form__input" placeholder="Номер телефона" name="phone_number" value="<?= $reg_phone ?>">
            <span id="reg_phone_err" class="form__error"><?= $reg_phone_err ?></span>
        </div>


        <div class="form__container">
            <input id="reg_login" type="text" class="form__input" placeholder="Придумайте логин" name="login" value="<?= $reg_name ?>">
            <span id="reg_login_err" class="form__error"><?= $reg_name_err ?></span>
        </div>


        <div class="form__container">
            <input id="reg_pass1" type="password" class="form__input" placeholder="Пароль" name="password">
            <input id="reg_pass2" type="password" class="form__input" placeholder="Повторите пароль">
            <span id="reg_pass_err" class="form__error"></span>
        </div>

        <div class="reg__agreement">
            <input type="checkbox" id="agreement">
            <label for="agreement">
                Я согласен на обработку персональных данных
            </label>
        </div>


        <input type="submit" class="reg__enter" value="ЗАРЕГИСТРИРОВАТЬСЯ">
        
    </form>

</div>


<script src="scripts/auth.js"></script>

</body>
</html>

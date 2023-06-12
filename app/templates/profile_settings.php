<?php

$login = "";
$email = "";
$phone = "";

$login_err = "";
$email_err = "";
$phone_err = "";
$password_err = "";

if(isset($_SESSION['phone_number'])){
    $phone = $_SESSION['phone_number'];
    $phone_err = "Такой номер уже занят";
    unset($_SESSION['phone_number']);
}

if(isset($_SESSION['login'])){
    $login = $_SESSION['login'];
    $login_err = "Такой логин уже занят";
    unset($_SESSION['login']);
}

if(isset($_SESSION['email'])){
    $login = $_SESSION['email'];
    $phone_err = "Такая почта уже занята";
    unset($_SESSION['email']);
}

if(isset($_SESSION['password'])){
    $password_err = "Неправильный пароль";
    unset($_SESSION['password']);
}


?>

<html>
<head>

    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Настройки профиля</title>

    <link href="../styles/reset.css" rel="stylesheet" type="text/css">
    <link href="../styles/page.css" rel="stylesheet" type="text/css">
    <link href="../styles/header.css" rel="stylesheet" type="text/css">
    <link href="../styles/profile_settings.css" rel="stylesheet" type="text/css">

</head>
<body>

<?php require_once __DIR__ . "/header.php"; ?>



<div class="profile">

    <div class="profile__menu">

        <div class="profile__menu__user">
            <div class="profile__user__img">
                <img src="images/no_user_avatar.svg" alt="">
            </div>

            <div class="profile__user__name"><?= $data['username'] ?></div>

        </div>
        <div class="profile__menu__list">
            <ul>
                <a href="../profile/my_ads"><li>Мои объявления</li></a>
                <a href="../profile/watched"><li>Просмотренные</li></a>
                <a href=""><li>Сообщения</li></a>
                <a href="../profile/favorites"><li>Избранные</li></a>
                <a href="../profile/archive"><li>Архив</li></a>
                <a href="../profile/settings"><li class="profile__menu__list__settings">Настройки</li></a>
                <a href="../profile/exit"><li class="profile__menu__list__exit">Выйти</li></a>
            </ul>
        </div>

    </div>

    <div class="profile__content">

        <div class="content__title__320">
            <h1>
                Настройки
            </h1>
        </div>


        <form class="profile__settings" method="post" action="settings/set">

            <div class="content__title__744">
                <h1>
                    Настройки
                </h1>
            </div>


            <div class="settings__login">
                <span>Логин</span>
                <input type="text" placeholder="Введите желаемый логин" name="login" value="<?=$login?>">
                <span class="form__error"><?=$login_err?></span>
            </div>

            <div class="settings__name">
                <div class="settings__name__first">
                    <span>Имя</span>
                    <input type="text" placeholder="Сюда ваше имя" name="first_name">
                </div>


                <div class="settings__name__second">
                    <span>Фамилия</span>
                    <input type="text" placeholder="А сюда фамилию" name="last_name">
                </div>
            </div>




            <div class="settings__password">
                <span>Пароль</span>
                <input id="password" type="password" placeholder="Введите действующий пароль">
                <input id="newPassword" type="password" placeholder="Введите новый пароль" name="password_md5">
                <input id="newPasswordRepeat" type="password" placeholder="Повторите новый пароль">
                <span class="form__error"><?=$password_err?></span>
            </div>

            <div class="settings__email">
                <span>Почта</span>
                <input type="text" placeholder="Введите новую почту" name="email" value="<?=$email?>">
                <span class="form__error"><?=$email_err?></span>
            </div>

            <div class="settings__phone">
                <span>Телефон</span>
                <input type="text" placeholder="Введите новый телефон" name="phone_number" value="<?=$phone?>">
                <span class="form__error"><?=$phone_err?></span>
            </div>

            <button class="settings__submit" type="submit" >Сохранить изменения</button>


        </form>


    </div>

</div>


<script src="../scripts/profile_settings.js"></script>
</body>
</html>

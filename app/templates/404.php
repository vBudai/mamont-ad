<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Страница не найдена</title>

    <link href="../styles/reset.css" rel="stylesheet" type="text/css">
    <link href="../styles/page.css" rel="stylesheet" type="text/css">
    <link href="../styles/404.css" rel="stylesheet" type="text/css">
</head>



<body>

<div class="err__container">
    <div class="err">

        <div class="err__text">

            <span>Упс!</span>
            <span>Похоже, такой страницы нет</span>
            <span class="err__text__code">Код ошибки: 404</span>
            <span class="err__text__redirect">
            Попробуйте перейти на <a href="<?=BASE_URL?>">главную страницу</a>
        </span>

        </div>

        <div class="err__image">
            <img src="../images/404_image.svg">
        </div>

    </div>
</div>




</body>



</html>
<?php
?>



<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Создание объявления</title>

    <link href="styles/reset.css" rel="stylesheet" type="text/css">
    <link href="styles/page.css" rel="stylesheet" type="text/css">
    <link href="styles/header.css" rel="stylesheet" type="text/css">
    <link href="styles/create_ad.css" rel="stylesheet" type="text/css">
</head>
<body>

<?php require_once __DIR__ . "/header.php"; ?>


<div class="form__container">

    <form action="create_ad/create" class="createAd" method="post" enctype="multipart/form-data">

        <div class="createAd__category">
            <span>Категория</span>
            <input type="hidden" name="id_main_category" value="">
            <div class="category__first">
                Выберите категорию
            </div>

            <ul id="main_category" class="">
                <li id="1">Транспорт</li>
                <li id="2">Недвижимость</li>
                <li id="3">Услуги</li>
                <li id="4">Личные вещи</li>
                <li id="5">Работа</li>
                <li id="6">Хобби и отдых</li>
                <li id="7">Животные</li>
                <li id="8">Электроника</li>
            </ul>
        </div>

        <div class="createAd__title">
            <span>Название</span>
            <input type="text" name="title" id="" placeholder="Название">
        </div>


        <div class="createAd__desc">
            <span>Описание товара</span>
            <textarea name="description" id="" cols="30" rows="10" placeholder="Введите описание"></textarea>
        </div>

        <div class="createAd__price">
            <span>Цена</span>
            <input name="min_price" type="text" class="min" placeholder="от">
            <div class="slash"></div>
            <input name="max_price" type="text" class="max" placeholder="до">
        </div>


        <div class="createAd__photos">
            <span>Фотографии</span>
            <input id="ad_photos" name="ad_photos[]" type="file" accept="image/png, image/gif, image/jpeg" multiple>
            <label for="ad_photos">
                <img src="images/add_image_icon.svg" alt="">
                <span>Не более 5 фотографий</span>
            </label>
            <span class="photos__desc">Не более 5 фотографий</span>
        </div>


        <div class="createAd__city">
            <span>Местоположение</span>
            <input id="input_city" type="text" placeholder="Выберите из списка или введите" name="id_city">
            <ul class="">
                <li>г. Сургут</li>
                <li>г. Нефтеюганск</li>
                <li>г. Лянтор</li>
                <li>г. Пыть-ях</li>
                <li>г. Нижневартовск</li>
            </ul>
        </div>


            <input class="createAd__submit" type="submit" value="Опубликовать">



    </form>

</div>

    <script src="scripts/create_ad.js"></script>

</body>

</html>
<?php

$isEdit = false;

if($adInfo !== [])
    $isEdit = true;

?>



<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= $isEdit ? "Редактирование объявления" : "Создание объявления"  ?></title>

    <link href="../../styles/reset.css" rel="stylesheet" type="text/css">
    <link href="../../styles/page.css" rel="stylesheet" type="text/css">
    <link href="../../styles/header.css" rel="stylesheet" type="text/css">
    <link href="../../styles/create_ad.css" rel="stylesheet" type="text/css">
</head>
<body>

<?php require_once __DIR__ . "/header.php"; ?>


<div class="form__container">

    <form action="<?= $isEdit ? "../../create_ad/edit/".$adInfo['id']."/set" : "../../create_ad/create"  ?>" class="createAd" method="post" enctype="multipart/form-data">

        <div class="createAd__category">
            <span>Категория</span>
            <input type="hidden" name="id_main_category" value="<?= $isEdit ? $adInfo['category'] : ""  ?>">
            <div class="category__first">
                <?= $isEdit ? $adInfo['category'] : "Выберите категорию"  ?>
            </div>
            <span class="err"></span>

            <ul id="main_category" class="">
                <?php for($i = 0; $i < count($categories); ++$i)
                    echo '<li>' . $categories[$i] . '</li>'?>
            </ul>
        </div>

        <div class="createAd__title">
            <span>Название</span>
            <input type="text" name="title" id="" placeholder="Название" value="<?= $isEdit ? $adInfo['title'] : ""  ?>">
            <span class="err"></span>
        </div>


        <div class="createAd__desc">
            <span>Описание товара</span>
            <textarea name="description" id="" cols="30" rows="10" placeholder="Введите описание" ><?= $isEdit ? $adInfo['description'] : ""  ?></textarea>
            <span class="err"></span>
        </div>

        <div class="createAd__price">
            <span>Цена</span>
            <input name="min_price" type="text" class="min" placeholder="от" value="<?= $isEdit ? $adInfo['min_price'] : ""  ?>">
            <div class="slash"></div>
            <input name="max_price" type="text" class="max" placeholder="до" value="<?= $isEdit ? $adInfo['max_price'] : ""  ?>">
            <span class="err"></span>
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
            <input id="input_city" type="text" value="<?= $isEdit ? $adInfo['city'] : "Выберите город из списка"  ?>" name="id_city"  readonly>
            <span class="err"></span>
            <ul class="">
                <?php for($i = 0; $i < count($cities); ++$i)
                    echo '<li>' . $cities[$i] . '</li>'?>
            </ul>
        </div>


        <input class="createAd__submit" type="submit" value="Опубликовать">



    </form>

</div>

    <script src="../../scripts/create_ad.js"></script>
    <script src="../../scripts/header.js"></script>

</body>

</html>
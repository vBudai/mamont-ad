<?php

?>



<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Объявление</title>

    <link href="../styles/reset.css" rel="stylesheet" type="text/css">
    <link href="../styles/page.css" rel="stylesheet" type="text/css">
    <link href="../styles/header.css" rel="stylesheet" type="text/css">
    <link href="../styles/ad.css" rel="stylesheet" type="text/css">
</head>

<body>

<?php require_once __DIR__ . "/header.php"; ?>


<div class="ad">

    <div class="ad__container">
        <div class="ad__images">

            <div class="images__container">
                <?php
                    for($i = 0; $i < count($data['images']); $i++){
                        echo '<img class="" src="' . $data['images'][$i] . '" alt="">';
                    }
                ?>
            </div>

            <div class="images__slider">
                <?php
                if(count($data['images']) === 1)
                    echo '<label class="" style="display: none"></label>';
                else
                    for($i = 0; $i < count($data['images']); $i++)
                        echo '<label class=""></label>';

                ?>
            </div>
        </div>

        <div class="ad__main-info">
            <div>
                <span class="main-info__price">
                    <?php echo $data['min_price'] . "-" . $data['max_price'];?>
                </span>
                <span class="main-info__title">
                    <?=$data['title']?>
                </span>
            </div>

            <?php if($data['isFavorite'] === true):?>
                <a href="../../profile/favorites/delete/<?=$data['id']?>" target="_blank">
                    <img class="main-info__favorite" src="../images/favorites_icon_red.svg" alt="" >
                </a>
            <?php else: ?>
                <a href="../../profile/favorites/add/<?=$data['id']?>" target="_blank">
                    <img class="main-info__favorite" src="../images/favorites_icon.svg" alt="" >
                </a>
            <?php endif; ?>
        </div>

        <div class="ad__desc">
            <div>
                <?=$data['description']?>
            </div>
            <div class="ad__footer max">
                <div class="footer__item">
                    <span class="item__title">Местоположение</span>
                    <span class="item__name"><?=$data['city']?></span>
                </div>
                <div class="footer__item">
                    <span class="item__title">Категория</span>
                    <span class="item__name"><?=$data['main_category']?></span>
                </div>
            </div>
        </div>

        <div class="ad__get-creator-info">
            Связаться
        </div>
    </div>



    <div class="ad__creator">
        <div class="creator__avatar">
            <img src="../images/no_user_avatar.svg">
        </div>

        <div class="creator__name">
            <?=$data['username']?>
        </div>
    </div>

    <div class="ad__dop-info">
        <div class="dop-info__date">
            <?=$data['date']?>
        </div>
        <div class="dop-info__views-and-favorites">
            <div class="dop-info__views">
                <?=$data['watchedCount']?>
            </div>
            <div class="dop-info__favorites">
                <?=$data['favoriteCount']?>
            </div>
        </div>
    </div>

    <div class="ad__footer mini">
        <div class="footer__item">
            <span class="item__title">Местоположение</span>
            <span class="item__name"><?=$data['city']?></span>
        </div>
        <div class="footer__item">
            <span class="item__title">Категория</span>
            <span class="item__name"><?=$data['main_category']?></span>
        </div>
    </div>

</div>

<div class="number">
    <div class="number__content">
        <span><?=$data['phone_number']?></span>
        <div class="number__close">X</div>
    </div>
</div>

<script src="../scripts/ad.js"></script>
<script src="../scripts/header.js"></script>



</body>
</html>

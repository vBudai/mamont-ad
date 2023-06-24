<?php


?>

<html>
<head>

    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?=$title?></title>

    <link href="../styles/reset.css" rel="stylesheet" type="text/css">
    <link href="../styles/page.css" rel="stylesheet" type="text/css">
    <link href="../styles/header.css" rel="stylesheet" type="text/css">
    <link href="../styles/profile_ads.css" rel="stylesheet" type="text/css">

</head>
<body>

<?php require_once __DIR__ . "/header.php"; ?>



<div class="profile">

    <div class="profile__menu">

        <a href="../comment/user=<?=$data['id_user']?>">
            <div class="profile__menu__user">
                <div class="profile__user__img">
                    <img src="images/no_user_avatar.svg" alt="">
                </div>
                <div>
                    <div class="profile__user__name"><?= $data['username'] ?></div>
                    <div class="creator__raiting"><?= $data['raiting'] ?></div>
                </div>
            </div>
        </a>

        <div class="profile__menu__list">
            <ul>
                <a href="../profile/my_ads"><li>Мои объявления</li></a>
                <a href="../profile/watched"><li>Просмотренные</li></a>
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
                <?= $title ?>
            </h1>
        </div>


        <section class="ads">

            <div class="content__title__744">
                <h1>
                    <?= $title ?>
                </h1>
            </div>

            <?php for($i = 0; $i < count($data)-3; $i++){ ?>

            <div class="ads__ad">
                <a href="../ad/<?=$data[$i]['id']?>"><img class="ads__ad__mainImage" src="<?=$data[$i]['image_url']?>"/></a>
                <div class="ads__ad__info">
                    <div class="ads__ad__info__price-and-title">
                        <span class="main-info__price">
                            <?php echo $data[$i]['min_price'] . "-" . $data[$i]['max_price'];?>
                        </span>
                        <span id="ad__title">
                            <?=$data[$i]['title']?>
                        </span>
                    </div>
                    <div class="ads__ad__info__date">
                        <?=$data[$i]['date']?>
                    </div>
                </div>
                <div class="ads__ad__settings">
                <?php if($title === "Избранные"): ?>
                    <a class="ads__ad__setting__img" href="../profile/favorites/delete/<?=$data[$i]['id']?>"><img class="ads__ad__setting__img" src="../images/delete_watched.svg" alt=""></a>
                <?php else:{?>
                    <img class="ads__ad__setting__img" src="../images/adSetting_icon.svg" alt="">
                    <object class="ad__settings">
                        <ul>
                            <?php if($title === "Просмотренные"):?>
                                <a href="../profile/favorites/add/<?=$data[$i]['id']?>"><li>В избранное</li></a>
                            <?php else:?>
                                <a href="../create_ad/edit/<?=$data[$i]['id']?>"><li>Редактировать</li></a>
                            <?php endif; ?>

                            <?php if($title === "Мои объявления"):?>
                                <a href="../profile/archiveAd/<?=$data[$i]['id']?>"><li>Архивировать</li></a>
                            <?php elseif($title === "Архивированные"):?>
                                <a href="../profile/unarchiveAd/<?=$data[$i]['id']?>"><li>Разархивировать</li></a>
                            <?php endif; ?>

                            <?php if($title === "Мои объявления" || $title === "Архивированные") : ?>
                                <a href="../profile/deleteAd/<?=$data[$i]['id']?>"><li>Удалить</li></a>
                            <?php elseif($title === "Просмотренные") : ?>
                                <a href="../profile/deleteWatched/<?=$data[$i]['id']?>"><li>Удалить</li></a>
                            <?php endif; ?>
                        </ul>
                    </object>

                <?php } endif;?>
                </div>
            </div>

        <?php }?>

        </section>


    </div>

</div>








<script src="../scripts/profile_ads.js"></script>
</body>
</html>

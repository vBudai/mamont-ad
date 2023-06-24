
<?php

$username = $data['username'];
unset($data['username']);

$userRaiting = $data['raiting'];
unset($data['raiting']);

$dataSize = count($data);

?>
<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Отзывы на пользователи</title>

<link href="../../styles/reset.css" rel="stylesheet" type="text/css">
<link href="../../styles/page.css" rel="stylesheet" type="text/css">
<link href="../../styles/header.css" rel="stylesheet" type="text/css">
<link href="../../styles/comment_user.css" rel="stylesheet" type="text/css">
</head>
<body>

<?php require_once __DIR__ . "/header.php"; ?>



<div class="user">

    <div class="user__img">
        <img src="../../images/no_user_avatar.svg" alt="">
    </div>

    <div class="user__info">
        <div class="info__name">
            <?= $username ?>
        </div>
        <div class="info__raiting">
            <img src="../../images/star_empty.svg" alt="">
            <span><?=$userRaiting?></span>
        </div>
    </div>

</div>


<div class="comments">

    <div class="comments__content">
        <div class="content__title">
            Всего отзывов <?=$dataSize?>:
        </div>

        <?php

        for($i = 0; $i < $dataSize; ++$i){
            $raiting = $data[$i]['raiting'];
        ?>

        <div class="content__comment">
            <div class="comment__user">
                <a href="../comment/user=<?=$data[$i]['id_creator']?>">
                    <img src="../../images/no_user_avatar.svg" alt="">
                </a>

            </div>
            <div class="comment__data">
                <div class="data__raiting">
                    <?php
                        for($j = 0; $j < 5; ++$j)
                            if($j < $raiting)
                                echo '<img src="../../images/star_yellow.svg" alt="">';
                            else
                                echo '<img src="../../images/star_empty.svg" alt="">';
                    ?>
                </div>
                <?php if($data[$i]['text'] !== ""): ?>
                    <div class="data__text">
                        <?= $data[$i]['text'] ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php
            if($data[$i]['id_creator'] == $id_user):
            ?>
                <div class="comment__settings">
                    <img src="../../images/adSetting_icon.svg">
                    <ul>
                        <a href="edit=<?=$data[$i]['id']?>"><li>Редактировать</li></a>
                        <a href="delete=<?=$data[$i]['id']?>"><li>Удалить</li></a>
                    </ul>
                </div>
            <?php endif; ?>
        </div>

        <?php } ?>

    </div>

</div>


<script src="../../scripts/comments_user.js"></script>
<script src="../../scripts/header.js"></script>
</body>
</html>
<!DOCTYPEc html>

<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Разместить комментарий</title>

<link href="../../styles/reset.css" rel="stylesheet" type="text/css">
<link href="../../styles/page.css" rel="stylesheet" type="text/css">
<link href="../../styles/header.css" rel="stylesheet" type="text/css">
<link href="../../styles/comment_user_form.css" rel="stylesheet" type="text/css">
</head>
<body>

<?php require_once __DIR__ . "/header.php"; ?>


<div class="form__container">
    <div class="container__title">
        Оставьте отзыв о продавце
    </div>

    <?php if($data === []): ?>
    <form id="comment_form" action="user=<?=$id_user?>/create" method="post">
    <?php else: ?>
    <form id="comment_form" action="edit=<?=$data['id']?>/set" method="post">
    <?php endif; ?>
        <input name="comment_raiting" type="text" hidden id="raiting">
        <div class="form__star">
            <?php
            if(isset($data['raiting']))
                for($i = 0; $i < 5; ++$i)
                    if($i < $data['raiting'])
                        echo '<img src="../../images/star_yellow.svg">';
                    else
                        echo '<img src="../../images/star_empty.svg">';
            else{
                echo '<img src="../../images/star_empty.svg">';
                echo '<img src="../../images/star_empty.svg">';
                echo '<img src="../../images/star_empty.svg">';
                echo '<img src="../../images/star_empty.svg">';
                echo '<img src="../../images/star_empty.svg">';
            }
            ?>
        </div>

        <textarea name="comment_text" placeholder="Расскажите подробнее, как все прошло"><?php if(isset($data['text'])) echo $data['text'];?></textarea>
        <span class="comment_form_error"></span>
        <input type="submit">
    </form>
</div>



<script src="../../scripts/comment_user_form.js"></script>
<script src="../../scripts/header.js"></script>
</body>
</html>
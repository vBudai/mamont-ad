<?php
/*echo '<pre>';
var_dump($this->modelData);
echo '</pre>';
*/?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Объявления</title>

        <link href="styles/reset.css" rel="stylesheet" type="text/css">
        <link href="styles/page.css" rel="stylesheet" type="text/css">
        <link href="styles/header.css" rel="stylesheet" type="text/css">
        <link href="styles/ads.css" rel="stylesheet" type="text/css">
    </head>
<body>

<?php require_once __DIR__ . "/header.php"; ?>

    <div class="ads-container">

        <section class="filter">
            <span class="filter__title">
                Фильтры
            </span>

            <div class="filter__main-params">
                <div class="filter__main-params__city">
                    <label>
                        Где искать
                    </label>
                    <input type="text" placeholder="Город">
                    <div class="filter__main-params__city__list">
                        <ul>
                            <li>Сургут</li>
                            <li>Пыть-ях</li>
                            <li>Нефтеюганск</li>
                            <li>Лянтор</li>
                            <li>Нижневартовск</li>
                            <li>Белый Яр</li>
                        </ul>
                    </div>
                </div>

                <div class="filter__main-params__price">
                    <label>
                        Цена
                    </label>
                    <input type="text" placeholder="от">
                    <span class="slash"></span>
                    <input type="text" placeholder="до">
                </div>
            </div>

            <div class="filter__sorting">
                <label class="filter__sorting__title">
                    Сортировка
                </label>
                <div class="filter__sorting__types">
                    <div class="filter__sorting__types__default">
                        <input id="default" type="radio" name="sorting-type" value="default" checked>
                        <label for="default">По умолчанию</label>
                    </div>
                    <div class="filter__sorting__types__date">
                        <input id="date" type="radio" name="sorting-type" value="date">
                        <label for="date">По дате</label>
                    </div>
                    <div class="filter__sorting__types__cheaper">
                        <input id="cheaper" type="radio" name="sorting-type" value="cheaper">
                        <label for="cheaper">Дешевле</label>
                    </div>
                    <div class="filter__sorting__types__expensive">
                        <input id="expensive" type="radio" name="sorting-type" value="expensive">
                        <label for="expensive">Дороже</label>
                    </div>
                </div>
            </div>

        </section>

        <!-- ================ Объявления ================ -->

        <section class="ads">
            <h1 class="ads__title">Все объявления</h1>

            <?php for ($i = 0; $i < count($ads); $i++) { ?>

            <div class="ads__ad">
                <a href="http://mamont-ad/ad/<?=$ads[$i]['id']?>">
                    <img src="<?=$ads[$i]['image_url']?>" class="ads__ad__mainImage" />
                </a>
                <div class="ads__ad__info">
                    <div class="ads__ad__info__price-and-title">
                        <span class="main-info__price">
                            <?php echo $ads[$i]['min_price'] . "-" . $ads[$i]['max_price'];?>
                        </span>
                        <span id="ad__title">
                            <?=$ads[$i]['title']?>
                        </span>
                    </div>
                    <div class="ads__ad__info__date">
                        <?=$ads[$i]['date']?>
                    </div>
                </div>
                <object class="ads__ad__add__favorite">
                    <a><img class="ads__ad__add__favorite__img" src="images/favorites_icon.svg" alt=""></a>
                </object>
            </div>

            <?php } ?>

        </div><!-- End of ads-container-->



    </div>



    <script src="scripts/ads.js"></script>

</body>
</html>
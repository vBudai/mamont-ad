<header>

        <div class="logo">
            <a href="<?=BASE_URL?>">
                М
            </a>
        </div>


    <div class="categories">
        <span>
            Категории
        </span>
        <ul class="categories__list">
            <a href="../../ads/Transport"><li>Транспорт</li></a>
            <a href="../../ads/Nedvijimost'"><li>Недвижимость</li></a>
            <a href="../../ads/Yslygi"><li>Услуги</li></a>
            <a href="../../ads/Lichni'e_vesh'i"><li>Личные вещи</li></a>
            <a href="../../ads/Rabota"><li>Работа</li></a>
            <a href="../../ads/Hobbi_i_otdi'h"><li>Хобби и отдых</li></a>
            <a href="../../ads/Jivotni'e"><li>Животные</li></a>
            <a href="../../ads/A'lektronika"><li>Электроника</li></a>
        </ul>
    </div>

    <form class="search" method="post" action="../../ads/search">

        <input type="text" placeholder="Найти объявление..." name="title">
        <button type="submit" href=""><img src="../../images/loupe_icon.svg"></button>

        <button type="submit" class="search__btn">
            Поиск
        </button>
    </form>


        <div class="create-ad">
            <a href="../../create_ad">
            Разместить объявление
            </a>
        </div>



    <div class="favorites">
        <a href="../../profile/favorites">
            Избранное
        </a>
    </div>




    <!-- Если пользователь не вошёл -->
    <?php if(!isset($_SESSION['id_user'])): ?>
    <div class="login">
        <a href="/auth">
            Войти
        </a>
    </div>
    <?php else :?> <!-- Если пользователь вошёл -->
        <div class="menu">
            <div class="menu__user">
                <a href="../../profile"><img class="menu__user__img after1440" src="../../images/no_user_avatar.svg"></a>
                <img class="menu__user__img before1440" src="../../images/no_user_avatar.svg">
                <div class="menu__user__arrow">
                    <span class="f"></span>
                    <span class="s"></span>
                </div>
            </div>

            <div class="menu__bg"></div>

            <nav class="menu__list">
                <ul>
                    <a href="../../profile"><li id="profile">Профиль</li></a>
                    <a href="../../profile/my_ads"><li id="my-ads">Мои объявления</li></a>
                    <a href="../../profile/watched"><li id="watched-ads">Просмотренные</li></a>
                    <a href="../../profile/favorites"><li class="menu__list__favorites">Избранные</li></a>
                    <a href="../../profile/archive"><li id="archive" class="archive">Архив</li></a>


                    <a href="../../create_ad"><li class="menu__list__create-ad">Разместить объявления</li></a>


                    <a href="../../profile/settings"><li id="settings" class="menu__list__settings">Настройки</li></a>


                    <a href="../../profile/exit"><li class="menu__list__exit">Выйти</li></a>
                </ul>
            </nav>

        </div>
    <?php endif ?>



</header>

<script src="../../scripts/header.js"></script>
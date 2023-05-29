<header>
    <a href="http://mamont-ad/">
        <div class="logo">
            М
        </div>
    </a>

    <div class="categories">
        Категории
    </div>
    <div class="search">
        <input type="text" placeholder="Найти объявление...">
        <a href=""><img src="images/loupe_icon.svg"></a>
        <a href="">
            <div class="search__btn">
                Поиск
            </div>
        </a>
    </div>

    <a href="/create_ad">
        <div class="create-ad">
            Разместить объявление
        </div>
    </a>

    <a href="/profile/favorites">
        <div class="favorites">
            Избранное
        </div>
    </a>



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
                <img class="menu__user__img" src="images/no_user_avatar.svg">
                <div class="menu__user__arrow">
                    <span class="f"></span>
                    <span class="s"></span>
                </div>
            </div>

            <div class="menu__bg"></div>

            <nav class="menu__list">
                <ul>
                    <a href="../profile"><li id="profile">Профиль</li></a>
                    <a href="../profile/my_ads"><li id="my-ads">Мои объявления</li></a>
                    <a href="../profile/watched"><li id="watched-ads">Просмотренные</li></a>
                    <a><li id="messages">Сообщения</li></a>
                    <a href="../profile/favorites"><li class="menu__list__favorites">Избранные</li></a>
                    <a href="../profile/archive"><li id="archive" class="archive">Архив</li></a>


                    <a href="../create_ad"><li class="menu__list__create-ad">Разместить объявления</li></a>


                    <a href="../profile/settings"><li id="settings" class="menu__list__settings">Настройки</li></a>


                    <a href="..//profile/exit"><li class="menu__list__exit">Выйти</li></a>
                </ul>
            </nav>

        </div>
    <?php endif ?>



</header>

<script src="scripts/header.js"></script>
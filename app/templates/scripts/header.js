// Изменение лого
const mediaChecker = window.matchMedia('(min-width: 744px)');

function changeLogoText(e){
    const logo = document.querySelector('.logo');
    if(e.matches)
        logo.innerHTML = "МАМОНТ";
    else
        logo.innerHTML = "М";
}

mediaChecker.addListener(changeLogoText);
changeLogoText(mediaChecker);


const header_menu = document.querySelector(".menu__user"); // Меню
const menu_arrow = document.querySelector(".menu__user__arrow"); // Стрелочка меню

const menu_bg = document.querySelector(".menu__bg"); // Задний фон меню
const menu_list = document.querySelector(".menu__list"); // Навигация меню

function menuController(){
    menu_arrow.classList.toggle('arrow__active');
    menu_bg.classList.toggle('menu__bg-active');
    menu_list.classList.toggle('menu__list-active');
}

if(header_menu)
    header_menu.addEventListener('click', menuController);




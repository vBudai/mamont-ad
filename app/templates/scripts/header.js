// Изменение лого
const mediaChecker = window.matchMedia('(min-width: 744px)');

function changeLogoText(e){
    const logo = document.querySelector('.logo a');
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


// Открытие списка категорий

const categories = document.querySelector(".categories");
const categories_list = document.querySelector(".categories__list");

categories.addEventListener("click", function (){

    categories_list.classList.toggle("categories__list__active");
    categories.classList.toggle("categories__active")

})
document.addEventListener("click", function(event) {
    if (!categories.contains(event.target)) {
        categories_list.classList.remove("categories__list__active");
        categories.classList.remove("categories__active")
    }
});
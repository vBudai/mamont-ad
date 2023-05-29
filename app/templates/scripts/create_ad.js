// Список городов
const cityInput = document.querySelector("#input_city")
const cityList = document.querySelectorAll(".createAd__city ul li");
const cityUl = document.querySelector(".createAd__city ul");



for(let i = 0; i < cityList.length; i++){
    cityList[i].addEventListener("click", function () { insertCityInField(cityList[i].textContent) })
}

cityInput.addEventListener("focus", showCitiesList);

function insertCityInField(name){
    cityInput.value = name;
    showCitiesList();
}

function showCitiesList(){
    cityUl.classList.toggle('list-active')
    cityInput.classList.toggle('input-active');
}


// Выбор категории
const categoriesUl = document.querySelector("#main_category");
const categoriesLi = document.querySelectorAll("#main_category li");
const categoriesInput = document.querySelector(".createAd__category input")
const categoriesBtn = document.querySelector(".category__first");


for(let i = 0; i < categoriesLi.length; i++){
    categoriesLi[i].addEventListener("click", function () {insertCategoryInField(categoriesLi[i].textContent)})
}

categoriesBtn.addEventListener("click", showCategoriesList);

function insertCategoryInField(name){
    categoriesInput.value = name;
    categoriesBtn.innerHTML = name;
    showCategoriesList();
}


function showCategoriesList(){
    categoriesUl.classList.toggle("categories__active");
    categoriesBtn.classList.toggle("category__first__active");
}
class FilterAds{
    constructor() {
        let sorting_type;
        let minPrice;
        let maxPrice;
        let date;
    }
}

class Ad{
    constructor() {
        let mainImage;
        let minPrice;
        let maxPrice;
        let date;
    }
}

const adsList = [];

// Города (для дальнейшей фильтрации)
const cities = document.querySelectorAll(".filter__main-params__city__list ul li");
const citiesList = [];

// Считывание городов из списка
function getCities(){
    cities.forEach(city => citiesList.push(city.innerText))
}

getCities();

// Вывод городов
const citiesDiv = document.querySelector(".filter__main-params__city__list"); // Список городов
const citiesInput = document.querySelector(".filter__main-params__city input"); // Поле, куда вводится город

function insertCityInField(name){
    citiesInput.value = name;
    closeCitiesList();
}

for(let i = 0; i < cities.length; i++){
    cities[i].addEventListener("click", function () { insertCityInField(cities[i].textContent) })
}

citiesInput.addEventListener("focus", openCitiesList);

// Открытие списка городов
function openCitiesList(){
    citiesDiv.classList.add('active')
    citiesInput.classList.add('active');
}

// Убрать список городов
function closeCitiesList(){
    citiesDiv.classList.remove('active')
    citiesInput.classList.remove('active');
}

// Закрытие списка городов при нажатии вне этого списка
window.addEventListener('click', e => {
    const target = e.target;
    if(!target.closest('.filter__main-params__city__list') && !target.closest(".filter__main-params__city input"))
        closeCitiesList();
})


// Объявления
const ads = document.querySelectorAll(".ads__ad");
const firstAd = document.querySelector(".ads__ad");

// Если объявление одно, добавляются закругления краёв
if(firstAd && ads.length === 1)
    firstAd.style.borderRadius = "12px 12px 12px 12px";



// Регулировака длины названия объявления
const adsTitles = document.querySelectorAll("#ad__title");
for (let i = 0; i < adsTitles.length; i++){
    let title = adsTitles[i].innerText;
    if(title.length >= 38){
        title = title.slice(0, 35) + "...";
        adsTitles[i].innerText = title;
    }
}

// Изменение цены на объявлениях
const priceField = document.querySelectorAll(".main-info__price");
let prices = [];

priceField.forEach(field => prices.push(field.textContent))

for(let i = 0; i < prices.length; i++){
    let _min = "";
    let _max = "";

    let isMin = true;

    for(let j = 0; j < prices[i].length; j++){
        if(prices[i][j] === '-'){
            isMin = false;
            continue
        }
        if(!isNaN(parseInt(prices[i][j])))
            if(isMin)
                _min += prices[i][j];
            else
                _max += prices[i][j];
    }

    if(_min === _max){
        prices[i] = _min + " ₽";
    }
    else if(_min !== "" && _max === ""){
        prices[i] = "от " + _min + " ₽";
    }
    else if(_min === "" && _max !== ""){
        prices[i] = "до " + _min + " ₽";
    }
    else{
        prices[i] = _min + " ₽ - " + _max + " ₽";
    }
}

for(let i = 0; i < priceField.length; i++){
    priceField[i].textContent = prices[i];
}
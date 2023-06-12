// Работа фильтров
const PAGE_TITLE = document.querySelector(".ads__title").outerHTML;

class FilterAds{

    sorting_type;
    sorting;
    minPrice;
    maxPrice;
    cityInput;

    defaultAdsList;
    currentAdsList;

    adsField;


    constructor(adsObj, sortingField, min_priceField, max_priceField, cityField, adsField) {
        this.sorting = "default";
        this.cityInput = cityField;

        this.sorting_type = sortingField;
        this.minPrice = min_priceField;
        this.maxPrice = max_priceField;

        this.defaultAdsList = adsObj;
        this.currentAdsList = [...this.defaultAdsList];
        this.adsField = adsField;

        // Обработка изменения поля сортировки
        for(let i = 0; i < this.sorting_type.length; ++i)
            this.sorting_type[i].addEventListener("change", (event) => {

                /*this.currentAdsList = this.Sort(event.target.value, this.currentAdsList);
                this.OutPutAds( this.currentAdsList )*/
                this.sorting = event.target.value;
                this.Filter();

            });

        // Обработка изменения города
        this.cityInput.addEventListener('input', this.Filter.bind(this));
        this.minPrice.addEventListener('input', this.Filter.bind(this));
        this.maxPrice.addEventListener('input', this.Filter.bind(this));

    }

    Filter(){

        const cityName = this.cityInput.value;
        const minPrice = this.minPrice.value;
        const maxPrice = this.maxPrice.value;

        let newAdsList = [];



        if(cityName === "" && minPrice === "" && maxPrice === "")
            newAdsList = this.defaultAdsList;
        else{
            newAdsList = this.currentAdsList;
            if(cityName !== "")
                newAdsList = this.FilterByCity(cityName, newAdsList);
            if(minPrice !== "")
                newAdsList = this.FilterByMinPrice(minPrice, newAdsList);
            if(maxPrice !== "")
                newAdsList = this.FilterByMaxPrice(maxPrice, newAdsList);
        }

        newAdsList = this.Sort(this.sorting, newAdsList)

        this.OutPutAds(newAdsList);
    }

    FilterByCity(name, arr){
        const newArr = [];

        for(let i = 0; i < arr.length; ++i)
            if(name === arr[i].city)
                newArr.push(arr[i])

        return newArr;
    }

    FilterByMinPrice(minPrice, arr){
        const newArr = [];

        for(let i = 0; i < arr.length; ++i){
            /*console.log(arr[i].minPrice + " >= " + minPrice)
            console.log(arr[i].minPrice >= minPrice)*/

            if(parseInt(arr[i].minPrice) >= parseInt(minPrice) || arr[i].minPrice === ""){
                newArr.push(arr[i])
            }
        }



        return newArr;
    }

    FilterByMaxPrice(maxPrice, arr){
        const newArr = [];

        for(let i = 0; i < arr.length; ++i)
            if(parseInt(arr[i].maxPrice) <= parseInt(maxPrice) || (arr[i].maxPrice === "" && parseInt(arr[i].minPrice) <= parseInt(maxPrice)) )
                newArr.push(arr[i])

        return newArr;
    }

    // Быстрая сортировка
    Sort(type, arr){

        if(type === "default")
            return arr;

        if (arr.length <= 1)
            return arr;

        const pivot = arr[Math.floor(arr.length/2)];
        const left = []
        const right = []

        for(let i = 0; i < arr.length; ++i)
            if(this.compare(type, arr[i], pivot) && arr[i] !== pivot)
                left.push(arr[i])
            else if (arr[i] !== pivot)
                right.push(arr[i])

        return [...this.Sort(type, left), pivot, ...this.Sort(type, right)]
    }

    OutPutAds(adsList){
        this.adsField.innerHTML = "";
        this.adsField.innerHTML += PAGE_TITLE;

        for(let i = 0; i < adsList.length; ++i)
            this.adsField.innerHTML += adsList[i].field;
    }

    compare(type, f, s){

        switch (type){
            case "cheaper":
                if( parseInt(f.minPrice) < parseInt(s.minPrice) )
                    return true;
                break;
            case "expensive":
                if( parseInt(f.minPrice) > parseInt(s.minPrice) || parseInt(f.maxPrice) > parseInt(s.maxPrice))
                    return true;
                break;
            case "date":
                if((new Date(f.date)) > (new Date(s.date)))
                    return true;
                break;
            default:
                return false;
        }

        return false;
    }
}

class Ad{
    field;
    minPrice;
    maxPrice;
    date;
    city;

    constructor(_field, _min, _max, _date, _city) {
        this.minPrice = _min;
        this.maxPrice = _max;
        this.date = this.ParseDate(_date);
        this.city = _city;
        this.field = _field;
    }

    ParseDate(_date){
        let newDate = "";

        for(const sym of _date)
            if(sym === '-' || (sym.charCodeAt(0) >= 48 && sym.charCodeAt(0) <= 57))
                newDate += sym;

        return newDate;
    }

}












const adsList = [];

// Города (для дальнейшей фильтрации)
const cities = document.querySelectorAll(".filter__main-params__city__list ul li");

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
    const inputEvent = new Event('input');
    citiesInput.dispatchEvent(inputEvent)
    citiesDiv.classList.remove('active')
    citiesInput.classList.remove('active');
}


// Закрытие списка городов при нажатии вне этого списка
window.addEventListener('click', e => {
    const target = e.target;
    if(!target.closest('.filter__main-params__city__list') && !target.closest(".filter__main-params__city input"))
        closeCitiesList();
})


// Работа с объявлениями

// Поля объявлений, получающие информацию из PHP
const ads = document.querySelectorAll(".ads__ad");
const adsAImages = document.querySelectorAll(".ads__ad a")
const adsImages = document.querySelectorAll(".ads__ad__mainImage")
const adsTitles = document.querySelectorAll("#ad__title");
const priceField = document.querySelectorAll(".main-info__price");
const dataField = document.querySelectorAll(".ads__ad__info__date");
const cityField = document.querySelectorAll("#ad_city");


// Массив объектов
let adsObj = [];


const firstAd = document.querySelector(".ads__ad");

// Если объявление одно, добавляются закругления краёв
if(firstAd && ads.length === 1)
    firstAd.style.borderRadius = "12px 12px 12px 12px";

let newPrice;
// Настройка вида объявлений
for(let i = 0; i < ads.length; ++i){

    // Сокращение названия объявления
    adsTitles[i].innerText = changeTitle(adsTitles[i].innerText)

    // Настройка цены
    newPrice = changePrice(priceField[i].innerText)
    priceField[i].innerText = newPrice['price']

    adsObj.push(
        new Ad(
            ads[i].outerHTML,
            newPrice['min'],
            newPrice['max'],
            dataField[i].textContent,
            cityField[i].textContent
        )
    )

}

function changeTitle(title){
    return title.length >= 38 ? title.slice(0, 35) + "..." : title;
}

function changePrice(price){
    let _min = "";
    let _max = "";

    let isMin = true;

    for(let i = 0; i < price.length; i++){
        if(price[i] === '-'){
            isMin = false;
            continue
        }
        if(!isNaN(parseInt(price[i])))
            if(isMin)
                _min += price[i];
            else
                _max += price[i];
    }

    if(_min === _max)
        price = _min + " ₽";
    else if(_min !== "" && _max === "")
        price = "от " + _min + " ₽";
    else if(_min === "" && _max !== "")
        price = "до " + _min + " ₽";
    else
        price = _min + " ₽ - " + _max + " ₽";

    return {
        price: price,
        min: _min,
        max: _max
    };
}


const filters = new FilterAds(adsObj,
                                       document.querySelectorAll('[name="sorting-type"]'),
                                       document.querySelector("#filter_min-price"),
                                       document.querySelector("#filter_max-price"),
                                       citiesInput,
                                       document.querySelector(".ads"));







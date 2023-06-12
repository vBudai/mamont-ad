const settingsBtn = document.querySelectorAll(".ads__ad__setting__img")
const settingsMenu = document.querySelectorAll(".ad__settings")

for(let i = 0; i < settingsBtn.length; i++){
    settingsBtn[i].addEventListener("click", function (){
        const menu = settingsMenu[i];

        for(let j = 0; j < settingsMenu.length; j++){
            if(settingsMenu[j] !== menu)
                settingsMenu[j].classList.remove("ad__settings__active");
        }


        menu.classList.toggle("ad__settings__active");
    })
}

// Поля объявлений, получающие информацию из PHP
const ads = document.querySelectorAll(".ads__ad");
const adsTitles = document.querySelectorAll("#ad__title");
const priceField = document.querySelectorAll(".main-info__price");

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
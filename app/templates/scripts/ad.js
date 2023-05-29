// Переключение фото
const sliderControllers = document.querySelectorAll(".images__slider label")
const sliderImages = document.querySelectorAll(".images__container img")

for(let i = 0; i < sliderControllers.length; i++){
    sliderControllers[i].addEventListener('click', function () {
        sliderImages.forEach(item => item.classList.remove("active"));
        sliderControllers.forEach(item => item.classList.remove("active"));
        sliderImages[i].classList.add("active");
        sliderControllers[i].classList.add("active");
    });
}

sliderControllers[0].click();

// Вывод номера пользователя
const getNumberBtn = document.querySelector(".ad__get-creator-info")
const numberForm = document.querySelector(".number")
const numberFormCloseBtn = document.querySelector(".number__close")

getNumberBtn.addEventListener("click", function () {
    numberForm.classList.add("number-active");
})

numberFormCloseBtn.addEventListener("click", function () {
    numberForm.classList.remove("number-active");
})

// Корректировка цены
const priceField = document.querySelector(".main-info__price");
const price = priceField.textContent;

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

if(_min === _max){
    priceField.textContent = _min + " ₽";
}
else if(_min !== "" && _max === ""){
    priceField.textContent = "от " + _min + " ₽";
}
else if(_min === "" && _max !== ""){
    priceField.textContent = "до " + _min + " ₽";
}
else{
    priceField.textContent = _min + " ₽ - " + _max + " ₽";
}
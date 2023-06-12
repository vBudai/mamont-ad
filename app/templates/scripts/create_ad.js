class CreateAdFormChecker{

    form

    categoryField;
    categoryErrField;

    titleField;
    titleErrField;

    descField;
    descErrField;

    minPriceField;
    maxPriceField;
    priceErrField

    cityField;
    cityErrField;


    constructor(form, categoryField, categoryErrField, titleField, titleErrField, descField, descErrField, minPriceField, maxPriceField, priceErrField, cityField, cityErrField)
    {
        this.form = form;

        this.categoryField = categoryField;
        this.categoryErrField = categoryErrField;

        this.titleField = titleField;
        this.titleErrField = titleErrField;

        this.descField = descField;
        this.descErrField = descErrField;

        this.minPriceField = minPriceField;
        this.maxPriceField = maxPriceField;
        this.priceErrField = priceErrField;

        this.cityField = cityField;
        this.cityErrField = cityErrField;


        form.addEventListener('submit', this.SubmitForm.bind(this));

    }


    SubmitForm(event)
    {
        event.preventDefault();

        if(this.CheckForm())
            this.form.submit();
    }

    CheckForm()
    {
        let result = true;

        // Проверка выбора категории
        if(this.categoryField.value === ""){
            this.categoryErrField.textContent = "Выберите категорию!";
            result = false;
        }
        else
            this.categoryErrField.textContent = "";

        // Проверка названия объявления
        if(this.titleField.value.trim() === ""){
            this.titleErrField.textContent = "Введите название!";
            result = false;
        }
        else{
            this.titleErrField.textContent = "";
            this.titleField.value = this.titleField.value.trim();
        }


        // Проверка описания
        if(this.descField.value.trim() === ""){
            this.descErrField.textContent = "Добавьте описание";
            result = false;
        }
        else if(this.descField.value.trim().length <= 30){
            this.descErrField.textContent = "Длина описания должна быть не менне 30 символов";
            result = false;
        }
        else
            this.descErrField.textContent = "";


        // Проверка полей с ценой
        const minPrice = this.minPriceField.value.trim()
        const maxPrice = this.maxPriceField.value.trim()

        if(minPrice === "" && maxPrice === ""){
            this.priceErrField.textContent = "Введите цену";
            result = false;
        }
        else if(this.isNumber(minPrice) && this.isNumber(maxPrice)){
            this.priceErrField.textContent = "Цена может состоять только из чисел";
            result = false;
        }
        else if(minPrice.length >= 11 || maxPrice.length >= 11){
            this.priceErrField.textContent = "Размер цены может быть не более 10 символов";
            result = false;
        }
        else if(parseInt(minPrice) > parseInt(maxPrice)){
            this.priceErrField.textContent = "Мин. цена не может быть больше макс. цены";
            result = false;
        }
        else{
            this.minPriceField.value = minPrice.replace(/ /g, "");
            this.maxPriceField.value = maxPrice.replace(/ /g, "");
            this.priceErrField.textContent = "";
        }

        // Проверка города
        if(this.cityField.value === "Выберите город из списка"){
            this.cityErrField.textContent = "Выберите город из списка!"
            result = false;
        }
        else
            this.cityErrField.textContent = ""


        return result;
    }

    isNumber(number)
    {
        return number === "" || isNaN(parseInt(number));
    }

}




const formChecker = new CreateAdFormChecker(
    document.querySelector(".createAd"), // form

    document.querySelector(".createAd__category input"), // categoryField
    document.querySelector(".createAd__category .err"), // categoryErrField

    document.querySelector(".createAd__title input"), // titleField
    document.querySelector(".createAd__title .err"), // titleErrField

    document.querySelector(".createAd__desc textarea"), // descField
    document.querySelector(".createAd__desc .err"), // descErrField

    document.querySelector(".createAd__price .min"), // minPriceField
    document.querySelector(".createAd__price .max"), // maxPriceField
    document.querySelector(".createAd__price .err"), // priceField

    document.querySelector(".createAd__city input"), // cityField
    document.querySelector(".createAd__city .err"), // cityErrField
)










// Список городов
const cityInput = document.querySelector("#input_city")
const cityList = document.querySelectorAll(".createAd__city ul li");
const cityUl = document.querySelector(".createAd__city ul");



for(let i = 0; i < cityList.length; i++){
    cityList[i].addEventListener("click", function () { insertCityInField(cityList[i].textContent) })
}

cityInput.addEventListener("click", openCitiesList);

function insertCityInField(name){
    cityInput.value = name;
    closeCitiesList();
}

function openCitiesList(){
    cityUl.classList.toggle('list-active')
    cityInput.classList.toggle('input-active');
}

function closeCitiesList(){
    cityUl.classList.remove('list-active')
    cityInput.classList.remove('input-active');
}


// Выбор категории
const categoriesUl = document.querySelector("#main_category");
const categoriesLi = document.querySelectorAll("#main_category li");
const categoriesInput = document.querySelector(".createAd__category input")
const categoriesBtn = document.querySelector(".category__first");


for(let i = 0; i < categoriesLi.length; i++){
    categoriesLi[i].addEventListener("click", function () {insertCategoryInField(categoriesLi[i].textContent)})
}

categoriesBtn.addEventListener("click", openCategoriesList);

function insertCategoryInField(name){
    categoriesInput.value = name;
    categoriesBtn.innerHTML = name;
    closeCategoriesList();
}


function openCategoriesList(){
    categoriesUl.classList.toggle("categories__active");
    categoriesBtn.classList.toggle("category__first__active");
}

function closeCategoriesList(){
    categoriesUl.classList.remove("categories__active");
    categoriesBtn.classList.remove("category__first__active");
}

document.addEventListener('click', function(event) {
    let isClickInside = categoriesUl.contains(event.target) || categoriesBtn.contains(event.target);
    if (!isClickInside)
        closeCategoriesList();

    isClickInside = cityUl.contains(event.target) || cityInput.contains(event.target);
    if(!isClickInside)
        closeCitiesList();
});
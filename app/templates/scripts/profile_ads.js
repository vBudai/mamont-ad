const settingsBtn = document.querySelectorAll(".ads__ad__setting__img")
const settingsMenu = document.querySelectorAll(".ad__settings")

console.log(settingsMenu)

for(let i = 0; i < settingsBtn.length; i++){
    settingsBtn[i].addEventListener("click", function (){
        const menu = settingsMenu[i];

        for(let j = 0; j < settingsMenu.length; j++)
            settingsMenu[j].classList.remove("ad__settings__active");

        menu.classList.add("ad__settings__active");
    })
}
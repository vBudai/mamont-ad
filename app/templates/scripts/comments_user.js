let list = document.querySelector(".comment__settings ul")
let openListBtn = document.querySelector(".comment__settings img")

console.log(list)
console.log(openListBtn)


openListBtn.addEventListener("click", function (){
    list.classList.toggle("display-block");
})
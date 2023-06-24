class CommentUserForm
{

    form
    commentText;
    stars;
    raiting;
    errorField;

    constructor(formField, commentTextField, starsField, raiting, errorField)
    {
        this.form = formField;
        this.commentText = commentTextField;
        this.stars = starsField;
        this.raiting = raiting;
        this.errorField = errorField;

        console.log(this.raiting)

        this.form.addEventListener('submit', this.SubmitForm.bind(this));

        for(let i = 0; i < this.stars.length; ++i){
            this.stars[i].addEventListener("click", () => this.RaitingChanging(i))
            console.log(this.stars[i].src)
            if(this.stars[i].src === "http://mamont-ad/images/star_yellow.svg")
                this.raiting.value = i + 1;
        }
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

        if(this.raiting.value === "") {
            this.errorField.textContent = "Вы не поставили оценку!"
            result = false;
        }
        else if(this.commentText.value.length > 250 ) {
            this.errorField.textContent = "Комментарий слишком длинный, сократите его до 250 символов!";
            result = false;
        }
        else
            this.errorField.textContent = ""


        return result;
    }


    RaitingChanging(num)
    {

        for(let i = 0; i < this.stars.length; ++i){
            if(i <= num){
                this.stars[i].setAttribute("src", "../../images/star_yellow.svg")
            }
            else{
                this.stars[i].setAttribute("src", "../../images/star_empty.svg")
            }
        }


        this.raiting.value = num+1;
    }


}



let form = new CommentUserForm(
    document.querySelector("#comment_form"),
    document.querySelector("#comment_form textarea"),
    document.querySelectorAll(".form__star img"),
    document.querySelector("#raiting"),
    document.querySelector("#comment_form .comment_form_error")
)
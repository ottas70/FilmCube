var writeBtn = document.querySelector("#write-review-btn")
var reviewDialog = document.querySelector("#review-dialog")
var exitReviewBtn = document.querySelector("#reviewExit")

var reviewForm = document.querySelector("#review-form")

//set background color of numeric review
// <0-2> black
// (2-7) red
// <7-10> green
window.onload = function (e) {
    var number = document.querySelector(".numberReview")

    if(number.innerHTML <= 2){
        number.style.background = "black"
    }
    if(number.innerHTML > 2 && number.innerHTML < 7){
        number.style.background = "red"
    }
}

writeBtn.addEventListener("click", function (e) {
    reviewDialog.style.display = "block"
})

reviewForm.addEventListener("submit", function (e) {
    validateReview(e)
})

exitReviewBtn.addEventListener("click",function () {
    reviewDialog.style.display = "none";
})

window.addEventListener("click", function (e) {
    if (e.target == reviewDialog) {
        reviewDialog.style.display = "none"
    }

})

function validateReview(e) {
    validateTitle(e)
    validateBody(e)
}

function isEmpty(e,input){
    if(input.value == ""){
        input.classList.add("error")
        e.preventDefault()
    }
}

function validateTitle(e) {
    var title = document.querySelector("#title")

    title.classList.remove("error")

    isEmpty(e,title)

    if (title.value.length < 4 && title.value != "") {
        title.classList.add("error")
        title.placeholder = "Minimum is 5 characters"
        title.value = ""
        e.preventDefault()
    }

    if (title.value.length >= 30 && title.value != "") {
        title.classList.add("error")
        title.placeholder = "Maximum is 30 characters"
        title.value = ""
        e.preventDefault()
    }
}

function validateBody(e) {
    var body = document.querySelector("#body")

    body.classList.remove("error")

    isEmpty(e,body)

    if (body.value.length <= 80 && body.value != "") {
        body.classList.add("error")
        e.preventDefault()
    }
}

/*********************************************************************
 REVIEW EDIT
 *********************************************************************/

document.execCommand("DefaultParagraphSeparator", false, "div");
var reviews = document.querySelectorAll(".review")

reviews.forEach(function (item) {
    var form = item.getElementsByTagName("form")[0]
    if(typeof form != "undefined") {
        item.getElementsByTagName("img")[0].addEventListener("click", function () {
            makeChanges(item)
        })
    }
})

function makeChanges(item){
    var form = item.getElementsByTagName("form")[0]
    var img = item.getElementsByTagName("img")[0]
    var title = item.getElementsByTagName("h4")[0]
    var text = item.getElementsByClassName("text")[0]
    var number = item.getElementsByClassName("number")[0]
    var hiddenTitle = item.getElementsByTagName("input")[1]
    var hiddenNumber = item.getElementsByTagName("input")[2]
    var hiddenText = item.getElementsByTagName("input")[3]
    if(img.getAttribute("src") == "Images/pencil.png"){
        img.setAttribute("src", "Images/checkmark.png")
        text.contentEditable = true
        text.classList.add("edit")
        number.contentEditable = true
        number.classList.add("edit")
        title.contentEditable = true
        title.classList.add("edit")
        return
    }
    if(img.getAttribute("src") == "Images/checkmark.png"){
        img.setAttribute("src", "Images/pencil.png")
        text.contentEditable = false
        text.classList.remove("edit")
        number.contentEditable = false
        number.classList.remove("edit")
        title.contentEditable = false
        title.classList.remove("edit")
        hiddenNumber.value = number.innerHTML
        hiddenText.value = text.innerHTML
        hiddenTitle.value = title.innerHTML
        form.submit()
        return
    }
}

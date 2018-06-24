var prevPage = document.querySelector("#pagePrev")
var nextPage = document.querySelector("#pageNext")
var pageInput = document.querySelector("#pageInput")
var form = document.querySelector(".search-container form")


window.onload = function () {
    var currentPage = parseInt(pageInput.value)
    if(currentPage <= 1){
        prevPage.classList.add("unavailable")
    }
    if(getFilmCount() < 12){
        nextPage.classList.add("unavailable")
    }
}

prevPage.addEventListener("click", function () {
    if(!isAvailable(prevPage)) return
    var currentPage = parseInt(pageInput.value);
    if(currentPage > 1){
        pageInput.value = currentPage-1
    }else{
        return
    }
    form.submit();
})

nextPage.addEventListener("click", function () {
    if(!isAvailable(nextPage)) return
    var currentPage = parseInt(pageInput.value);
    pageInput.value = currentPage+1
    form.submit()
})

function isAvailable(input) {
    if(input.classList.contains("unavailable")){
        return false
    }
    return true
}

function getFilmCount() {
    var filmBox = document.querySelector(".film-box")
    return filmBox.childElementCount
}
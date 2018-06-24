var poster = document.querySelector(".poster")
var imgInput = document.querySelector(".img-input")
var autocompleteBtn = document.querySelector("#autocomplete")

var posterSelected = false
var apikey = "acb924e668ef9bf7d938c8d0cc003b15"

imgInput.addEventListener("change", function () {
    if (imgInput.files && imgInput.files[0]) {
        var reader = new FileReader()

        reader.onload = function (e) {
            poster.src = e.target.result
            posterSelected = true
            document.querySelector("#webImage").value = "False";
        }

        reader.readAsDataURL(imgInput.files[0])
    }
})


var movieForm = document.querySelector(".movie-form")

movieForm.addEventListener("submit", function (e) {
    validateMovie(e)
})

function validateMovie(e) {
    validatePoster(e)
    validateTitle(e)
    validateYear(e)
    validateLength(e)
    validateDirector(e)
    validateActors(e)
    validateGenres(e)
    validatePlot(e)
}

function isEmpty(e,input){
    if(input.value == ""){
        input.classList.add("error")
        input.placeholder = "This field is required"
        e.preventDefault()
        return false
    }
    return true
}

function validatePoster(e) {
    var poster = document.querySelector("#poster")

    poster.classList.remove("error")

    if (!posterSelected) {
        poster.classList.add("error")
        e.preventDefault()
    }
}

function validateTitle(e) {
    var title = document.querySelector("#title")

    title.classList.remove("error")

    return isEmpty(e,title)
}

function validateYear(e) {
    var year = document.querySelector("#year")

    year.classList.remove("error")

    var empty = isEmpty(e,year)

    var currentYear = new Date().getFullYear();
    if (year.value != "" && (year.value.length != 4 || isNaN(year.value) || year.value < 1900 || year.value > currentYear)) {
        year.classList.add("error")
        year.placeholder = "Year is not proper"
        year.value = ""
        e.preventDefault()
        return false
    }
    return empty
}

function validateLength(e) {
    var length = document.querySelector("#length")

    length.classList.remove("error")

    isEmpty(e,length)

    if (length.value != "" && (length.value < 10 || isNaN(length.value) || length.value > 1000)) {
        length.classList.add("error")
        length.placeholder = "Length is not proper"
        length.value = ""
        e.preventDefault()
    }

}

function validateDirector(e) {
    var director = document.querySelector("#director")

    director.classList.remove("error")

    isEmpty(e,director)
}

function validateActors(e) {
    var actors = document.querySelector("#actors")

    actors.classList.remove("error")

    isEmpty(e,actors)
}

function validateGenres(e) {
    var checkboxes = document.querySelectorAll("input[type='checkbox']")
    var container = document.querySelector(".checkbox-container")

    container.classList.remove("error")

    var counter = 0
    for(var i = 0; i < checkboxes.length; i++) {
        if(checkboxes[i].type == "checkbox") {
            if(checkboxes[i].checked == true){
                counter++
            }
        }
    }

    if(counter < 1 || counter > 4){
        container.classList.add("error")
        e.preventDefault();
    }
}

function validatePlot(e) {
    var plot = document.querySelector("#plot")

    plot.classList.remove("error")

    isEmpty(e,plot)

    if (plot.value.length < 300 && plot.value != "") {
        plot.classList.add("error")
        e.preventDefault()
    }
}

/*********************************************************************
 AUTOCOMPLETE
 *********************************************************************/

autocompleteBtn.addEventListener("click", function (e) {
    if(validateTitle(e)) {
        loadMovieInfo()
    }
})

function loadMovieInfo(){
    var xhttp = new XMLHttpRequest();
    xhttp.onload = function(){
        if(this.status == 200){
            var jsonObj = JSON.parse(xhttp.responseText)
            if(jsonObj.results.length != 0) {
                var result = jsonObj.results[0]
                var movie_id = result.id
                loadDetails(movie_id)
                loadPeople(movie_id)
            }
        }
    }
    var url = "https://api.themoviedb.org/3/search/movie?year=" +
        document.querySelector("#year").value +
        "&include_adult=false&page=1&query=" +
        encodeURI(document.querySelector("#title").value) +
        "&language=en-US&api_key=" +
        apikey
    xhttp.open("GET", url);
    xhttp.send();
}

function loadDetails(id) {
    var posterUrl =  "http://image.tmdb.org/t/p/w500/"
    var xhttp = new XMLHttpRequest();
    xhttp.onload = function(){
        if(this.status == 200){
            var jsonObj = JSON.parse(xhttp.responseText)
            loadGenres(jsonObj.genres)
            document.querySelector("#title").value = jsonObj.title
            var releaseYear = jsonObj.release_date.substring(0,4)
            document.querySelector("#year").value = releaseYear
            document.querySelector("#length").value = jsonObj.runtime
            document.querySelector("#plot").value = jsonObj.overview;
            posterUrl += jsonObj.poster_path
            document.querySelector("#poster").src = posterUrl
            posterSelected = true
            document.querySelector("#webImage").value = posterUrl;

        }
    }
    var url = "https://api.themoviedb.org/3/movie/" +
        id +
        "?api_key=" +
        apikey +
        "&language=en-US"
    xhttp.open("GET", url);
    xhttp.send();
}

function loadPeople(id){
    var xhttp = new XMLHttpRequest();
    xhttp.onload = function(){
        if(this.status == 200){
            var jsonObj = JSON.parse(xhttp.responseText)
            loadCast(jsonObj.cast)
            loadDirector(jsonObj.crew)
        }
    }
    var url = "https://api.themoviedb.org/3/movie/" +
        id +
        "/credits?api_key=" +
        apikey
    xhttp.open("GET", url);
    xhttp.send();
}

function loadCast(jsonObj){
    var cast = ""
    var length = 10;
    if(jsonObj.length < 20){
        length = jsonObj.length
    }
    for(var i = 0; i < length; i++){
        cast += jsonObj[i].name + ", "
    }
    document.querySelector("#actors").value = cast
}

function loadDirector(jsonObj){
    for(var i = 0; i < jsonObj.length; i++){
        if(jsonObj[i].job == "Director"){
            document.querySelector("#director").value = jsonObj[i].name;
            break;
        }
    }

}

function loadGenres(genres){
    clearCheckboxes()

    for(var j=0; j<genres.length; j++){
        selectCheckbox(genres[j].name)

    }
}

function selectCheckbox(name){
    var checkboxes = document.querySelectorAll("input[type='checkbox']")
    for(var i = 0; i < checkboxes.length; i++) {
        if(checkboxes[i].type == "checkbox") {
            if(checkboxes[i].value == name){
                checkboxes[i].checked = true;
            }
        }
    }
}

function clearCheckboxes(){
    var checkboxes = document.querySelectorAll("input[type='checkbox']")
    for(var i = 0; i < checkboxes.length; i++) {
        if(checkboxes[i].type == "checkbox") {
            checkboxes[i].checked = false;
        }
    }
}


<?php
include("Models/databaseFunctions.php");
include("Models/htmlFunctions.php");
include("Models/validation-movie.php");
include("Models/userFunctions.php");

if (!isUserLoggedIn()) {
    header("Location: index.php");
    exit();
}


$movieFormSend = isset($_POST["movie-sub"]);

$title = "";
$year = "";
$length = "";
$director = "";
$actors = "";
$genres = array();
$plot = "";
$poster = "";
$webImage = "";
$movieUnique = true;
$uploadSuccess = true;

//if user clicked on submit button
if ($movieFormSend) {

    $titleValid = validateMovieTitle($_POST["title"]);
    $title = htmlspecialchars($_POST["title"]);

    $yearValid = validateYear($_POST["year"]);
    $year = htmlspecialchars($_POST["year"]);

    $lengthValid = validateLength($_POST["length"]);
    $length = htmlspecialchars($_POST["length"]);

    $directorValid = validateDirector($_POST["director"]);
    $director = htmlspecialchars($_POST["director"]);

    $actorsValid = validateActors($_POST["actors"]);
    $actors = htmlspecialchars($_POST["actors"]);

    $genresValid = validateGenres($_POST["genre"]);
    $genres = $_POST["genre"];

    $plotValid = validatePlot($_POST["plot"]);
    $plot = htmlspecialchars($_POST["plot"]);

    $webImage = $_POST["webImage"];

    //False - poster uploaded from local disc
    //True - poster uploaded via function autocomplete and uses url
    if ($webImage == "False") {
        $posterValid = validatePoster($_FILES["poster"]);
        $poster = $_FILES["poster"];
    } else {
        $posterValid = true;
    }

    //check movie validity
    if ($titleValid && $yearValid && $lengthValid && $directorValid && $actorsValid && $genresValid && $plotValid && $posterValid) {
        if (isMovieUnique($title, $year)) {
            //upload poster from local disc
            if ($webImage == "False") {
                if (!uploadMoviewithImage($title, $year, $length, $director, $actors, $genres, $plot, $poster, $_SESSION["username"])) {
                    $uploadSuccess = false;
                }else{
                    header("Location: index.php");
                }
            } else {
                //upload poster from web url
                if (!uploadMoviewithPath($title, $year, $length, $director, $actors, $genres, $plot, $webImage, $_SESSION["username"])) {
                    $uploadSuccess = false;
                }else{
                    header("Location: index.php");
                }
            }

        } else {
            $movieUnique = false;
        }
    }

}

$genresCheckboxes = fetchAllGenres();

include("modals.php");
include("Views/insertMovie-view.php");

?>
<?php
include("Models/databaseFunctions.php");
include("Models/htmlFunctions.php");

$searchFormSend = isset($_GET["search-sub"]);

$title = "";
$genre = "All";
$rating = "All";
$order = "All";
$duration = "All";
$page = 1;

//if user clicked on search button and also set some parameters
if ($searchFormSend || count($_GET) > 0) {

    $title = htmlspecialchars($_GET["keyword"]);
    $genre = htmlspecialchars($_GET["genres"]);
    $rating = htmlspecialchars($_GET["rating"]);
    $order = htmlspecialchars($_GET["order"]);
    $duration = htmlspecialchars($_GET["duration"]);

}

//check if page number is valid
if (isset($_GET["page"]) && is_numeric($_GET["page"]) && $_GET["page"] >= 1) {
    $page = $_GET["page"];
}

//if user clicked on search button
if ($searchFormSend) {
    $page = 1;
}

$genres = fetchAllGenres();
$search = fetchSearchedFilms($title, $genre, $rating, $order, $duration, $page);

include("modals.php");
include("Views/search-view.php");

?>


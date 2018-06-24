<?php
include("Models/htmlFunctions.php");
include("Models/databaseFunctions.php");

$popular = fetchPopularFilms();
$recent = fetchRecentFilms();

include("modals.php");
include("Views/index-view.php");
?>


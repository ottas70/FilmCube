<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>FilmCube</title>

    <link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lalezar" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="Css/normalize.css" media="all">
    <link rel="stylesheet" type="text/css" href="Css/main.css" media="all">
    <link rel="stylesheet" type="text/css" href="Css/modals.css" media="all">
    <link rel="stylesheet" type="text/css" href="Css/index.css" media="all">
</head>

<body>

<?php
include("Views/loginModal-view.php");
include("Views/registerModal-view.php");
include("Views/header.php");
?>

<div class="wrapper">
    <div class="main-content">
        <div>
            <h1>Popular</h1>
            <div class="film-box">
                <?php
                $size = count($popular);
                if($size > 4 ){
                    $size = 4;
                }

                //print 4 most popular films
                //for every films fetch genres
                for ($i = 0; $i < $size; $i++) {
                    $genres = fetchMovieGenres($popular[$i]["movie_id"]);
                    echo get_movie_html($popular[$i],$genres);
                }
                ?>
            </div>
        </div>

        <div>
            <h1>Recent</h1>
            <div class="film-box">
                <?php
                $size = count($recent);
                if($size > 8 ){
                    $size = 8;
                }

                //print 8 most recent films
                //for every films fetch genres
                for ($i = 0; $i < $size; $i++) {
                    $genres = fetchMovieGenres($recent[$i]["movie_id"]);
                    echo get_movie_html($recent[$i],$genres);
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php
include("Views/footer.php");
?>

<script src="JS/basic.js"></script>
</body>
</html>
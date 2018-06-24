<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF - 8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Insert Movie</title>

    <link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lalezar" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="Css/normalize.css" media="all">
    <link rel="stylesheet" type="text/css" href="Css/main.css" media="all">
    <link rel="stylesheet" type="text/css" href="Css/modals.css" media="all">
    <link rel="stylesheet" type="text/css" href="Css/insertMovie.css" media="all">
</head>
<body>

<?php
include("Views/loginModal-view.php");
include("Views/registerModal-view.php");
include("header.php");
?>

<div class="wrapper">
    <div class="main-content">
        <form class="movie-form" method="post" enctype="multipart/form-data">
            <div class="main-info-container">
                <div class="poster-container">
                    <label for="img-input"><img class="poster" src="Images/emptyPoster.png" alt="Add Movie Poster" id="poster"></label>
                    <input name="poster" type="file" accept="image/*" class="img-input" id="img-input">
                    <input type="hidden" name="webImage" id="webImage" value="False">
                </div>
                <div class="info-container">
                    <div class="row">
                        <label for="title">Title</label>
                        <input name="title" type="text" class="text-input" id="title" value="<?php echo $title; ?>">
                    </div>
                    <?php
                    if ($movieFormSend && !$titleValid) writeMovieError("title");
                    ?>
                    <div class="row">
                        <label for="year">Year</label>
                        <input name="year" type="text" class="text-input" id="year" value="<?php echo $year; ?>">
                    </div>
                    <?php
                    if ($movieFormSend && !$yearValid) writeMovieError("year");
                    ?>
                    <div class="row">
                        <input name="autocomplete" type="button" id="autocomplete" value="Try Autocomplete">
                    </div>
                    <div class="row">
                        <label for="length">Length(min)</label>
                        <input name="length" type="text" class="text-input" id="length" value="<?php echo $length; ?>">
                    </div>
                    <?php
                    if ($movieFormSend && !$lengthValid) writeMovieError("length");
                    ?>
                    <div class="row">
                        <label for="director">Director</label>
                        <input name="director" type="text" class="text-input" id="director"
                               value="<?php echo $director; ?>">
                    </div>
                    <?php
                    if ($movieFormSend && !$directorValid) writeMovieError("director");
                    ?>
                </div>
            </div>
            <div class="actors">
                <h3>Actors</h3>
                <textarea name="actors" id="actors"><?php echo $actors; ?></textarea>
            </div>
            <?php
            if ($movieFormSend && !$actorsValid) writeMovieError("actors");
            ?>
            <div class="genres">
                <h3>Genres (max 4)</h3>
                <div class="checkbox-container">

                    <?php
                    //print all possible genres
                    foreach ($genresCheckboxes as $genre){
                        echo get_genre_checkbox_html($genre);
                    }
                    ?>

                </div>
            </div>
            <?php
            if ($movieFormSend && !$genresValid) writeMovieError("genres");
            ?>
            <div class="plot">
                <h3>Plot (min 300 chararacters)</h3>
                <textarea name="plot" id="plot"><?php echo $plot; ?></textarea>
            </div>
            <?php
            if ($movieFormSend && !$plotValid) writeMovieError("plot");
            ?>
            <input type="submit" name="movie-sub" value="Submit" id="submit-btn">
            <?php
            if ($movieFormSend && !$posterValid) writeMovieError("poster");
            if ($movieFormSend && !$movieUnique) writeMovieError("unique");
            if ($movieFormSend && !$uploadSuccess) writeMovieError("uploadSuccess");
            ?>
        </form>
    </div>
</div>

<?php
include("footer.php");
?>
<script src="JS/basic.js"></script>
<script src="JS/insertMovie.js"></script>
</body>

</html>
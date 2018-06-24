<?php

/**
 * @param $title
 * @return bool
 */
function validateMovieTitle($title){
  return strlen($title) > 0;
}

/**
 * @param $year
 * @return bool
 */
function validateYear($year){
    return (strlen($year) == 4 && is_numeric($year) && $year >= 1900);
}

/**
 * @param $length
 * @return bool
 */
function validateLength($length){
    return (is_numeric($length) && $length >= 10 && $length <= 1000);
}

/**
 * @param $director
 * @return bool
 */
function validateDirector($director){
    return strlen($director) > 0;
}

/**
 * @param $actors
 * @return bool
 */
function validateActors($actors){
    return strlen($actors) > 0;
}

/**
 * @param $genres
 * @return bool
 */
function validateGenres($genres){
   return (count($genres) >= 1 && count($genres) <= 4);
}

/**
 * @param $plot
 * @return bool
 */
function validatePlot($plot){
    return strlen($plot) >= 300;
}

/**
 * @param $poster
 * @return bool
 */
function validatePoster($poster){
   return isImage($poster) && isSizeOk($poster);
}

/**
 * @param $poster
 * @return bool
 */
function isImage($poster){
    $allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG);
    $detectedType = exif_imagetype($poster['tmp_name']);

     return in_array($detectedType, $allowedTypes);
}

/**
 * @param $poster
 * @return bool
 */
function isSizeOk($poster){
    return ($poster["size"] < 2000000);

}


/**
 * @param $type
 */
function writeMovieError($type){
    $message = "";

    if ($type === "title") {
        $message = "Title is required";
    }
    if ($type === "year") {
        $message = "Year is not valid";
    }
    if ($type === "length") {
        $message = "Length is not valid";
    }
    if ($type === "director") {
        $message = "Director is required";
    }
    if ($type === "actors") {
        $message = "Actors are required";
    }
    if ($type === "genres") {
        $message = "Invalid input of genres";
    }
    if ($type === "plot") {
        $message = "Plot must have minimally 300 characters";
    }
    if ($type === "poster") {
        $message = "Poster is not valid (max size is 2MB)";
    }
    if ($type === "unique") {
        $message = "Movie already exists";
    }
    if ($type === "uploadSuccess") {
        $message = "Movie upload failed";
    }

    echo "<div class='error-php'>$message</div>";

}
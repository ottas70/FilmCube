<?php

/**
 * @param $title
 * @return bool
 */
function validateReviewTitle($title){
    return ((strlen($title) >= 5) && (strlen($title) <= 30));
}

/**
 * @param $number
 * @return bool
 */
function validateNumericReview($number){
    return ((is_numeric($number)) && ($number >= 1) && ($number <= 10));
}

/**
 * @param $body
 * @return bool
 */
function validateReviewBody($body){
    return strlen($body) >= 80 ;
}

/**
 * @param $number
 * @return bool
 */
function validateNumberEdit($number){
    $parts = explode("/",trim($number));
    if(count($parts) != 2) return False;
    $yourReview = $parts[0];
    $ten = $parts[1];
    if(!is_numeric($yourReview) || $yourReview < 1 || $yourReview > 10) return False;
    if(!is_numeric($ten) || $ten != 10) return False;
    return True;
}

/**
 * @param $text
 * @return mixed
 */
function removeEnterSigns($text){
    $text2 = str_replace("<div>"," ",$text);
    $text3 = str_replace("</div>","",$text2);
    return $text3;
}

/**
 * @param $type
 */
function writeReviewError($type) {
    $message = "";

    if ($type === "title") {
        $message = "Title must have 5-30 characters";
    }
    if ($type === "body") {
        $message = "Invalid numeric review";
    }
    if ($type === "body") {
        $message = "Review must have min 80 characters";
    }
    if ($type === "error") {
        $message = "Unable to upload review";
    }
    if ($type === "notLogged") {
        $message = "You are already not logged in";
    }

    echo "<div class='error-php'>$message</div>";
}
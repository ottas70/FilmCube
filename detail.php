<?php
include("Models/databaseFunctions.php");
include("Models/htmlFunctions.php");
include("Models/validation-review.php");
include ("Models/userFunctions.php");


$reviewFormSend = isset($_POST["review-sub"]);
$editFormSend = isset($_POST["idEdit"]);

$style = "none";

$title = "";
$number = "";
$body = "";

$titleEdit = "";
$numberEdit = "";
$textEdit = "";

$reviewSuccesful = true;

$movie = array();
$genres = array();

//check validity of id
if (isset($_GET["id"])) {
    $movie = fetchMovieInfo(htmlspecialchars($_GET["id"]));
    $genres = genres_to_String(fetchMovieGenres(htmlspecialchars($_GET["id"])));
}

if (!isset($_GET["id"]) || empty($movie)) {
    header("Location: index.php");
}
//if user edited the review
if($editFormSend){
    //check if it is really him and review belongs to logged user
    if(isUsernameCorrect($_POST["usernameEdit"]) && isReviewWithCorrectUser($_POST["idEdit"],$_POST["usernameEdit"])) {

        $idEdit = $_POST["idEdit"];

        $titleEditValid = validateReviewTitle($_POST["titleEdit"]);
        $titleEdit = removeEnterSigns($_POST["titleEdit"]);
        $titleEdit = htmlspecialchars($titleEdit);

        $numberEditValid = validateNumberEdit($_POST["numberEdit"]);
        $numberEdit = removeEnterSigns($_POST["numberEdit"]);
        $parts = explode("/",trim($numberEdit));
        $numberEdit = htmlspecialchars($numberEdit);

        $textValidEdit = validateReviewBody($_POST["textEdit"]);
        $textEdit = removeEnterSigns($_POST["textEdit"]);
        $textEdit = htmlspecialchars($textEdit);

        if ($titleEditValid && $numberEditValid && $textValidEdit) {
            updateReview($idEdit, $titleEdit, $parts[0], $textEdit);
            $url = "Location: detail.php?id=" . $_GET["id"];
            header($url);
        }

    }else{
        $titleEditValid = false;
    }

}

//if clicked on review submit button
if ($reviewFormSend) {

    $style = "block";

    $titleValid = validateReviewTitle($_POST["title"]);
    $title = htmlspecialchars($_POST["title"]);

    $numberValid = validateNumericReview($_POST["numeric-review"]);
    $number = htmlspecialchars($_POST["numeric-review"]);

    $bodyValid = validateReviewBody($_POST["body"]);
    $body = htmlspecialchars($_POST["body"]);

    //if is everything valid
    if ($titleValid && $numberValid && $bodyValid && isUserLoggedIn()) {
        if (uploadReview($title, $number, $body, $_GET["id"], $_SESSION["username"])) {
            $style = "none";
            $url = "Location: detail.php?id=" . $_GET["id"];
            header($url);
        }else{
            $reviewSuccesful = false;
        }
    }

} else {
    if (isset($_GET["id"])) {
        updateViews($_GET["id"]);
    }
}

$numericReview = "--";

$reviews = fetchReviews($_GET["id"]);

//check number of reviews
if (!empty($reviews)) {
    $counter = 0;
    $value = 0;
    foreach ($reviews as $review) {
        $counter++;
        $value += $review["Number_review"];
    }
    if ($counter != 0) {
        $numericReview = number_format(round($value / $counter, 1), 1, ".", "");
    }
}



include("modals.php");
include("Views/detail-view.php");
?>
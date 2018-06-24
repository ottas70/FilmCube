<?php

/**
 * @param $movie
 * @param $genres
 * @return string
 */
function get_movie_html($movie, $genres)
{
    $output = "<div class=\"film\">\n"
        . "<a href=\"detail.php?id=" . htmlspecialchars($movie["movie_id"]) . "\"><img class=\"cover\" src="
        . htmlspecialchars($movie["Poster"]) . " alt=\"" . htmlspecialchars($movie["Title"]) . "\"></a>\n"
        . "<div class=\"title\">" . htmlspecialchars($movie["Title"]) . "</div>\n"
        . "<div class=\"genres\">" . genres_to_String($genres) . "</div>\n"
        . "</div>\n";
    return $output;
}

/**
 * @param $genres
 * @return string
 */
function genres_to_String($genres)
{
    $output = "";
    foreach ($genres as $genre) {
        $output .= htmlspecialchars($genre["Value"]) . ", ";
    }
    return rtrim($output, ", ");
}

/**
 * @param $genre
 * @return string
 */
function get_genre_checkbox_html($genre)
{
    $output = "<div>\n"
        . "<input name=\"genre[]\" type=\"checkbox\" value=\"" . $genre["Value"] . "\""
        . " id=\"g" . $genre["genre_id"] . "\"";


    if ((!empty($_POST["genre"]) && in_array($genre["Value"], $_POST["genre"]))) {
        $output .= "checked>";
    } else {
        $output .= ">";
    }

    $output .= "\n<label for=\"g" . htmlspecialchars($genre["genre_id"])
        . "\"> " . htmlspecialchars($genre["Value"]) . "</label>\n"
        . "</div>\n";

    return $output;
}

/**
 * @param $review
 * @return string
 */
function get_review_html($review)
{
    $output = "<div class=\"review\">\n"
        . "<h4>" . htmlspecialchars($review["Review_title"]) . "</h4>\n"
        . "<p class=\"number\">" . htmlspecialchars($review["Number_review"]) . "/10</p>\n";

    if(isUserLoggedIn() and isUsernameCorrect($review["Username"])) {
        $output .= "<form class='editForm' method='post'>\n"
            . "<img class=\"editImg\" src=\"Images/pencil.png\" alt=\"Edit\">\n"
            ."<input type=\"hidden\" name=\"idEdit\" id=\"idEdit\" value=\"" .htmlspecialchars($review["review_id"])  ."\">\n"
            ."<input type=\"hidden\" name=\"titleEdit\" id=\"titleEdit\" value=\"\">\n"
            ."<input type=\"hidden\" name=\"numberEdit\" id=\"numberEdit\" value=\"\">\n"
            ."<input type=\"hidden\" name=\"textEdit\" id=\"textEdit\" value=\"\">\n"
            ."<input type=\"hidden\" name=\"usernameEdit\" id=\"usernameEdit\" value=\"" .htmlspecialchars($_SESSION["username"])  ."\">\n"
            . "</form>\n";
    }

    $output .= "<p class=\"author\">by " . htmlspecialchars($review["Username"]) . "</p>\n"
        . "<p class=\"text\">" . htmlspecialchars($review["Value"]) . "</p>\n"
        . "</div>\n";
    return $output;
}
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/********************************************************
LOGIN/REGISTER
 ********************************************************/

/**
 * @param $username
 * @param $password
 * @return bool
 */
function isUserRegistered($username, $password){
    include("connection.php");

    $hashedPassword = hash("sha512",$password . $username);

    try {
        $results = $db->prepare("SELECT Username FROM Users WHERE Username=? AND Password=?");
        $results->bindParam(1, $username, PDO::PARAM_STR);
        $results->bindParam(2, $hashedPassword, PDO::PARAM_STR);
        $results->execute();
    } catch (Exception $e) {
        return false;
    }
    $user = $results->fetchAll(PDO::FETCH_ASSOC);
    if(count($user) == 0){
        return false;
    }else{
        return true;
    }
}

/**
 * @param $username
 * @return bool
 */
function isUsernameUnique($username){
    include("connection.php");

    try {
        $results = $db->prepare("SELECT Username FROM Users WHERE Username=?");
        $results->bindParam(1, $username, PDO::PARAM_STR);
        $results->execute();
    } catch (Exception $e) {
        return false;
    }
    $user = $results->fetchAll(PDO::FETCH_ASSOC);
    if(count($user) == 0){
        return true;
    }else{
        return false;
    }
}

/**
 * @param $email
 * @return bool
 */
function isEmailUnique($email){
    include("connection.php");

    try {
        $results = $db->prepare("SELECT Email FROM Users WHERE Email=?");
        $results->bindParam(1, $email, PDO::PARAM_STR);
        $results->execute();
    } catch (Exception $e) {
        return false;
    }
    $user = $results->fetchAll(PDO::FETCH_ASSOC);
    if(count($user) == 0){
        return true;
    }else{
        return false;
    }
}

/**
 * @param $username
 * @param $email
 * @param $password
 * @return bool
 */
function registerUser($username, $email, $password){
    include("connection.php");

    $hashedPassword = hash("sha512",$password . $username);

    try {
        $statement = $db->prepare("INSERT INTO Users (Username, Email, Password) 
               VALUES (?,?,?)");
        $statement->bindParam(1,$username, PDO::PARAM_STR);
        $statement->bindParam(2,$email, PDO::PARAM_STR);
        $statement->bindParam(3,$hashedPassword, PDO::PARAM_STR);
        $statement->execute();
    } catch (Exception $e) {
        return False;
    }
    return True;
}

/********************************************************
MAIN PAGE
 ********************************************************/

/**
 *
 */
function fetchPopularFilms()
{
    include("connection.php");

    try {
        $results = $db->query("SELECT movie_id, Title, Year, Poster FROM Movies ORDER BY Views DESC LIMIT 4");
    } catch (Exception $e) {
        echo "Unable to retrieve results";
        return;
    }
    $popular = $results->fetchAll(PDO::FETCH_ASSOC);
    return $popular;
}

/**
 *
 */
function fetchRecentFilms()
{
    include("connection.php");

    try {
        $results = $db->query("SELECT movie_id, Title, Year, Poster FROM Movies ORDER BY Timestamp DESC LIMIT 8");
    } catch (Exception $e) {
        echo "Unable to retrieve results";
        return;
    }
    $recent = $results->fetchAll(PDO::FETCH_ASSOC);
    return $recent;
}

 $params = array();

/********************************************************
 SEARCH
 ********************************************************/

/**
 * @param $keyword
 * @param $genre
 * @param $rating
 * @param $order
 * @param $duration
 * @param $page
 */
function fetchSearchedFilms($keyword ,$genre, $rating, $order, $duration,$page){
    include("connection.php");

    global $params;
    global $rating;
    $keyword = "%" .$keyword ."%";

    $sql = buildSearchSQL($keyword, $genre, $rating, $order, $duration,$page);

    try {
        $results = $db->prepare($sql);
        $results->execute($params);
    } catch (Exception $e) {
        echo "Error occured";
        return;
    }

    $search = $results->fetchAll(PDO::FETCH_ASSOC);
    return $search;
}

/**
 * @param $keyword
 * @param $genre
 * @param $rating
 * @param $order
 * @param $duration
 * @param $page
 * @return string
 */
function buildSearchSQL($keyword , $genre, $rating, $order, $duration, $page){
    /*"SELECT Movies.movie_id, Title, Year, Poster FROM Movies
              LEFT OUTER JOIN Movies_genres
              ON Movies.movie_id = Movies_genres.movie_id
              INNER JOIN Reviews ON Reviews.movie_id = Movies.movie_id
              WHERE Title LIKE \"?%\" AND genre_id=
              (SELECT genre_id FROM Genres WHERE Value=?)
              AND Length >= ?
              GROUP BY Movies.movie_id
              HAVING AVG(Reviews.Number_review) >= 8
              ORDER BY Title DESC";*/
    global $params;

    $sql = "SELECT Movies.movie_id, Title, Year, Poster FROM Movies";

    if($genre != "All"){
        $sql .= " LEFT OUTER JOIN Movies_genres
              ON Movies.movie_id = Movies_genres.movie_id";
    }

    if($rating != "All" || $order == "rating_asc" || $order == "rating_desc"){
        $sql .= " INNER JOIN Reviews ON Reviews.movie_id = Movies.movie_id";
    }

    $sql .= " WHERE Title LIKE :title";
    $params["title"] = $keyword;

    if($genre != "All"){
        $sql .= " AND genre_id=
            (SELECT genre_id FROM Genres WHERE Value=:genre)";
        $params["genre"] = $genre;
    }

    if($duration != "All"){
        $sql .= " AND Length >= :duration";
        $params["duration"] = $duration;
    }

    if($rating != "All" || $order == "rating_asc" || $order == "rating_desc"){
        $sql .= " GROUP BY Movies.movie_id HAVING AVG(Reviews.Number_review) >= :rating";
        $params[":rating"] = $rating;
    }

    if($order != "All"){
        if($order == "AZ"){
            $sql .= " ORDER BY Title ASC";
        }

        if($order == "rating_asc"){
            $sql .= " ORDER BY AVG(Reviews.Number_review) ASC";
        }

        if($order == "rating_desc"){
            $sql .= " ORDER BY AVG(Reviews.Number_review) DESC";
        }
    }

    $sql .= " LIMIT 12 OFFSET " .($page*12-12);

    return $sql;
}

/**
 *
 */
function fetchAllGenres()
{
    include("connection.php");

    try {
        $results = $db->query("SELECT * FROM Genres");
    } catch (Exception $e) {
        echo "Unable to retrieve results from database";
        return;
    }
    $genres = $results->fetchAll(PDO::FETCH_ASSOC);
    return $genres;
}

/********************************************************
MOVIE DETAILS
 ********************************************************/

/**
 * @param $id
 */
function fetchMovieInfo($id)
{
    include("connection.php");

    try {
        $results = $db->prepare("SELECT * FROM Movies JOIN Users ON Movies.user_id=Users.user_id WHERE movie_id=?");
        $results->bindParam(1, $id, PDO::PARAM_INT);
        $results->execute();
    } catch (Exception $e) {
        return;
    }

    $movie = $results->fetch(PDO::FETCH_ASSOC);
    return $movie;
}

/**
 * @param $id
 */
function fetchReviews($id)
{
    include("connection.php");

    try {
        $results = $db->prepare("SELECT * FROM Reviews JOIN Users ON Reviews.user_id=Users.user_id WHERE movie_id=?");
        $results->bindParam(1, $id, PDO::PARAM_INT);
        $results->execute();
    } catch (Exception $e) {
        return;
    }

    $reviews = $results->fetchAll(PDO::FETCH_ASSOC);
    return $reviews;
}

/**
 * @param $id
 */
function fetchMovieGenres($id)
{
    include("connection.php");

    try {
        $results = $db->prepare("SELECT Genres.Value 
              FROM Movies_genres 
              JOIN Genres ON Movies_genres.genre_id=Genres.genre_id 
              WHERE movie_id=?");
        $results->bindParam(1, $id, PDO::PARAM_INT);
        $results->execute();
    } catch (Exception $e) {
        return;
    }

    $genres = $results->fetchAll(PDO::FETCH_ASSOC);
    return $genres;
}

/**
 * @param $id
 */
function updateViews($id){
    include("connection.php");

    try {
        $results = $db->prepare("UPDATE Movies SET Views = Views + 1 WHERE movie_id=?");
        $results->bindParam(1, $id, PDO::PARAM_INT);
        $results->execute();
    } catch (Exception $e) {
        return;
    }
}


/**
 * @param $title
 * @param $number
 * @param $value
 * @param $movie_id
 * @param $username
 * @return bool
 */
function uploadReview($title, $number, $value, $movie_id, $username){
    include("connection.php");

    try {
        $statement = $db->prepare("INSERT INTO Reviews (Review_title, Number_review, Value, user_id, movie_id) 
               VALUES (?,?,?,(SELECT user_id FROM Users WHERE Username=?),?)");
        $statement->bindParam(1,$title, PDO::PARAM_STR);
        $statement->bindParam(2,$number, PDO::PARAM_INT);
        $statement->bindParam(3,$value, PDO::PARAM_STR);
        $statement->bindParam(4,$username, PDO::PARAM_STR);
        $statement->bindParam(5,$movie_id, PDO::PARAM_INT);
        $statement->execute();
    } catch (Exception $e) {
        return False;
    }
    return True;
}

/********************************************************
REVIEW EDITING
 ********************************************************/

function updateReview($id, $title, $number, $text){
    include("connection.php");

    try {
        $results = $db->prepare("UPDATE Reviews SET Review_title=?, Number_review = ?, Value=? WHERE review_id=?");
        $results->bindParam(1, $title, PDO::PARAM_STR);
        $results->bindParam(2, $number, PDO::PARAM_INT);
        $results->bindParam(3, $text, PDO::PARAM_STR);
        $results->bindParam(4, $id, PDO::PARAM_INT);
        $results->execute();
    } catch (Exception $e) {
        return;
    }/**
     * @param $review_id
     * @param $username
     * @return bool
     */
}


/**
 * @param $review_id
 * @param $username
 * @return bool
 */
function isReviewWithCorrectUser($review_id, $username){
    include("connection.php");

    try {
        $results = $db->prepare("SELECT Review_title FROM Reviews
            JOIN Users ON Reviews.user_id = Users.user_id
            WHERE review_id=? AND Username=?");
        $results->bindParam(1, $review_id, PDO::PARAM_INT);
        $results->bindParam(2, $username, PDO::PARAM_STR);
        $results->execute();
    } catch (Exception $e) {
        return false;
    }
    $review = $results->fetchAll(PDO::FETCH_ASSOC);
    if(count($review) == 0){
        return false;
    }else{
        return true;
    }
}


 /********************************************************
 MOVIE UPLOAD
 ********************************************************/

/**
 * @param $title
 * @param $year
 * @return bool
 */
function isMovieUnique($title, $year){
    include("connection.php");

    try {
        $results = $db->prepare("SELECT Title FROM Movies WHERE Title=? AND Year=?");
        $results->bindParam(1, $title, PDO::PARAM_STR);
        $results->bindParam(2, $year, PDO::PARAM_INT);
        $results->execute();
    } catch (Exception $e) {
        echo "Unable to connect to database";
        exit;
    }
    $movie = $results->fetchAll(PDO::FETCH_ASSOC);
    if(count($movie) == 0){
        return true;
    }else{
        return false;
    }
}

/**
 * @param $title
 * @param $year
 * @param $length
 * @param $director
 * @param $actors
 * @param $genres
 * @param $plot
 * @param $poster
 * @param $username
 * @return bool
 */
function uploadMoviewithImage($title, $year, $length, $director, $actors, $genres, $plot, $poster, $username){
    include("connection.php");

    $filename = uniqid(rand(), true) . '.jpg';
    $poster["name"] = $filename;
    $posterPath = "Images/Posters/" .$filename;

    if(!uploadPoster($poster)){
        return False;
    }

    try {
        $statement = $db->prepare("INSERT INTO Movies (Title, Year, Length, Director, Actors, Plot, Poster, user_id) 
                VALUES (?,?,?,?,?,?,?,(SELECT user_id FROM Users WHERE Username=?))");
        $statement->bindParam(1,$title, PDO::PARAM_STR);
        $statement->bindParam(2,$year, PDO::PARAM_INT);
        $statement->bindParam(3,$length, PDO::PARAM_INT);
        $statement->bindParam(4,$director, PDO::PARAM_STR);
        $statement->bindParam(5,$actors, PDO::PARAM_STR);
        $statement->bindParam(6,$plot, PDO::PARAM_STR);
        $statement->bindParam(7,$posterPath, PDO::PARAM_STR);
        $statement->bindParam(8,$username, PDO::PARAM_STR);
        $statement->execute();
    } catch (Exception $e) {
        return False;
    }

    if(uploadGenres($genres,$title,$year)) return True;

}

/**
 * @param $title
 * @param $year
 * @param $length
 * @param $director
 * @param $actors
 * @param $genres
 * @param $plot
 * @param $path
 * @param $username
 * @return bool
 */
function uploadMoviewithPath($title, $year, $length, $director, $actors, $genres, $plot, $path, $username){
    include("connection.php");
    try {
        $statement = $db->prepare("INSERT INTO Movies (Title, Year, Length, Director, Actors, Plot, Poster, user_id) 
                VALUES (?,?,?,?,?,?,?,(SELECT user_id FROM Users WHERE Username=?))");
        $statement->bindParam(1,$title, PDO::PARAM_STR);
        $statement->bindParam(2,$year, PDO::PARAM_INT);
        $statement->bindParam(3,$length, PDO::PARAM_INT);
        $statement->bindParam(4,$director, PDO::PARAM_STR);
        $statement->bindParam(5,$actors, PDO::PARAM_STR);
        $statement->bindParam(6,$plot, PDO::PARAM_STR);
        $statement->bindParam(7,$path, PDO::PARAM_STR);
        $statement->bindParam(8,$username, PDO::PARAM_STR);
        $statement->execute();
    } catch (Exception $e) {
        return False;
    }

    if(uploadGenres($genres,$title,$year)) return True;

}

/**
 * @param $genres
 * @param $title
 * @param $year
 * @return bool
 */
function uploadGenres($genres, $title, $year){
    include("connection.php");
    foreach ($genres as $genre) {
        try {
            $statement = $db->prepare("INSERT INTO Movies_genres (movie_id, genre_id) 
                VALUES (
                (SELECT movie_id FROM Movies WHERE Title=? AND Year=?),
                (SELECT genre_id FROM Genres WHERE Value=?)
                )");
            $statement->bindParam(1, $title, PDO::PARAM_STR);
            $statement->bindParam(2, $year, PDO::PARAM_INT);
            $statement->bindParam(3, $genre, PDO::PARAM_STR);
            $statement->execute();
        } catch (Exception $e) {
            return False;
        }
    }
    return True;
}

/**
 * @param $poster
 * @return bool
 */
function uploadPoster($poster){

    $targetFile = "Images/Posters/" .$poster["name"];
    $temporaryFile = $poster["tmp_name"];

    if (file_exists($targetFile)) {
        echo "Sorry, file already exists.";
        return False;
    }

    if(move_uploaded_file($temporaryFile,$targetFile)){
        resizeImage($targetFile);
        return True;
    }else{
        echo "Image upload failed";
        return False;
    }

}

/**
 * @param $targetFile
 */
function resizeImage($targetFile){
   $source = imagecreatefromjpeg($targetFile);
   list($width, $height) = getimagesize($targetFile);

   $newWidth = 400;
   $newHeight = 600;

   $tmp = imagecreatetruecolor($newWidth, $newHeight);
   imagecopyresampled($tmp, $source, 0, 0 ,0, 0, $newWidth, $newHeight, $width, $height);
   imagejpeg($tmp, $targetFile, 100);

}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Browse Movies</title>

    <link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lalezar" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="Css/normalize.css" media="all">
    <link rel="stylesheet" type="text/css" href="Css/main.css" media="all">
    <link rel="stylesheet" type="text/css" href="Css/modals.css" media="all">
    <link rel="stylesheet" type="text/css" href="Css/search.css" media="all">
</head>
<body>

<?php
include("Views/loginModal-view.php");
include("Views/registerModal-view.php");
include("header.php");
?>

<div class="wrapper">
    <div class="search-container">
        <form method="get">
            <div class="search-fields">
                <label for="titleSearch" class="search-headline">Search Title</label>
                <input id="titleSearch" type="search" name="keyword"
                       value="<?php if (isset($_GET['keyword'])) echo $title; ?>">
                <div class="select">
                    <label for="genreSelect">Genre</label>
                    <select id="genreSelect" name="genres">
                        <option value="All">All</option>
                        <?php
                        //print all available genres
                        foreach ($genres as $option) {
                            $output = "<option value=\"" . $option["Value"] . "\"";
                            if (isset($_GET['genres']) && $_GET['genres'] == $option["Value"]) {
                                $output .= "selected";
                            }
                            $output .= ">" . $option["Value"] . "</option>\n";
                            echo $output;
                        }
                        ?>

                    </select>
                </div>
                <div class="select">
                    <label for="ratingSelect">Rating</label>
                    <select id="ratingSelect" name="rating">
                        <option value="All" <?php if (isset($_GET['rating']) && $_GET['rating'] == "All") echo 'selected'; ?>>
                            All
                        </option>
                        <option value="10" <?php if (isset($_GET['rating']) && $_GET['rating'] == "10") echo 'selected'; ?>>
                            10
                        </option>
                        <option value="9" <?php if (isset($_GET['rating']) && $_GET['rating'] == "9") echo 'selected'; ?>>
                            9+
                        </option>
                        <option value="8" <?php if (isset($_GET['rating']) && $_GET['rating'] == "8") echo 'selected'; ?>>
                            8+
                        </option>
                        <option value="7" <?php if (isset($_GET['rating']) && $_GET['rating'] == "7") echo 'selected'; ?>>
                            7+
                        </option>
                        <option value="6" <?php if (isset($_GET['rating']) && $_GET['rating'] == "6") echo 'selected'; ?>>
                            6+
                        </option>
                        <option value="5" <?php if (isset($_GET['rating']) && $_GET['rating'] == "5") echo 'selected'; ?>>
                            5+
                        </option>
                        <option value="4" <?php if (isset($_GET['rating']) && $_GET['rating'] == "4") echo 'selected'; ?>>
                            4+
                        </option>
                        <option value="3" <?php if (isset($_GET['rating']) && $_GET['rating'] == "3") echo 'selected'; ?>>
                            3+
                        </option>
                        <option value="2" <?php if (isset($_GET['rating']) && $_GET['rating'] == "2") echo 'selected'; ?>>
                            2+
                        </option>
                        <option value="1" <?php if (isset($_GET['rating']) && $_GET['rating'] == "1") echo 'selected'; ?>>
                            1+
                        </option>
                    </select>
                </div>
                <div class="select">
                    <label for="orderSelect">Order by</label>
                    <select id="orderSelect" name="order">
                        <option value="All" <?php if (isset($_GET['order']) && $_GET['order'] == "All") echo 'selected'; ?>>
                            All
                        </option>
                        <option value="AZ" <?php if (isset($_GET['order']) && $_GET['order'] == "AZ") echo 'selected'; ?>>
                            A-Z
                        </option>
                        <option value="rating_asc" <?php if (isset($_GET['order']) && $_GET['order'] == "rating_asc") echo 'selected'; ?>>
                            Rating asc
                        </option>
                        <option value="rating_desc" <?php if (isset($_GET['order']) && $_GET['order'] == "rating_desc") echo 'selected'; ?>>
                            Rating desc
                        </option>
                    </select>
                </div>
                <div class="select">
                    <label for="durationSelect">Duration</label>
                    <select id="durationSelect" name="duration">
                        <option value="All" <?php if (isset($_GET['duration']) && $_GET['duration'] == "All") echo 'selected'; ?>>
                            All
                        </option>
                        <option value="10" <?php if (isset($_GET['duration']) && $_GET['duration'] == "10") echo 'selected'; ?>>
                            10+
                        </option>
                        <option value="30" <?php if (isset($_GET['duration']) && $_GET['duration'] == "30") echo 'selected'; ?>>
                            30+
                        </option>
                        <option value="60" <?php if (isset($_GET['duration']) && $_GET['duration'] == "60") echo 'selected'; ?>>
                            60+
                        </option>
                        <option value="90" <?php if (isset($_GET['duration']) && $_GET['duration'] == "90") echo 'selected'; ?>>
                            90+
                        </option>
                        <option value="120" <?php if (isset($_GET['duration']) && $_GET['duration'] == "120") echo 'selected'; ?>>
                            120+
                        </option>
                        <option value="180" <?php if (isset($_GET['duration']) && $_GET['duration'] == "180") echo 'selected'; ?>>
                            180+
                        </option>
                    </select>
                </div>
            </div>
            <input type="hidden" id="pageInput" name="page" value="<?php echo $page; ?>">
            <input class="search-btn" name="search-sub" type="submit" value="Search">
        </form>
    </div>

    <div class="wrapper-gallery">
        <div class="gallery">
            <div class="film-box">
                <?php
                //print all films on a page
                $size = count($search);
                if ($size == 0) {
                    echo "<div class=\"no-result\">NOTHING FOUND</div>";
                }
                if ($size > 12) {
                    $size = 12;
                }
                for ($i = 0; $i < $size; $i++) {
                    $genres = fetchMovieGenres($search[$i]["movie_id"]);
                    echo get_movie_html($search[$i], $genres);
                }
                ?>
            </div>
        </div>
    </div>

    <div class="page-selector">
        <button class=pageBtn id="pagePrev">Prev</button>
        <button class=pageBtn id="pageNext">Next</button>
    </div>
</div>


<?php
include("footer.php");
?>
<script src="JS/basic.js"></script>
<script src="JS/search.js"></script>
</body>
</html>
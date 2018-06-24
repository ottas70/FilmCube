<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo htmlspecialchars($movie["Title"]); ?></title>

    <link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lalezar" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="Css/normalize.css" media="all">
    <link rel="stylesheet" type="text/css" href="Css/main.css" media="all">
    <link rel="stylesheet" type="text/css" href="Css/modals.css" media="all">
    <link rel="stylesheet" type="text/css" href="Css/detail.css" media="all">
</head>
<body>

<?php
include("Views/loginModal-view.php");
include("Views/registerModal-view.php");
include("header.php");
?>

<div class="wrapper">
    <div id="review-dialog" class="dialog" style="display: <?php echo $style; ?>">
        <div class="dialog-content">
            <img class="exit" id="reviewExit" src="Images/cancel.png" alt="Cancel">
            <p class="dialog-header">Write Review</p>
            <form class="horizontal-form" id="review-form" method="post">
                <div class="form-row">
                    <input type="text" class="form-input" id="title" name="title" placeholder="Title"
                           value="<?php echo $title; ?>">
                </div>
                <div class="form-row">
                    <select name="numeric-review" id="numeric-review">
                        <option value="10" <?php if (isset($_POST['numeric-review']) && $_POST['numeric-review'] == "10") echo 'selected'; ?>>
                            10
                        </option>
                        <option value="9" <?php if (isset($_POST['numeric-review']) && $_POST['numeric-review'] == "9") echo 'selected'; ?>>
                            9
                        </option>
                        <option value="8" <?php if (isset($_POST['numeric-review']) && $_POST['numeric-review'] == "8") echo 'selected'; ?>>
                            8
                        </option>
                        <option value="7" <?php if (isset($_POST['numeric-review']) && $_POST['numeric-review'] == "7") echo 'selected'; ?>>
                            7
                        </option>
                        <option value="6" <?php if (isset($_POST['numeric-review']) && $_POST['numeric-review'] == "6") echo 'selected'; ?>>
                            6
                        </option>
                        <option value="5" <?php if (isset($_POST['numeric-review']) && $_POST['numeric-review'] == "5") echo 'selected'; ?>>
                            5
                        </option>
                        <option value="4" <?php if (isset($_POST['numeric-review']) && $_POST['numeric-review'] == "4") echo 'selected'; ?>>
                            4
                        </option>
                        <option value="3" <?php if (isset($_POST['numeric-review']) && $_POST['numeric-review'] == "3") echo 'selected'; ?>>
                            3
                        </option>
                        <option value="2" <?php if (isset($_POST['numeric-review']) && $_POST['numeric-review'] == "2") echo 'selected'; ?>>
                            2
                        </option>
                        <option value="1" <?php if (isset($_POST['numeric-review']) && $_POST['numeric-review'] == "1") echo 'selected'; ?>>
                            1
                        </option>
                    </select>
                </div>
                <div class="form-row">
                    <textarea class="form-input" id="body" name="body"
                              placeholder="Here write your review...  (min 80 char)"><?php echo $body; ?></textarea>
                </div>
                <?php
                if ($reviewFormSend && !$titleValid) writeReviewError("title");
                if ($reviewFormSend && !$numberValid) writeReviewError("number");
                if ($reviewFormSend && !$bodyValid) writeReviewError("body");
                if ($reviewFormSend && !$reviewSuccesful) writeReviewError("error");
                if ($reviewFormSend && !isUserLoggedIn()) writeReviewError("notLogged");
                ?>
                <input type="submit" name="review-sub" class="submit-btn" id="submit-button-review" value="Submit">
            </form>
        </div>
    </div>

    <div class="wrapper">
        <div class="filmInfo">
            <div class="mainInfo-container">
                <div class="cover-container">
                    <img class="cover" src="<?php echo htmlspecialchars($movie["Poster"]); ?>"
                         alt="<?php echo htmlspecialchars($movie["Title"]); ?>">
                </div>
                <div class="info-container">
                    <h2><?php echo htmlspecialchars($movie["Title"]); ?></h2>
                    <p class="info"><?php echo htmlspecialchars($movie["Year"]); ?></p>
                    <p class="info" id="genres"><?php echo htmlspecialchars($genres); ?></p>
                    <p class="info" id="duration"><?php echo htmlspecialchars($movie["Length"]); ?> min</p>
                    <div class="people-container">
                        <div class="highlightText">
                            Director: <span class="people"
                                            id="director"><?php echo htmlspecialchars($movie["Director"]); ?></span>
                        </div>
                        <div class="highlightText">
                            Actors: <span class="people"
                                          id="actors"><?php echo htmlspecialchars($movie["Actors"]); ?></span>
                        </div>
                    </div>
                </div>
                <div class="numberReview">
                    <?php echo htmlspecialchars($numericReview); ?>
                </div>
            </div>

            <div class="plot-container">
                <h3>Plot</h3>
                <p class="text">
                    <?php echo htmlspecialchars($movie["Plot"]); ?>
                </p>
            </div>

            <div class="parentalGuide">
                <h4>Parental Guide</h4>
                <p class="parentalInfo">Uploaded by <?php echo htmlspecialchars($movie["Username"]); ?></p>
                <p class="parentalInfo">Viewed <?php echo htmlspecialchars($movie["Views"]); ?> times</p>
                <p class="parentalInfo"><?php echo date("F j, Y", strtotime($movie["Timestamp"])); ?></p>
            </div>
        </div>

        <div class="reviews-container">
            <div class="reviewsHeader">
                <h3>Movie Reviews</h3>
                <input type="button" id="write-review-btn" value="Write Review" style="<?php if(!isUserLoggedIn()) echo "display: none"; ?>">
            </div>

            <?php
             //error message after editing
            if ($editFormSend && !($titleEditValid && $numberEditValid && $textValidEdit)) echo "<div class='error-php'>Invalid values</div>";

            //print all reviews
            if (!empty($reviews)) {
                foreach ($reviews as $review) {
                    echo get_review_html($review);
                }
            } else {
                echo "<div class=\"empty\"> No reviews yet </div>";
            }
            ?>

        </div>
    </div>
</div>

<?php
include("footer.php");
?>
<script src="JS/basic.js"></script>
<script src="JS/detail.js"></script>
</body>

</html>
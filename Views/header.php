
<header>
    <div class="main-logo">
        <a href="index.php"><span>FILM</span>CUBE</a>
    </div>
    <ul class="menu" id="nav">
        <li>
            <a href="search.php">Browse Movies</a>
        </li>
        <li <?php if (isUserLoggedIn()) echo " class=\"hidden\""; ?>>
            <a id="register-btn">Register</a>
        </li>
        <li <?php if (isUserLoggedIn()) echo " class=\"hidden\""; ?>>
            <a id="login-btn">Login</a>
        </li>
        <li>
            <a id="logged-user" <?php if (isUserLoggedIn()) echo " class=\"shown\""; ?>><?php if (isUserLoggedIn()) echo htmlspecialchars($_SESSION["username"]) ?></a>
            <div class="dropdown">
                <p><a href="insertMovie.php">Add Movie</a></p>
                <p><a href="<?php echo "http://" . $_SERVER["HTTP_HOST"] . $_SERVER["PHP_SELF"] . "?logout=true"; ?>">Logout</a>
                </p>
            </div>
        </li>
    </ul>
</header>
<?php

session_start();

/**
 * @param $username
 */
function logUserIn($username){
    $_SESSION["username"] = $username;
}

/**
 * @return bool
 */
function isUserLoggedIn(){
    return isset($_SESSION["username"]);
}

/**
 *
 */
function logUserOut(){
    session_destroy();
    header("Location: index.php");
    exit();
}

/**
 * @param $username
 * @return bool
 */
function isUsernameCorrect($username){
    if(isUserLoggedIn()){
        if($_SESSION["username"] == $username){
            return true;
        }
    }
    return false;
}
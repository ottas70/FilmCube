<?php

/**
 * @param $name
 * @return bool
 */
function validateName($name){
    return ((strlen($name) >= 4) && (strlen($name) <= 15));
}

/**
 * @param $password
 * @return bool
 */
function validatePassword($password){
    return strlen($password) > 7 ;
}

/**
 * @param $email
 * @return mixed
 */
function validateEmail($email){
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * @param $password1
 * @param $password2
 * @return bool
 */
function confirmPassword($password1, $password2){
    return $password1 === $password2;
}

/**
 *
 */
function writeLoginError() {
    $message = "Invalid login data";
    echo "<div class='error-php'>$message</div>";
}

/**
 * @param $type
 */
function writeRegisterError($type) {
    $message = "";

    if ($type === "username") {
        $message = "Username must have 4-15 characters";
    }
    if ($type === "email") {
        $message = "Incorrect email";
    }
    if ($type === "password") {
        $message = "Password must have min 8 characters";
    }
    if ($type === "confirm") {
        $message = "Passwords don't match";
    }
    if ($type === "usernameUnique") {
        $message = "Username is already used";
    }
    if ($type === "emailUnique") {
        $message = "Email is already used";
    }
    if ($type === "register") {
        $message = "Unable to register user";
    }
    if ($type === "alreadyLogged") {
        $message = "You are already logged in";
    }

    echo "<div class='error-php'>$message</div>";
}
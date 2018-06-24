<?php
include("Models/validation-modals.php");
include_once("Models/userFunctions.php");

$loginFormSend = isset($_POST["login-sub"]);
$registerFormSend = isset($_POST["reg-sub"]);

$username = "";
$password = "";

$usernameReg = "";
$email = "";
$passwordReg = "";
$confirm = "";

$styleLog = "none";
$styleReg = "none";

$usernameUnique = true;
$emailUnique = true;
$userRegistered = true;
$registerSuccesful = true;

//user wants to logout
if (isset($_GET["logout"])) {
    logUserOut();
}

//if user wants to log in
if ($loginFormSend) {

    $styleLog = "block";

    $usernameValid = validateName($_POST["username"]);
    $username = htmlspecialchars($_POST["username"]);

    $password = htmlspecialchars($_POST["password"]);
    $passwordValid = validatePassword($_POST["password"]);

    //check validity of input data
    if ($usernameValid && $passwordValid && !isUserLoggedIn()) {
        if (isUserRegistered($_POST["username"], $_POST["password"])) {
            $styleLog = "none";
            logUserIn($_POST["username"]);
        } else {
            $userRegistered = false;
        }
    }
}

//if user wants to register
if ($registerFormSend) {

    $styleReg = "block";

    $usernameRegValid = validateName($_POST["usernameReg"]);
    $usernameReg = htmlspecialchars($_POST["usernameReg"]);

    $emailValid = validateEmail($_POST["email"]);
    $email = htmlspecialchars($_POST["email"]);

    $passwordRegValid = validatePassword($_POST["passwordReg"]);
    $passwordReg = htmlspecialchars($_POST["passwordReg"]);

    $confirmValid = confirmPassword($_POST["confirm"], $_POST["passwordReg"]);
    $confirm = htmlspecialchars($_POST["confirm"]);

    //check validity of input data
    if ($usernameRegValid && $passwordRegValid && $emailValid && $confirmValid && !isUserLoggedIn()) {
        if (isUsernameUnique($_POST["usernameReg"])) {
            if (isEmailUnique($_POST["email"])) {
                if (registerUser($_POST["usernameReg"], $_POST["email"], $_POST["passwordReg"])) {
                    $styleReg = "none";
                    logUserIn($_POST["usernameReg"]);
                } else {
                    $registerSuccesful = false;
                }
            } else {
                $emailUnique = false;
            }
        } else {
            $usernameUnique = false;
        }

    }
}

?>


<!DOCTYPE html>
<html>
<?php
    include("../views/login_head.php");
    require_once("../queries/connect.php");
    include_once("../queries/register.php");
    include_once("../queries/checkInput.php");
?>
<body>
<?php
    session_start();

    // define variables and set to empty values
    $name = $surname = $bday = $username = $password = $confirmpassword = $location = $housenumber = $email = "";
    $genericErr = $nameErr = $surnameErr = $bdayErr = $usernameErr = $passwordErr = $confirmpasswordErr = $locationErr = $housenumberErr = $emailErr = "";
    $correct = true;

    // Trying to register an account
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        checkInputChoice("name", "lettersAndSpace");
        checkInputChoice("surname", "lettersAndSpace");

        if (empty($_POST["bday"])) {
            $bdayErr = "Geboortedatum is verplicht!";
            $correct = false;

        } else {
          $bday = test_input($_POST["bday"]);
        }

        checkInputChoice("username", "username");
        checkInputChoice("password", "longerEigth");
        checkInputChoice("confirmpassword", "");
        matchPassword();
        checkInputChoice("location", "lettersAndSpace");
        checkInputChoice("email", "email");
        registerCheck();
    }
/* This view adds register view */
include("../views/register-view.php");
?>
</body>
</html>

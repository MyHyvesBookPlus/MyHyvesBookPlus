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
    if(isset($_SESSION["userID"])){
        header("location: login.php");
    }
    // define variables and set to empty values
    $name = $surname = $bday = $username = $password = $confirmpassword = $location = $housenumber = $email = $captcha = $ip = "";
    $genericErr = $nameErr = $surnameErr = $bdayErr = $usernameErr = $passwordErr = $confirmpasswordErr = $locationErr = $housenumberErr = $emailErr = $captchaErr = "";
    $correct = true;

    // Trying to register an account
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            $name = test_input(($_POST["name"]));
            checkInputChoice($name, "lettersAndSpaces");
        } catch(lettersAndSpacesException $e){
            $correct = false;
            $nameErr = $e->getMessage();
        }

        try {
            $surname = test_input(($_POST["surname"]));
            checkInputChoice($surname, "lettersAndSpaces");
        }
        catch(lettersAndSpacesException $e){
            $correct = false;
            $surnameErr = $e->getMessage();
        }

        try{
            $bday = test_input(($_POST["bday"]));
            checkInputChoice($bday, "bday");
        } catch(bdayException $e){
            $correct = false;
            $bdayErr = $e->getMessage();
        }

        try{
            $username = str_replace(' ', '', test_input(($_POST["username"])));
            checkInputChoice($username, "username");
        } catch(usernameException $e){
            $correct = false;
            $usernameErr = $e->getMessage();
        }

        try{
            $password = str_replace(' ', '', test_input(($_POST["password"])));
            checkInputChoice($password, "longerEight");
            matchPassword();
        } catch(passwordException $e){
            $correct = false;
            $passwordErr = $e->getMessage();
        } catch(confirmPasswordException $e){
            $correct = false;
            $confirmPasswordErr = $e->getMessage();
        }

        try{
            $location = test_input(($_POST["location"]));
            checkInputChoice($location, "lettersAndSpaces");
        } catch(lettersAndSpacesException $e){
            $correct = false;
            $locationErr = $e->getMessage();
        }

        try{
            $email = test_input(($_POST["email"]));
            checkInputChoice($email, "email");
        } catch(emailException $e){
            $correct = false;
            $emailErr = $e->getMessage();
        }

        try{
            $captcha = $_POST['g-recaptcha-response'];
            checkCaptcha($captcha);
        } catch(captchaException $e){
            $correct = false;
            $captchaErr = $e->getMessage();
        }

        try {
            getIp();
            registerCheck($correct);
        } catch(registerException $e){
            $genericErr = $e->getMessage();
        }
    }
/* This view adds register view */
include("../views/register-view.php");
?>
</body>
</html>

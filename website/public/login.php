<!DOCTYPE html>
<html>
<?php
    include("../views/login_head.php");
    require_once("../queries/connect.php");
    include_once("../queries/login.php");
    include_once("../queries/checkInput.php");
    include_once("../queries/emailconfirm.php");
    include_once("../queries/requestpassword.php");
    include_once("../queries/register.php");
?>
<body>
<?php
    session_start();

    if(isset($_SESSION["userID"])){
      echo "<script>
                window.onload=checkLoggedIn();
            </script>";
    }

    // define variables and set to empty values
    $name = $surname = $bday = $username = $password = $confirmpassword = $location = $housenumber = $email = $confirmEmail = $captcha = $ip = "";
    $genericErr = $nameErr = $surnameErr = $bdayErr = $usernameErr = $passwordErr = $confirmpasswordErr = $locationErr = $housenumberErr = $emailErr = $confirmEmailErr = $captchaErr = "";
    $correct = true;
    $day_date = "dag";
    $month_date = "maand";
    $year_date = "jaar";

    // Define variables and set to empty values
    $user = $psw ="";
    $loginErr = $resetErr ="";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        switch ($_POST["submit"]) {
            case "login":
                try {
                    $user = ($_POST["user"]);
                    validateLogin($_POST["user"], $_POST["psw"]);
                } catch(loginException $e) {
                    $loginErr = $e->getMessage();
                }
                break;
            case "reset":
                try {
                    resetEmail($_POST["forgotEmail"]);
                    sendPasswordRecovery($_POST["forgotEmail"]);
                } catch (emailException $e){
                    $resetErr = $e->getMessage();
                    echo "<script>
                            window.onload = function() {
                              $('#myModal').show();
                            }
                          </script>";
                }
                break;
            case "register":
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
                    $day_date = test_input(($_POST["day_date"]));
                    $month_date = test_input(($_POST["month_date"]));
                    $year_date = test_input(($_POST["year_date"]));
                    $bday = $year_date . "-" . $month_date . "-" . $day_date;
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
                    $confirmEmail = test_input(($_POST["confirmEmail"]));
                    matchEmail();
                } catch(emailException $e){
                    $correct = false;
                    $emailErr = $e->getMessage();
                } catch(confirmEmailException $e){
                    $correct = false;
                    $confirmEmailErr = $e->getMessage();
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
                    sendConfirmEmailUsername($username);
                } catch(registerException $e){
                    echo "<script>
                            window.onload = function() {
                              $('#registerModal').show();
                            }
                          </script>";
                    $genericErr = $e->getMessage();
                }
        }
    }
//    // Trying to login
//    if ($_SERVER["REQUEST_METHOD"] == "POST") {
//        try{
//            $uname = ($_POST["uname"]);
//            validateLogin($_POST["uname"], $_POST["psw"]);
//        } catch(loginException $e) {
//            $loginErr = $e->getMessage();
//        }
//    }

/* This view adds login view */
include("../views/login-view.php");
?>
</body>
</html>

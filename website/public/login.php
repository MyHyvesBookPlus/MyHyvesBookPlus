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
    $user = $psw = $remember ="";
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
                include("register.php");
        }
    }
/* This view adds login view */
include("../views/login-view.php");
?>
</body>
</html>

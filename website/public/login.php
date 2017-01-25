<!DOCTYPE html>
<html>
<?php
    include("../views/login_head.php");
    require_once("../queries/connect.php");
    include_once("../queries/login.php");
    include_once("../queries/checkInput.php");
    include_once("../queries/emailconfirm.php");
    include_once("../queries/requestpassword.php");
?>
<body>
<?php
    session_start();

    if(isset($_SESSION["userID"])){
      echo "<script>
                window.onload=checkLoggedIn();
            </script>";
    }

    // Define variables and set to empty values
    $uname = $psw ="";
    $loginErr = $resetErr ="";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        switch ($_POST["submit"]) {
            case "login":
                try {
                    $uname = ($_POST["uname"]);
                    validateLogin($_POST["uname"], $_POST["psw"]);
                } catch(loginException $e) {
                    $loginErr = $e->getMessage();
                }
                break;
            case "reset":
                try {
//                    validateEmail($_POST["forgotEmail"]);
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

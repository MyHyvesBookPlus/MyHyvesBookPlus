<!DOCTYPE html>
<html>
<?php
    include("../views/login_head.php");
    require_once("../queries/connect.php");
    include_once("../queries/login.php");
    include_once("../queries/checkInput.php");
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
    $loginErr ="";

    // Trying to login
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try{
            $uname = strtolower(test_input($_POST["uname"]));
            validateLogin($_POST["uname"], $_POST["psw"]);
        } catch(loginException $e) {
            $loginErr = $e->getMessage();
        }
    }

/* This view adds login view */
include("../views/login-view.php");
?>
</body>
</html>

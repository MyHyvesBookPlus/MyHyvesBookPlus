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
    require_once("../queries/Facebook/autoload.php");

?>
<body>
<?php
    session_start();

    // Checks if there's an user already logged in
    if(isset($_SESSION["userID"])){
      echo "<script>
                window.onload=checkLoggedIn();
            </script>";
    }
include("../views/homeLoginRegister.php");

/* This view adds login view */
include("../views/login-view.php");
?>
</body>
</html>

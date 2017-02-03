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

include("../views/homeLoginRegister.php");

/* This view adds login view */
include("../views/login-view.php");
?>
<script src="js/loginRegisterModals.js"></script>;
</body>
</html>

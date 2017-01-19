<!DOCTYPE html>
<html>
<?php
    include("../views/login_head.php");
    require_once("../queries/connect.php");
    include_once("../queries/login.php");
?>
<body>
<?php
    session_start();
    unset($_SESSION["userID"]);
    header("Location: login.php");
?>
</body>
</html>

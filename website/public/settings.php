<!DOCTYPE html>
<html>
<head>
    <?php
    include("../views/head.php");
    $_SESSION["userID"] = 2;
    include_once("../queries/connect.php");
    include_once("../queries/settings.php");
    ?>
    <style>
        @import url("styles/settings.css");
    </style>
</head>
<body>
<?php

include("../views/main.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    switch ($_POST["form"]) {
        case "profile":
            $result = updateSettings();
            break;
        case "password":
            $result = updatePassword();
            break;
        case "email":
            break;
        case "picture":
            break;
    }
}

include("../views/settings-view.php");

include("../views/footer.php");

?>
</body>
</html>

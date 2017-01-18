<!DOCTYPE html>
<html>
<head>
    <?php
    include("../views/head.php");
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
            $result = array (
                "type" => "settings-message-angry",
                "message" => "Deze functie werkt nog niet :("
            );
            break;
        case "picture":
            $result = array (
                "type" => "settings-message-angry",
                "message" => "Deze functie werkt nog niet :("
            );
            break;
    }
}

include("../views/settings-view.php");

include("../views/footer.php");

?>
</body>
</html>

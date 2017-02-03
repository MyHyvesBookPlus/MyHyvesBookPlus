<!DOCTYPE html>
<html>
<head>
    <?php
    include_once("../views/head.php");
    include_once("../queries/connect.php");
    include_once("../queries/settings.php");
    ?>
    <style>
        @import url("styles/settings.css");
    </style>
</head>
<body>
<?php
$alertClass;
$alertMessage;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        switch ($_POST["form"]) {
            case "profile":
                checkUpdateSettings();
                break;
            case "password":
                changePassword();
                break;
            case "email":
                changeEmail();
                break;
            case "picture":
                updateAvatar();
                break;

        }
    } catch (AlertMessage $w) {
        $alertClass = $w->getClass();
        $alertMessage = $w->getMessage();
    }
}
include("../views/main.php");

include("../views/settings-view.php");

include("../views/footer.php");

?>
</body>
</html>

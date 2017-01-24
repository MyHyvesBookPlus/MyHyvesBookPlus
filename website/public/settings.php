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
$notImplemented = new SettingsMessage("angry", "Deze functie werkt nog niet :(");
$alertClass;
$alertMessage;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        switch ($_POST["form"]) {
            case "profile":
                $result = updateSettings();
                break;
            case "password":
                $result = changePassword();
                break;
            case "email":
                $result = changeEmail();
                break;
            case "picture":
                updateAvatar();
                $result = new SettingsMessage("happy", "Deze melding doet nog niks nuttigs.");
                break;

        }
    } catch (SettingsWarning $w) {
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

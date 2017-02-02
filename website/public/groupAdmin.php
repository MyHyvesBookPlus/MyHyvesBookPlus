<?php
require_once "../queries/picture.php";
require_once "../queries/groupAdmin.php";
require_once "../queries/alerts.php";
?>
<!DOCTYPE html>
<html>
<head>
    <?php include("../views/head.php"); ?>
<style>
    /*Insert own stylesheet here ;)*/
    @import url("styles/settings.css");
</style>
</head>
<body>
<?php
/*
 * This view adds the main layout over the screen.
 * Header and menu.
 */
include("../views/main.php");
$alertClass;
$alertMessage;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        switch ($_POST["form"]) {
            case "group":
                updateGroupSettings($_POST["groupID"]);
                break;
            case "picture":
                if (checkGroupAdmin($_POST["groupID"], $_SESSION["userID"])) {
                    updateAvatar($_POST["groupID"]);
                }
                break;
            case "mod":
                if (!array_key_exists("userID", $_POST)) {
                    throw new AngryAlert("Geen gebruiker geselecteerd.");
                }
                upgradeUser($_POST["groupID"], $_POST["userID"], "mod");
                break;
            case "admin":
                if (!array_key_exists("userID", $_POST)) {
                    throw new AngryAlert("Geen gebruiker geselecteerd.");
                }
                upgradeUser($_POST["groupID"], $_POST["userID"], "admin");
                break;
        }
    } catch (AlertMessage $w) {
        $alertClass = $w->getClass();
        $alertMessage = $w->getMessage();
    }
}

/* Add your view files here. */
include("../views/groupAdmin.php");

/* This adds the footer. */
include("../views/footer.php");
?>
</body>
</html>

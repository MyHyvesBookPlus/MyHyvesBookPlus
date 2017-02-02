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
        if ($_POST["form"] == "group") {
            updateGroupSettings($_POST["groupID"]);
        } else if ($_POST["form"] == "picture") {
            if (checkGroupAdmin($_POST["groupID"], $_SESSION["userID"])) {
                updateAvatar($_POST["groupID"]);
            }
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

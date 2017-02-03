<?php
require_once "../queries/createGroup.php";
require_once "../queries/connect.php";
require_once "../queries/alerts.php"?>
<!DOCTYPE html>
<html>
<head>
    <?php include("../views/head.php"); ?>
    <style>
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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        createGroup();
    } catch (AlertMessage $e) {

    }
    $groupname = $_POST["groupName"];
    header("location: group.php?groupname=$groupname");
}
/* Add your view files here. */
include("../views/createGroup.php");

/* This adds the footer. */
include("../views/footer.php");
?>
</body>
</html>

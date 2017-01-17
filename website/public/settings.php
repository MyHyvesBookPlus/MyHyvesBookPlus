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

/* Add your view files here. */
include("../views/settings-view.php");

/* This adds the footer. */
include("../views/footer.php");
?>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <?php include("../views/head.php"); ?>
    <style>
        @import url("styles/adminpanel.css");
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
include("../views/adminpanel.php");

/* This adds the footer. */
include("../views/footer.php");
?>
</body>
</html>

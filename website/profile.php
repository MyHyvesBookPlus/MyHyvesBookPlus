<!DOCTYPE html>
<html>
<head>
    <?php include("views/head.php"); ?>
    <style>
        @import url("styles/profile.css");
    </style>
</head>
<body>
<?php
/*
 * This view adds the main layout over the screen.
 * Header, menu, footer.
 */
include("views/main.php");

/* Add your view files here. */
include("views/profile.php");

/* This adds the footer. */
include("views/footer.php");
?>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <?php
    include_once("../queries/user.php");
    include_once("../queries/group_page.php");
    include("../views/head.php");
    ?>
    <style>
        @import url("styles/search.css");
    </style>

    <script src="js/search.js"></script>
</head>
<body>
<?php
/*
 * This view adds the main layout over the screen.
 * Header and menu.
 */
include("../views/main.php");

/* Add your view files here. */
include("../views/search-view.php");

/* This adds the footer. */
include("../views/footer.php");
?>
</body>
</html>

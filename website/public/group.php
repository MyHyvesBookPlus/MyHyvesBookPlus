<!DOCTYPE html>
<html>
<head>
    <?php include("../views/head.php"); ?>
    <style>
        @import url("styles/profile.css");
        @import url("styles/post-popup.css");
        @import url('https://fonts.googleapis.com/css?family=Anton');
    </style>
</head>
<body>
<?php

include_once("../queries/group_page.php");

if(!$group = selectGroupByName($_GET["groupname"])) {
    header("HTTP/1.0 404 Not Found");
    header("Location: error/404.php");
    die();
}


$members = selectGroupMembers($group["groupID"]);


/*
 * This view adds the main layout over the screen.
 * Header, menu, footer.
 */
include("../views/main.php");

/* Add your view files here. */
include("../views/group.php");

/* This adds the footer. */
include("../views/footer.php");

$masonry_mode = 0;
if ($group["role"] == "mod" OR $group["role"] == "admin") {
    $masonry_mode = 2;
}
?>

<script src="js/masonry.js"></script>
<script src="js/groupButtons.js"></script>
<script src="js/post.js"></script>
<script>
    $(document).ready(function() {
        userID = 0;
        groupID = <?= $group["groupID"] ?>;

        placeGroupButtons();

        masonry(<?= $masonry_mode ?>);
    });
</script>

</body>
</html>

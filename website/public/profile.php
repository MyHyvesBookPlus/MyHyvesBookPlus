<!DOCTYPE html>
<html>
<head>
    <?php include("../views/head.php"); ?>

    <script src="js/masonry.js"></script>
    <script src="js/post.js"></script>
    <style>
        @import url("styles/profile.css");
        @import url("styles/post-popup.css");
        @import url('https://fonts.googleapis.com/css?family=Anton');
    </style>
</head>
<body>
<?php
include_once("../queries/user.php");
include_once("../queries/friendship.php");
include_once("../queries/nicetime.php");
include_once("../queries/post.php");
include_once("../queries/calcAge.php");

if(empty($_GET["username"])) {
    $userID = $_SESSION["userID"];
} else {
    $userID = getUserID($_GET["username"]);
}

$user = selectUser($_SESSION["userID"], $userID);
$profile_friends = selectAllFriends($userID);
$profile_groups = selectAllUserGroups($userID);


if ($userID == $_SESSION["userID"]) {
    $friendship_status = -1;
    $masonry_mode = 1;
} else {
    $friendship_status = $user["friend_status"];
    $masonry_mode = 0;
}

/*
 * This view adds the main layout over the screen.
 * Header, menu, footer.
 */
include("../views/main.php");

/* Add your view files here. */
include("../views/profile.php");

/* This adds the footer. */
include("../views/footer.php");
?>

<script src="js/friendButtons.js"></script>
<script src="js/masonry.js"></script>
<script>
    $(document).ready(function() {
        userID = <?= $userID ?>;
        groupID = 0;
        placeFriendButtons();

        masonry(<?= $masonry_mode ?>);
    });
</script>
</body>
</html>

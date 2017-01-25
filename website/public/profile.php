<!DOCTYPE html>
<html>
<head>
    <?php include("../views/head.php"); ?>
    <script src="/js/masonry.js"></script>
    <style>
        @import url("styles/profile.css");
    </style>
</head>
<body>
<?php
include("../queries/user.php");
include("../queries/friendship.php");
include("../queries/nicetime.php");

if(empty($_GET["username"])) {
    $userID = $_SESSION["userID"];
} else {
    $userID = getUserID($_GET["username"]);
}

$user = selectUser($_SESSION["userID"], $userID);
$profile_friends = selectAllFriends($userID);
$profile_groups = selectAllUserGroups($userID);
$posts = selectAllUserPosts($userID);


if ($userID == $_SESSION["userID"]) {
    $friendship_status = -1;
} else {
    $friendship_status = $user["friend_status"];
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
<script>
    $(document).ready(function() {
        userID = <?= $userID ?>;
        placeFriendButtons();
    });
</script>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <?php include("../views/head.php"); ?>
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
<script src="js/masonry.js"></script>
<script>
    var posts;

    $(document).ready(function() {
        userID = <?= $userID ?>;
        placeFriendButtons();

        masonry();
//        alert("blap");
//        $.post("API/getPosts.php", { usr : userID }, "json")
//            .done(function(data) {
//                posts = JSON.parse(data);
//                alert(posts[0]["content"]);
//            }).fail(function() {
//                alert("failure...");
//        });


    });
</script>
</body>
</html>

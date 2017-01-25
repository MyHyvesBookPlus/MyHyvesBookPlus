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

<script>

</script>
<script>
    $(document).ready(function() {
        userID = <?= $userID ?>;
        placeFriendButtons();
    });

    function placeFriendButtons() {
        $.post("API/getFriendshipStatus.php", { usr: userID })
            .done(function(data) {
                friendshipStatus = data;
                $buttonContainer = $("div.friend-button-container");
                $buttonContainer.children().remove();
                if (friendshipStatus == -1) {
                    return;
                } else if(friendshipStatus == 0) {
                    $buttonContainer.append($("<button class=\"green friend-button\" value=\"request\"><i class=\"fa fa-handshake-o\"></i> Bevriend</button>"));
                } else if(friendshipStatus == 1) {
                    $buttonContainer.append($("<button class=\"red friend-button\" value=\"delete\"><i class=\"fa fa-times\"></i> Verwijder</button>"));
                } else if(friendshipStatus == 2) {
                    $buttonContainer.append($("<button class=\"red friend-button\" value=\"delete\"><i class=\"fa fa-times\"></i> Trek verzoek in</button>"));
                } else if(friendshipStatus == 3) {
                    $buttonContainer.append($("<button class=\"red friend-button\" value=\"delete\"><i class=\"fa fa-times\"></i> Weiger</button>"));
                    $buttonContainer.append($("<button class=\"green friend-button\" value=\"accept\"><i class=\"fa fa-check\"></i> Accepteer</button>"));
                }

                $buttonContainer.children().click(function() {
                    $.post("API/editFriendship.php", { usr: userID, action: this.value })
                        .done(function() {
                            placeFriendButtons();
                        });
                });
            });
    }
</script>
</body>
</html>

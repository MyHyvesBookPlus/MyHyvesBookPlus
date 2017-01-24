<?php
session_start();

require("../../queries/friendship.php");
require("../../queries/user.php");

if(empty($_POST["userID"]) OR empty($_POST["delete"]) AND empty($_POST["accept"]) AND empty($_POST["request"])) {
    echo "Not enough arguments.";
    return;
}

$friendship_status = getFriendshipStatus($_POST["userID"]);
echo "\nfriendshipstatus: $friendship_status";
echo "You: " . $_SESSION["userID"];
echo "other user: " . $_POST["userID"];


if(!empty($_POST["request"]) AND $friendship_status == 0) {
    echo "request";
    requestFriendship($_POST["userID"]);
} else if(!empty($_POST["delete"]) AND in_array($friendship_status, array(1, 2, 3))) {
    echo "delete";
    removeFriendship($_POST["userID"]);
} else if (!empty($_POST["accept"]) AND $friendship_status == 3) {
    echo "accept";
    acceptFriendship($_POST["userID"]);
}

$username = getUsername($_POST["userID"]);

header("Location: profile.php?username=$username");
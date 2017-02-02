<?php

session_start();

require_once("../../queries/connect.php");
require_once("../../queries/private_message.php");
require_once("../../queries/checkInput.php");
require_once("../../queries/friendship.php");
require_once("../../queries/user.php");

// Check if the user is allowed to get the messages.
if (isset($_SESSION["userID"]) &&
    getRoleByID($_SESSION["userID"]) != 'banned') {
    // Check if the users wants new messages or old ones, and give the right one back.
    if (isset($_POST["lastID"]) && $_POST["lastID"] != "") {
        setLastVisited(test_input($_POST["destination"]));
        echo getNewChatMessages(test_input($_POST["lastID"]), test_input($_POST["destination"]));
    } else {
        setLastVisited(test_input($_POST["destination"]));
        echo getOldChatMessages(test_input($_POST["destination"]));
    }
} else {
    header('HTTP/1.0 403 Forbidden');
}
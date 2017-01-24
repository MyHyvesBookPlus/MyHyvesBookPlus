<?php

session_start();

require_once("../../queries/connect.php");
require_once("../../queries/private_message.php");
require_once("../../queries/checkInput.php");
require_once("../../queries/friendship.php");

if (isset($_POST["lastID"]) && $_POST["lastID"] != "") {
    echo getNewChatMessages(test_input($_POST["lastID"]), test_input($_POST["destination"]));
} else {
    echo getOldChatMessages(test_input($_POST["destination"]));
    setLastVisited(test_input($_POST["destination"]));
}
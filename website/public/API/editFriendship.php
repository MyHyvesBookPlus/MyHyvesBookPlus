<?php

session_start();

require_once ("../../queries/friendship.php");

if(empty($_POST["usr"]) OR empty($_POST["action"]) OR !in_array($_POST["action"], array("request", "accept", "delete"))) {
    header('HTTP/1.1 500 Non enough arguments');
}

$friendship_status = getFriendshipStatus($_POST["usr"]);

if($_POST["action"] == "request" AND $friendship_status == 0) {
    if (!requestFriendship($_POST["usr"])) {
        header('HTTP/1.1 500 Query (request) failed');
    }
} else if($_POST["action"] == "delete" AND in_array($friendship_status, array(1, 2, 3))) {
    if (!removeFriendship($_POST["usr"])) {
        header('HTTP/1.1 500 Query (delete) failed');
    }
} else if ($_POST["action"] == "accept" AND $friendship_status == 3) {
    if (!acceptFriendship($_POST["usr"])) {
        header('HTTP/1.1 500 Query (accept) failed');
    }
} else {
    header('HTTP/1.1 500 Not the right friendship status');
}
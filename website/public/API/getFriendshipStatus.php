<?php

session_start();

require_once ("../../queries/connect.php");
require_once ("../../queries/friendship.php");

if(empty($_POST["usr"])) {
    header('HTTP/1.1 500 Non enough arguments');
}

$friendship_status = getFriendshipStatus($_POST["usr"]);

if($friendship_status == -2) {
    header('HTTP/1.1 500 Query failed');
}

echo $friendship_status;
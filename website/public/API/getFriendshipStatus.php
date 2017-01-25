<?php

# -2: Query failed.
# -1: user1 and 2 are the same user
# 0 : no record found
# 1 : confirmed
# 2 : user1 sent request (you)
# 3 : user2 sent request (other)

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
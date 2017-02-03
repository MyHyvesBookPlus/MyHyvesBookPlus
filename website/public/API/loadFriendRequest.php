<?php

session_start();

require_once ("../../queries/connect.php");
require_once ("../../queries/friendship.php");
require_once ("../../queries/user.php");

// Check if the user is allowed to load them.
if (isset($_SESSION["userID"]) &&
    getRoleByID($_SESSION["userID"]) != 'frozen' &&
    getRoleByID($_SESSION["userID"]) != 'banned') {
    echo selectAllFriendRequests();
} else {
    header('HTTP/1.0 403 Forbidden');
}

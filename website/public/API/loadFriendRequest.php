<?php

session_start();

require_once ("../../queries/connect.php");
require_once ("../../queries/friendship.php");
require_once ("../../queries/user.php");

if (isset($_SESSION["userID"]) &&
    getRoleByID($_SESSION["userID"]) != 'frozen' &&
    getRoleByID($_SESSION["userID"]) != 'banned') {
    echo selectAllFriendRequests();
} else {
    echo "[]";
}

<?php

session_start();

require_once ("../../queries/connect.php");
require_once ("../../queries/checkInput.php");
require_once ("../../queries/friendship.php");
require_once("../../queries/user.php");

// Check if the user is allowed to load them.
if (isset($_SESSION["userID"]) &&
    getRoleByID($_SESSION["userID"]) != 'banned') {
    if (isset($_SESSION["userID"])) {
        // Echo the limited or unlimited users.
        if (isset($_POST["limit"])) {
            echo selectLimitedFriends($_SESSION["userID"], (int)test_input($_POST["limit"]));
        } else if (isset($_GET["limit"])) {
            echo selectLimitedFriends($_SESSION["userID"], (int)test_input($_GET["limit"]));
        } else {
            echo selectFriends($_SESSION["userID"]);
        }
    } else {
        echo "[]";
    }
} else {
    header('HTTP/1.0 403 Forbidden');
}


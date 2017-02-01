<?php

session_start();

require_once ("../../queries/connect.php");
require_once ("../../queries/checkInput.php");
require_once ("../../queries/friendship.php");
require_once("../../queries/user.php");

if (isset($_SESSION["userID"]) &&
    getRoleByID($_SESSION["userID"]) != 'banned') {
    if (isset($_SESSION["userID"])) {
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


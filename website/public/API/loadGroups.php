<?php

session_start();

require_once ("../../queries/connect.php");
require_once ("../../queries/checkInput.php");
require_once ("../../queries/group_member.php");

require_once("../../queries/user.php");

// Check if the user is allowed to load them.
if (isset($_SESSION["userID"]) &&
    getRoleByID($_SESSION["userID"]) != 'banned') {
    // Echo the limited or unlimited groups.
    if (isset($_POST["limit"])) {
        echo selectLimitedGroupsFromUser($_SESSION["userID"], (int)test_input($_POST["limit"]));
    } else {
        echo selectAllGroupsFromUser($_SESSION["userID"]);
    }
} else {
    header('HTTP/1.0 403 Forbidden');
}

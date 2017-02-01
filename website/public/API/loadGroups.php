<?php

session_start();

require_once ("../../queries/connect.php");
require_once ("../../queries/checkInput.php");
require_once ("../../queries/group_member.php");

require_once("../../queries/user.php");

if (isset($_SESSION["userID"]) &&
    getRoleByID($_SESSION["userID"]) != 'banned') {
    if (isset($_POST["limit"])) {
        echo selectLimitedGroupsFromUser($_SESSION["userID"], (int)test_input($_POST["limit"]));
    } else {
        echo selectAllGroupsFromUser($_SESSION["userID"]);
    }
} else {
    header('HTTP/1.0 403 Forbidden');
}

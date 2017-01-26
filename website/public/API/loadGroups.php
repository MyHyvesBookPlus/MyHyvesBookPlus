<?php

session_start();

require_once ("../../queries/connect.php");
require_once ("../../queries/checkInput.php");
require_once ("../../queries/group_member.php");

if (isset($_POST["limit"])) {
    echo selectLimitedGroupsFromUser($_SESSION["userID"], (int) test_input($_POST["limit"]));
} else {
    echo selectAllGroupsFromUser($_SESSION["userID"]);
}


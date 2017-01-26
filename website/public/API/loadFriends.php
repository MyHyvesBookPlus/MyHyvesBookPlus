<?php

session_start();

require_once ("../../queries/connect.php");
require_once ("../../queries/checkInput.php");
require_once ("../../queries/friendship.php");

if (isset($_POST["limit"])) {
    echo selectLimitedFriends($_SESSION["userID"], (int) test_input($_POST["limit"]));
} else if (isset($_GET["limit"])) {
    echo selectLimitedFriends($_SESSION["userID"], (int) test_input($_GET["limit"]));
} else {
    echo selectFriends($_SESSION["userID"]);
}


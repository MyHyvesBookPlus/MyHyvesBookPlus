<?php

session_start();

require_once ("../../queries/connect.php");
require_once ("../../queries/checkInput.php");
require_once ("../../queries/friendship.php");
require_once ("../../queries/user.php");

$n = 0;
if (isset($_POST["n"])) {
    $n = (int) test_input($_POST["n"]);
}
$m = 20;
if (isset($_POST["m"])) {
    $m = (int) test_input($_POST["m"]);
}
$search = "";
if (isset($_POST["search"])) {
    $search = test_input($_POST["search"]);
}

if (isset($_POST["filter"]) && $_POST["filter"] == "personal") {
    echo searchSomeFriends($n, $m, $search);
} else {
    echo searchSomeUsers($n, $m, $search);
}

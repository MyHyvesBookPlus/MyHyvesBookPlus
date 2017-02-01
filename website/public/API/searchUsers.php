<?php

session_start();

require_once ("../../queries/connect.php");
require_once ("../../queries/checkInput.php");
require_once ("../../queries/friendship.php");
require_once ("../../queries/user.php");

$n = 0;
$m = 20;

$page = 1;
if (isset($_POST["user-pageselect"])) {
    $page = (int) test_input($_POST['user-pageselect']);
}

$n = ($page - 1) * $m;

$search = "";
if (isset($_POST["search"])) {
    $search = test_input($_POST["search"]);
}

if (isset($_POST["filter"]) && $_POST["filter"] == "personal") {
    echo searchSomeFriends($n, $m, $search);
} else {
    echo searchSomeUsers($n, $m, $search);
}

<?php


session_start();

require_once ("../../queries/connect.php");
require_once ("../../queries/checkInput.php");
require_once ("../../queries/group_member.php");
require_once ("../../queries/group_page.php");
require_once ("../../queries/user.php");

if (isset($_SESSION["userID"]) &&
    getRoleByID($_SESSION["userID"]) != 'banned') {

    $n = 0;
    if (isset($_POST["n"])) {
        $n = (int)test_input($_POST["n"]);
    }
    $m = 20;
    if (isset($_POST["m"])) {
        $m = (int)test_input($_POST["m"]);
    }
    $search = "";
    if (isset($_POST["search"])) {
        $search = test_input($_POST["search"]);
    }

    if (isset($_POST["filter"]) && $_POST["filter"] == "personal") {
        echo searchSomeOwnGroups($n, $m, $search);
    } else {
        echo searchSomeGroups($n, $m, $search);
    }
} else {
    header('HTTP/1.0 403 Forbidden');
}
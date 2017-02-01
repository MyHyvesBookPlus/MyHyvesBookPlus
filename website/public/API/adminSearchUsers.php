<?php

session_start();

require_once ("../../queries/connect.php");
require_once ("../../queries/checkInput.php");
require_once ("../../queries/user.php");
require_once ("../../queries/group_page.php");

if (isset($_SESSION["userID"]) &&
    (getRoleByID($_SESSION["userID"]) == 'admin' ||
     getRoleByID($_SESSION["userID"]) == 'owner')) {
    $offset = 0;
    $entries = 20;
    if (isset($_POST["currentpage"])) {
        $offset = (int)test_input($_POST["currentpage"]) * $entries - $entries;
    }

    $search = "";
    if (isset($_POST["search"])) {
        $search = test_input($_POST["search"]);
    }

    $pagetype = "user";
    if (isset($_POST['pagetype'])) {
        $pagetype = test_input($_POST['pagetype']);
    }

    $status = array();
    if (isset($_POST['status'])) {
        $status = $_POST["status"];
    }

    $groupstatus = array();
    if (isset($_POST['groupstatus'])) {
        $groupstatus = $_POST["groupstatus"];
    }

    $userinfo = getRoleByID($_SESSION['userID']);

    if ($pagetype == "user") {
        include("../../views/adminpanel-table.php");
    } else if ($pagetype == "group") {
        include("../../views/adminpanel-grouptable.php");
    } else {
        echo "Search failed!";
    }
} else {
    header('HTTP/1.0 403 Forbidden');
}
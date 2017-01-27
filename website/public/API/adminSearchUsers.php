<?php

session_start();

require_once ("../../queries/connect.php");
require_once ("../../queries/checkInput.php");
require_once ("../../queries/user.php");
require_once ("../../queries/group_page.php");

$offset = 0;
if (isset($_POST["n"])) {
    $offset = (int) test_input($_POST["n"]);
}
$entries = 20;
if (isset($_POST["m"])) {
    $entries = (int) test_input($_POST["m"]);
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

if ($pagetype == "user") {
    include ("../../views/adminpanel-table.php");
} else if ($pagetype == "group") {
    include ("../../views/adminpanel-grouptable.php");
} else {
    echo "Search failed!";
}

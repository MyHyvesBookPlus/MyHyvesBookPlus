<?php

session_start();

require_once ("../../queries/connect.php");
require_once ("../../queries/checkInput.php");
require_once ("../../queries/user.php");
require_once ("../../queries/group_page.php");

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

$entries = 20;
$currentpage = 1;
if (isset($_POST['currentpage'])) {
    $currentpage = (int) test_input($_POST["currentpage"]);
}

$offset = (int) $currentpage * $entries - $entries;

include ("../../views/adminpanel-page.php");

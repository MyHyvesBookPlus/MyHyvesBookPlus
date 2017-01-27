<?php

session_start();

require_once ("../../queries/connect.php");
require_once ("../../queries/checkInput.php");
require_once ("../../queries/user.php");

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

if ($pagetype == "user") {
    include ("../../views/adminpanel-page.php");
} else {
    echo "Pagenumber failed!";
}

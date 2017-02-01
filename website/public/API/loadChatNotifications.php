<?php

session_start();

require_once ("../../queries/connect.php");
require_once ("../../queries/private_message.php");
require_once("../../queries/user.php");

if (isset($_SESSION["userID"]) &&
    getRoleByID($_SESSION["userID"]) != 'banned') {
    echo selectAllUnreadChat();
} else {
    header('HTTP/1.0 403 Forbidden');
}
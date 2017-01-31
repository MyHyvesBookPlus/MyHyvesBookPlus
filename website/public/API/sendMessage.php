<?php

session_start();
require_once("../../queries/connect.php");
require_once("../../queries/private_message.php");
require_once("../../queries/checkInput.php");
require_once("../../queries/user.php");

if (isset($_SESSION["userID"]) &&
    getRoleByID($_SESSION["userID"]) != 'frozen' &&
    getRoleByID($_SESSION["userID"]) != 'banned') {
    if (!empty(test_input($_POST["destination"])) &&
        !empty(test_input($_POST["content"]))
    ) {
        if (sendMessage(test_input($_POST["destination"]), test_input($_POST["content"]))) {
            echo 1;
        } else {
            echo 0;
        }
    } else {
        echo 0;
    }
} else {
    echo 0;
}
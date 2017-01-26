<?php

session_start();
require_once("../../queries/connect.php");
require_once("../../queries/private_message.php");
require_once("../../queries/checkInput.php");

if (!empty(test_input($_POST["destination"])) &&
    !empty(test_input($_POST["content"]))) {
    if (sendMessage(test_input($_POST["destination"]), test_input($_POST["content"]))) {
        echo 1;
    } else {
        echo 0;
    }
} else {
    echo 0;
}
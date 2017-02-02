<?php

session_start();
require_once("../../queries/connect.php");
require_once("../../queries/private_message.php");
require_once("../../queries/checkInput.php");
require_once("../../queries/user.php");

// Check if the user is allowed to send a message.
if (isset($_SESSION["userID"]) &&
    getRoleByID($_SESSION["userID"]) != 'frozen' &&
    getRoleByID($_SESSION["userID"]) != 'banned') {
    if (!empty(test_input($_POST["destination"])) &&
        !empty(test_input($_POST["content"]))
    ) {
        // Send the message.
        // Returns false when it didn't succeed sending the message.
        if (sendMessage(test_input($_POST["destination"]), test_input($_POST["content"]))) {
            echo 1;
        } else {
            echo 0;
        }
    } else {
        echo 0;
    }
} else {
    echo "frozen";
}
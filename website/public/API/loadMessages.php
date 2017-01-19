<?php

session_start();
require_once("../../queries/connect.php");
require_once("../../queries/private_message.php");

if (isset($_POST["lastID"]) && $_POST["lastID"] != "") {

    echo getNewChatMessages($_POST["lastID"], $_POST["destination"]);

} else {
    echo getOldChatMessages($_POST["destination"]);
}
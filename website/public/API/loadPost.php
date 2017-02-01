<?php

require_once("../../queries/connect.php");
require_once("../../queries/post.php");
require_once("../../queries/checkInput.php");
require_once("../../queries/nicetime.php");

require_once("../../queries/user.php");

if (isset($_SESSION["userID"]) &&
    getRoleByID($_SESSION["userID"]) != 'banned') {
    if (isset($_GET['postID'])) {
        include("../../views/post-view.php");
    } else {
        echo "Kan de post niet laden";
    }
} else {
    header('HTTP/1.0 403 Forbidden');
}
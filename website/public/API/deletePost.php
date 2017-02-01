<?php
session_start();

require_once "../../queries/post.php";
require_once "../../queries/user.php";

if (isset($_SESSION["userID"]) and
    getRoleByID($_SESSION["userID"]) != 'frozen' and
    getRoleByID($_SESSION["userID"]) != 'banned') {

    if (empty($_POST["postID"]) or empty($_SESSION["userID"])) {
        header('HTTP/1.1 500 Non enough arguments');
    }

    deletePost($_POST["postID"], $_SESSION["userID"]);
    return;

} else {
    echo "frozen";
}
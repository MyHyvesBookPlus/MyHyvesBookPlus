<?php

session_start();

require_once("../../queries/post.php");
require_once("../../queries/group_page.php");
require_once("../../queries/connect.php");
require_once("../../queries/checkInput.php");
require_once("../../queries/picture.php");

if (empty($_POST["title"]) or
    empty($_POST["content"]) or
    empty($_SESSION["userID"])) {
    header('HTTP/1.1 500 Non enough arguments');
}

if (empty($_POST["group"])) {
    // User Post
    makePost(
        $_SESSION["userID"],
        test_input($_POST["title"]),
        test_input($_POST["content"])
        );
} else {
    // Group Post

    // Check if the user is an admin or mod of the group.
    if(!in_array(selectGroupRole($_POST["group"]), array('mod', 'admin'))) {
        header('HTTP/1.1 500 Non enough rights');
        return;
    }

    makePost(
        $_SESSION["userID"],
        test_input($_POST["title"]),
        test_input($_POST["content"]),
        $_POST["group"]
    );
}

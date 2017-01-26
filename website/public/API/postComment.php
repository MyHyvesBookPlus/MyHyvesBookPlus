<?php

session_start();

require("../../queries/post.php");
require("../../queries/connect.php");
require("../../queries/checkInput.php");

if (empty($_POST['newcomment-content'])) {
} else {
    makeComment($_POST['postID'],
        $_SESSION['userID'],
        test_input($_POST['newcomment-content']));
}

header("Location: ../profile.php");
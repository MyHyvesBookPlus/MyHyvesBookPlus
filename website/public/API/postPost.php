<?php

session_start();

require("../../queries/post.php");
require("../../queries/connect.php");
require("../../queries/checkInput.php");

if (empty($_POST['newpost-title'])) {
} else {
    makePost($_SESSION['userID'],
             null,
             test_input($_POST['newpost-title']),
             test_input($_POST['newpost-content']));
}

header("Location: ../profile.php");
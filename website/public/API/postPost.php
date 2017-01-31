<?php

session_start();

require_once("../../queries/post.php");
require_once("../../queries/connect.php");
require_once("../../queries/checkInput.php");

if (empty($_POST['newpost-title'])) {
} else {
    makePost($_SESSION['userID'],
             null,
             test_input($_POST['newpost-title']),
             test_input($_POST['newpost-content']));
}

header("Location: ../profile.php");
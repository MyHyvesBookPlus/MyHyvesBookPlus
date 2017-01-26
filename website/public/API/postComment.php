<?php

session_start();

require("../../queries/post.php");
require("../../queries/connect.php");
require("../../queries/checkInput.php");
if ($_POST["button"] == "reaction") {
    if (empty($_POST['newcomment-content'])) {
        echo 0;
    } else {
        if (makeComment($_POST['postID'],
            $_SESSION['userID'],
            test_input($_POST['newcomment-content']))) {
            echo 1;
        } else {
            echo 0;
        }
    }
} elseif ($_POST["button"] == "nietslecht") {
    if (makeNietSlecht($_POST["postID"], $_SESSION["userID"])) {
        echo 1;
    } else {
        echo 0;
    }
} else {
    echo 0;
}
<?php

session_start();

require_once("../../queries/post.php");
require_once("../../queries/connect.php");
require_once("../../queries/checkInput.php");
require_once("../../queries/user.php");


if (isset($_SESSION["userID"]) &&
    getRoleByID($_SESSION["userID"]) != 'frozen' &&
    getRoleByID($_SESSION["userID"]) != 'banned') {
    if ($_POST['button'] == 'reaction') {
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
    } else if ($_POST['button'] == 'nietslecht') {
        if (makeNietSlecht($_POST["postID"], $_SESSION["userID"])) {
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
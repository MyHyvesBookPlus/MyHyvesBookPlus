<?php
session_start();

require_once ("../../queries/connect.php");
require_once ("../../queries/checkInput.php");
require_once ("../../queries/group_page.php");
require_once ("../../queries/user.php");

if (isset($_SESSION["userID"]) &&
    (getRoleByID($_SESSION["userID"]) == 'admin' ||
     getRoleByID($_SESSION["userID"]) == 'owner')) {
    $userinfo = getRoleByID($_SESSION['userID']);

    if (isset($_POST["actions"]) && isset($_POST["userID"])) {
        changeUserStatusByID($_POST["userID"], $_POST["actions"]);
    } else if (isset($_POST["actions"]) && isset($_POST["groupID"])) {
        changeGroupStatusByID($_POST["groupID"], $_POST["actions"]);
    } else if (isset($_POST["batchactions"]) && isset($_POST["checkbox-user"])) {
        if ($userinfo == 'owner') {
            changeMultipleUserStatusByID($_POST["checkbox-user"], $_POST["batchactions"]);
        } else {
            changeMultipleUserStatusByIDAdmin($_POST["checkbox-user"], $_POST["batchactions"]);
        }
    } else if (isset($_POST["groupbatchactions"]) && isset($_POST["checkbox-group"])) {
        changeMultipleGroupStatusByID($_POST["checkbox-group"], $_POST["groupbatchactions"]);
    } else if (isset($_POST['bancommentuserID']) && isset($_POST['bancommenttext'])) {
        editBanCommentByID($_POST['bancommentuserID'], $_POST['bancommenttext']);
    }
} else {
    header('HTTP/1.0 403 Forbidden');
}
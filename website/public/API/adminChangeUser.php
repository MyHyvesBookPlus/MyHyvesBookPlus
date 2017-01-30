<?php
session_start();

require_once ("../../queries/connect.php");
require_once ("../../queries/checkInput.php");
require_once ("../../queries/user.php");
require_once ("../../queries/group_page.php");

if (isset($_POST["actions"]) && isset($_POST["userID"])) {
    changeUserStatusByID($_POST["userID"], $_POST["actions"]);
} else if (isset($_POST["actions"]) && isset($_POST["groupID"])) {
    changeGroupStatusByID($_POST["groupID"], $_POST["actions"]);
} else if (isset($_POST["batchactions"]) && isset($_POST["checkbox-user"])) {
    changeMultipleUserStatusByID($_POST["checkbox-user"], $_POST["batchactions"]);
} else if (isset($_POST["groupbatchactions"]) && isset($_POST["checkbox-group"])) {
    changeMultipleGroupStatusByID($_POST["checkbox-group"], $_POST["groupbatchactions"]);
}

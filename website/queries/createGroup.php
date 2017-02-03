<?php
require_once "../queries/checkInput.php";
require_once "../queries/picture.php";
require_once "../queries/alerts.php";

/**
 * Creates a group.
 */
function createGroup()
{
    // Creates the group.
    $createGroup = prepareQuery("
    INSERT INTO
        `group_page` (`name`, `description`)
    VALUES (:name, :description);
    ");
    $createGroup->bindValue(':name', test_input($_POST["groupName"]), PDO::PARAM_STR);
    $createGroup->bindValue(':description', test_input($_POST["bio"]));
    $createGroup->execute();

    // Gets the groupID just created.
    $getGroupID = prepareQuery("
    SELECT
        `groupID`
    FROM
        `group_page`
    WHERE
        `name` LIKE :name");
    $getGroupID->bindValue(':name', test_input($_POST["groupName"]), PDO::PARAM_STR);
    $getGroupID->execute();
    $groupID = $getGroupID->fetch()["groupID"];

    // Adds the user as an admin.
    $makeUserAdmin = prepareQuery("
    INSERT INTO
        `group_member` (userID, groupID, role)
    VALUES (:userID, :groupID, 'admin')
    ");
    $makeUserAdmin->bindValue(":userID", $_SESSION["userID"]);
    $makeUserAdmin->bindValue("groupID", $groupID);
    $makeUserAdmin->execute();

    updateAvatar($groupID);
}
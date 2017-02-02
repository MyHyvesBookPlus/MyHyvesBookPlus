<?php
function getGroupSettings(int $groupID) {
    $stmt = prepareQuery("
    SELECT
        `name`,
        `picture`,
        `description`
    FROM
        `group_page`
    WHERE
        `groupID` = :groupID
    ");
    $stmt->bindParam(":groupID", $groupID);
    $stmt->execute();
    return $stmt->fetch();
}

function updateGroupSettings(int $groupID)
{
    if (!checkGroupAdmin($groupID, $_SESSION["userID"])) {
        throw new AngryAlert("Je hebt geen rechten in deze groep");
    }
    $stmt = prepareQuery("
    UPDATE
        `group_page`
    SET
      `name` = :name,
      `description` = :bio
    WHERE
      `groupID` = :groupID
    ");
    $stmt->bindValue(":bio", test_input($_POST["bio"]));
    $stmt->bindValue(":name", test_input($_POST["name"]));
    $stmt->bindValue(":groupID", test_input($_POST["groupID"]));
    $stmt->execute();
    if ($stmt->rowCount()) {
        throw new HappyAlert("Groep aangepast!");
    } else {
        throw new AngryAlert("Er is iets mis gegaan");
    }
}

function checkGroupAdmin(int $groupID, int $userID) : bool {
    $stmt = prepareQuery("
    SELECT
        `role`
    FROM
        `group_member`
    WHERE
        `groupID` = :groupID AND 
        `userID` = :userID
    ");
    $stmt->bindValue(":userID", $userID);
    $stmt->bindValue(":groupID", $groupID);
    $stmt->execute();
    if (!$stmt->rowCount()) {
        return false;
    }
    $role = $stmt->fetch()["role"];
    return ($role == "admin");
}
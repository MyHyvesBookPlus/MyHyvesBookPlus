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

function getAllGroupUsers(int $groupID) {
    return getAllGroupMembers($groupID, 'member');
}

function getAllGroupAdmins(int $groupID) {
    return getAllGroupMembers($groupID, 'admin');
}

function getAllGroupMods(int $groupID) {
    return getAllGroupMembers($groupID, 'mod');
}

function getAllGroupMembers(int $groupID, string $role) {
    $stmt = prepareQuery("
        SELECT
          `username`,
          `user`.`userID`,
          CONCAT(`fname`, ' ', `lname`) AS `fullname`,
          `group_member`.`role`
        FROM
          `group_member`
        LEFT JOIN
          `user`
        ON
          `group_member`.`userID` = `user`.`userID`
        WHERE
          `groupID` = :groupID AND `group_member`.`role` = :role
    ");

    $stmt->bindParam(':groupID', $groupID);
    $stmt->bindParam(":role", $role);
    if (!$stmt->execute()) {
        return False;
    }
    return $stmt->fetchAll();
}

function upgradeUser(int $groupID, int $userID, string $role) {
    if (!checkGroupAdmin($groupID, $_SESSION["userID"])) {
        throw new AngryAlert("Geen toestemming om te wijzigen");
    }

    $stmt = prepareQuery("
    UPDATE
        `group_member`
    SET
        `role` = :role
    WHERE 
        `userID` = :userID AND `groupID` = :groupID
    ");
    $stmt->bindValue(":groupID", $groupID);
    $stmt->bindValue(":userID", $userID);
    $stmt->bindValue(":role", $role);
    $stmt->execute();
    if ($stmt->rowCount()) {
        throw new HappyAlert("Permissie aangepast!");
    } else {
        throw new AngryAlert("Er is iets mis gegaan");
    }
}

function deleteGroup() {
    if (!checkGroupAdmin($_POST["groupID"], $_SESSION["userID"])) {
        throw new AngryAlert("Geen toestemming om de groep te verwijderen!");
    }
    $stmt = prepareQuery("
    DELETE FROM
        `group_page`
    WHERE
        `groupID` = :groupID
    ");
    $stmt->bindValue(":groupID", $_POST["groupID"]);
    $stmt->execute();
    if ($stmt->rowCount()) {
        throw new HappyAlert("Group verwijderd!");
    } else {
        throw new AngryAlert("Er is iets mis gegaan");
    }
}
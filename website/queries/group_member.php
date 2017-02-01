<?php

function selectAllGroupsFromUser($userID) {
    selectLimitedGroupsFromUser($userID, 9999);
}

function selectLimitedGroupsFromUser($userID, $limit) {
    $stmt = prepareQuery("
    SELECT
        `group_page`.`name`,
        `group_page`.`picture`
    FROM
        `group_page`
    INNER JOIN
        `group_member`
    WHERE
        `group_member`.`userID` = :userID AND
        `group_member`.`groupID` = `group_page`.`groupID` AND
        `group_page`.`status` != 'hidden'
    LIMIT :limitCount
    ");

    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->bindParam(':limitCount', $limit, PDO::PARAM_INT);
    $stmt->execute();

    return json_encode($stmt->fetchAll());
}

function searchSomeOwnGroups($n, $m, $search) {
    $stmt = prepareQuery("
    SELECT
        `group_page`.`name`,
        `group_page`.`picture`
    FROM
        `group_page`
    INNER JOIN
        `group_member`
    WHERE
        `group_member`.`userID` = :userID AND
        `group_member`.`groupID` = `group_page`.`groupID` AND
        `group_page`.`status` != 'hidden' AND
        `name` LIKE :keyword
    LIMIT
      :n, :m 
    ");

    $search = "%$search%";
    $stmt->bindParam(':keyword', $search);
    $stmt->bindParam(':userID', $_SESSION["userID"], PDO::PARAM_INT);
    $stmt->bindParam(':n', $n, PDO::PARAM_INT);
    $stmt->bindParam(':m', $m, PDO::PARAM_INT);
    $stmt->execute();

    return json_encode($stmt->fetchAll());
}

function addMember($groupID, $userID, $role) {
    $stmt = prepareQuery("
    INSERT INTO
      `group_member` (`userID`, `groupID`, `role`)
    VALUES
      (:userID, :groupID, :role)
    ");

    $stmt->bindParam(':userID', $userID);
    $stmt->bindParam(':groupID', $groupID);
    $stmt->bindParam(':role', $role);
    return $stmt->execute();
}

function changeMember($groupID, $userID, $role) {
    $stmt = prepareQuery("
    UPDATE
      `group_member`
    SET
      `role` = :role
    WHERE
      `userID` = :userID AND
      `groupID` = :groupID
    ");

    $stmt->bindParam(':userID', $userID);
    $stmt->bindParam(':groupID', $groupID);
    $stmt->bindParam(':role', $role);
    return $stmt->execute();
}

function deleteMember($groupID, $userID) {
    $stmt = prepareQuery("
    DELETE FROM
      `group_member`
    WHERE
      `userID` = :userID AND
      `groupID` = :groupID
    ");

    $stmt->bindParam(':userID', $userID);
    $stmt->bindParam(':groupID', $groupID);
    return $stmt->execute();
}
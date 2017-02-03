<?php

/**
 * Returns all groups a user is member of.
 * @param $userID
 * @return string
 */
function selectAllGroupsFromUser($userID) {
    return selectLimitedGroupsFromUser($userID, 9999);
}

/**
 * Selects number of groups that a user is member of.
 * @param $userID
 * @param $limit
 * @return string
 */
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

/**
 * Returns m groups offset by n filtered by search that the current user is part of.
 * @param $n
 * @param $m
 * @param $search
 * @return string
 */
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

/**
 * Counts all groups filtered by search that the current user is member of.
 * @param $search
 * @return string
 */
function countSomeOwnGroups($search) {
    $stmt = prepareQuery("
    SELECT
        COUNT(*)
    FROM
        `group_page`
    INNER JOIN
        `group_member`
    WHERE
        `group_member`.`userID` = :userID AND
        `group_member`.`groupID` = `group_page`.`groupID` AND
        `group_page`.`status` != 'hidden' AND
        `name` LIKE :keyword
    ");

    $search = "%$search%";
    $stmt->bindParam(':keyword', $search);
    $stmt->bindParam(':userID', $_SESSION["userID"], PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchColumn();
}

/**
 * Adds a user by userID to a group by groupID with a specified role.
 * @param $groupID
 * @param $userID
 * @param $role
 * @return bool
 */
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

/**
 * Changes te role of a user within a group to the specified one.
 * @param $groupID
 * @param $userID
 * @param $role
 * @return bool
 */
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

/**
 * Removes a user from a group.
 * @param $groupID
 * @param $userID
 * @return bool
 */
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
<?php

function selectAllGroupsFromUser($userID) {
    selectLimitedGroupsFromUser($userID, 9999);
}

function selectLimitedGroupsFromUser($userID, $limit) {
    $stmt = $GLOBALS["db"]->prepare("
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


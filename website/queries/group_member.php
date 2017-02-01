<?php

function selectAllGroupsFromUser($userID) {
    return selectLimitedGroupsFromUser($userID, 9999);
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

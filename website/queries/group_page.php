<?php

require("connect.php");

function selectGroupByName($name) {
    $stmt = $GLOBALS["db"]->prepare("
        SELECT
          `group_page`.`groupID`,
          `name`,
          `description`,
          `picture`,
          `status`,
          COUNT(`group_member`.`groupID`) as `members`
        FROM
          `group_page`
        LEFT JOIN
          `group_member`
        ON
          `group_page`.`groupID` = `group_member`.`groupID`
        WHERE
          name LIKE :name
    ");

    $stmt->bindParam(':name', $name);
    if (!$stmt->execute()) {
        return False;
    }
    return $stmt->fetch();
}

function selectGroupMembers(int $groupID) {
    $stmt = $GLOBALS["db"]->prepare("
        SELECT
          `username`,
          `fname`,
          `lname`,
          `profilepicture`
        FROM
          `group_member`
        LEFT JOIN
          `user`
        ON
          `group_member`.`userID` = `user`.`userID`
        WHERE
          `groupID` = :groupID
        LIMIT 20
    ");

    $stmt->bindParam(':groupID', $groupID);
    if (!$stmt->execute()) {
        return False;
    }
    return $stmt->fetchAll();
}

function selectGroupById($groupID) {
    $q = $GLOBALS["db"]->prepare("
    SELECT
        `group_page`.`name`,
        `group_page`.`picture`,
        `group_page`.`description`,
        `group_page`.`status`,
        `group_page`.`creationdate`
    FROM
        `group_page`
    WHERE
        `group_page`.`groupID` = :groupID
    ");

    $q->bindParam(':groupID', $groupID);
    $q->execute();
    return $q;
}

function select20GroupsFromN($n) {
    $q = $GLOBALS["db"]->prepare("
    SELECT
        `group_page`.`groupID`,
        `group_page`.`name`,
        `group_page`.`picture`,
        `group_page`.`description`,
        `group_page`.`status`,
        `group_page`.`creationdate`
    FROM
        `group_page`
    ORDER BY
        `group_page`.`name` ASC
    LIMIT
        :n, 20
    ");

    $q->bindParam(':n', $n);
    $q->execute();
    return $q;
}

function select20GroupsByStatusFromN($n, $status) {
    $q = $GLOBALS["db"]->prepare("
    SELECT
        `group_page`.`groupID`,
        `group_page`.`name`,
        `group_page`.`picture`,
        `group_page`.`description`,
        `group_page`.`status`,
        `group_page`.`creationdate`
    FROM
        `group_page`
    WHERE
    	`group_page`.`status` = :status
    ORDER BY
        `group_page`.`name` ASC
    LIMIT
        :n, 20
    ");

    $q->bindParam(':status', $status);
    $q->bindParam(':n', $n);
    $q->execute();
    return $q;
}

function search20GroupsFromNByStatus($n, $keyword, $status) {
    $q = $GLOBALS["db"]->prepare("
    SELECT
        `groupID`,
        `name`,
        `status`,
        `description`
    FROM
        `group_page`
    WHERE
        `name` LIKE :keyword AND
        FIND_IN_SET (`status`, :statuses)
    ORDER BY
        `name`
    LIMIT
        :n, 20
    ");

    $keyword = "%$keyword%";
    $q->bindParam(':keyword', $keyword);
    $q->bindParam(':n', $n, PDO::PARAM_INT);
    $statuses = implode(',', $status);
    $q->bindParam(':statuses', $statuses);
    $q->execute();
    return $q;
}

function searchSomeGroupsByStatus($n, $m, $keyword, $status) {
    $q = $GLOBALS['db']->prepare("
    SELECT
        `groupID`,
        `name`,
        `status`,
        `description`
    FROM
        `group_page`
    WHERE
        `name` LIKE :keyword AND
        FIND_IN_SET (`status`, :statuses)
    ORDER BY
        `name`
    LIMIT
        :n, :m
    ");

    $keyword = "%$keyword%";
    $q->bindParam(':keyword', $keyword);
    $q->bindParam(':n', $n, PDO::PARAM_INT);
    $q->bindParam(':m', $m, PDO::PARAM_INT);
    $statuses = implode(',', $status);
    $q->bindParam(':statuses', $statuses);
    $q->execute();
    return $q;
}

function countSomeGroupsByStatus($keyword, $status) {
    $q = $GLOBALS['db']->prepare("
    SELECT
        COUNT(*)
    FROM
        `group_page`
    WHERE
        `name` LIKE :keyword AND
        FIND_IN_SET (`status`, :statuses)
    ORDER BY
        `name`
    ");

    $keyword = "%$keyword%";
    $q->bindParam(':keyword', $keyword);
    $statuses = implode(',', $status);
    $q->bindParam(':statuses', $statuses);
    $q->execute();
    return $q;
}

function changeGroupStatusByID($id, $status) {
    $q = $GLOBALS["db"]->query("
    UPDATE
        `group_page`
    SET
        `status` = $status
    WHERE
        `groupID` = $id
    ");

    return $q;
}

function changeMultipleGroupStatusByID($ids, $status) {
    $q = $GLOBALS['db']->prepare("
    UPDATE
        `group_page`
    SET
        `status` = :status
    WHERE
        FIND_IN_SET (`groupID`, :ids)
    ");

    $ids = implode(',', $ids);
    $q->bindParam(':ids', $ids);
    $q->bindParam(':status', $status);
    $q->execute();
    return $q;
}

function searchSomeGroups($n, $m, $search) {
    $stmt = $GLOBALS["db"]->prepare("
    SELECT
        `name`,
        `picture`
    FROM
        `group_page`
    WHERE
        `name` LIKE :keyword
    ORDER BY 
        `name`
    LIMIT 
        :n, :m
    ");

    $search = "%$search%";
    $stmt->bindParam(':keyword', $search);
    $stmt->bindParam(':n', $n, PDO::PARAM_INT);
    $stmt->bindParam(':m', $m, PDO::PARAM_INT);
    $stmt->execute();
    return json_encode($stmt->fetchAll());
}

function countSomeGroups($search) {
    $stmt = $GLOBALS["db"]->prepare("
    SELECT
        COUNT(*)
    FROM
        `group_page`
    WHERE
        `name` LIKE :keyword
    ORDER BY 
        `name`
    ");

    $search = "%$search%";
    $stmt->bindParam(':keyword', $search);
    $stmt->execute();
    return $stmt;
}
?>
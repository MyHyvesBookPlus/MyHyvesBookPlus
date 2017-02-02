<?php

require_once("connect.php");

function selectGroupByName($name) {
    $stmt = prepareQuery("
        SELECT
          `group_page`.`groupID`,
          `group_page`.`groupID`,
          `name`,
          `description`,
          `picture`,
          `status`,
          (
            SELECT `role`
            FROM `group_member`
            WHERE `group_member`.`groupID` = `group_page`.`groupID` AND 
                  `userID` = :userID
          ) AS `role`,
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

    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':userID', $_SESSION["userID"], PDO::PARAM_INT);
    if (!$stmt->execute()) {
        return False;
    }
    return $stmt->fetch();
}

function selectGroupRole(int $groupID) {
    $stmt = prepareQuery("
        SELECT
          `role`
        FROM
          `group_member`
        WHERE
          `groupID` = :groupID AND
          `userID` = :userID
    ");

    $stmt->bindParam(':groupID', $groupID, PDO::PARAM_INT);
    $stmt->bindParam(':userID', $_SESSION["userID"], PDO::PARAM_INT);
    if(!$stmt->execute()) {
        return False;
    }
    if($stmt->rowCount() == 0) {
        return "none";
    }
    return $stmt->fetch()["role"];
}

function selectGroupStatus(int $groupID) {
    $stmt = prepareQuery("
        SELECT
          `status`
        FROM
          `group_page`
        WHERE
          `groupID` = :groupID
    ");

    $stmt->bindParam(':groupID', $groupID, PDO::PARAM_INT);
    if(!$stmt->execute()) {
        return False;
    }
    return $stmt->fetch()["status"];
}

function selectGroupMembers(int $groupID) {
    $stmt = prepareQuery("
        SELECT
          `username`,
          `fname`,
          `lname`,
          IFNULL(
                `profilepicture`,
                '../img/avatar-standard.png'
            ) AS profilepicture
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
    $q = prepareQuery("
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
    $q = prepareQuery("
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
    $q = prepareQuery("
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
    $q = prepareQuery("
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

function searchSomeGroupsByStatus($n, $m, $search, $status) {
//    parentheses not needed in where clause, for clarity as
//      role search should override status filter.
    $q = prepareQuery("
    SELECT
        `groupID`,
        `name`,
        `status`,
        `description`
    FROM
        `group_page`
    WHERE
        (`name` LIKE :keyword AND
        FIND_IN_SET (`status`, :statuses)) OR 
        `status` = :search
    ORDER BY
        `name`
    LIMIT
        :n, :m
    ");

    $keyword = "%$search%";
    $q->bindParam(':keyword', $keyword);
    $q->bindParam(':search', $search);
    $q->bindParam(':n', $n, PDO::PARAM_INT);
    $q->bindParam(':m', $m, PDO::PARAM_INT);
    $statuses = implode(',', $status);
    $q->bindParam(':statuses', $statuses);
    $q->execute();
    return $q;
}

function countSomeGroupsByStatus($search, $status) {
    $q = prepareQuery("
    SELECT
        COUNT(*)
    FROM
        `group_page`
    WHERE
        (`name` LIKE :keyword AND
        FIND_IN_SET (`status`, :statuses)) OR 
        `status` = :search
    ORDER BY
        `name`
    ");

    $keyword = "%$search%";
    $q->bindParam(':keyword', $keyword);
    $q->bindParam(':search', $search);
    $statuses = implode(',', $status);
    $q->bindParam(':statuses', $statuses);
    $q->execute();
    return $q;
}

function changeGroupStatusByID($id, $status) {
    $q = prepareQuery("
    UPDATE
        `group_page`
    SET
        `status` = :status
    WHERE
        `groupID` = :id
    ");

    $q->bindParam(':status', $status);
    $q->bindParam(':id', $id);
    $q->execute();
    return $q;
}

function changeMultipleGroupStatusByID($ids, $status) {
    $q = prepareQuery("
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
    $stmt = prepareQuery("
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
    $stmt = prepareQuery("
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
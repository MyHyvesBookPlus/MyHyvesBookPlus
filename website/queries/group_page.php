<?php

function selectGroupById($db, $groupID) {
    return $db->query("
    SELECT
        `group_page`.`name`,
        `group_page`.`picture`,
        `group_page`.`description`,
        `group_page`.`status`,
        `group_page`.`creationdate`
    FROM
        `group_page`
    WHERE
        `group_page`.`groupID` = $groupID
    ");
}

function select20GroupsFromN($db, $n) {
    return $db->query("
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
        $n, 20
    ");
}

function select20GroupsByStatusFromN($db, $n, $status) {
    return $db->query("
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
    	`group_page`.`status` = $status
    ORDER BY
        `group_page`.`name` ASC
    LIMIT
        $n, 20
    ");
}

function search20GroupsFromNByStatus($db, $n, $keyword, $status) {
    $q = $db->prepare("
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

function searchSomeGroupsByStatus($db, $n, $m, $keyword, $status) {
    $q = $db->prepare("
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

function countSomeGroupsByStatus($db, $keyword, $status) {
    $q = $db->prepare("
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

function changeGroupStatusByID($db, $id, $status) {
    $q = $db->query("
    UPDATE
        `group_page`
    SET
        `status` = $status
    WHERE
        `groupID` = $id
    ");

    return $q;
}


function changeMultipleGroupStatusByID($db, $ids, $status) {
    $q = $db->prepare("
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


?>

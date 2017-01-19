<?php

function selectGroupById($groupID) {
    return $GLOBALS["db"]->query("
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

function select20GroupsFromN($n) {
    return $GLOBALS["db"]->query("
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

function select20GroupsByStatusFromN($n, $status) {
    return $GLOBALS["db"]->query("
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

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

?>
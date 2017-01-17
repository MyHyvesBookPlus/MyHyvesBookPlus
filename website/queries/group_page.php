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
        `group_page`.`name`,
        `group_page`.`picture`,
        `group_page`.`description`,
        `group_page`.`status`,
        `group_page`.`creationdate`
    FROM
        `group_page`
    LIMIT
        $n, 20
    ORDER BY
        `group_page`.`name`
    ");
}

function select20GroupsByStatusFromN($db, $n, $status) {
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
    	`group_page`.`status` = 1
    ORDER BY
        `group_page`.`name` ASC
    LIMIT
        0, 3
    ");
}

?>
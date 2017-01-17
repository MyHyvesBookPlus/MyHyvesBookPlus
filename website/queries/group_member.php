<?php

function selectAllGroupsFromUser($db, $userID) {
    return $db->query("
    SELECT
        `group_page`.`name`,
        `group_page`.`picture`
    FROM
        `group_page`
    INNER JOIN
        `group_member`
    WHERE
        `group_member`.`userID` = $userID AND
        `group_member`.`groupID` = `group_page`.`groupID` AND
        `group_page`.`status` != 0
    ");
}



?>
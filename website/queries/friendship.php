<?php

function selectAllFriends($db, $userID) {
    return $db->query("
    SELECT
        `user`.`userID`,
        `user`.`username`,
        `user`.`profilepicture`,
        `user`.`onlinestatus`,
        `user`.`role`
    FROM
        `user`    
    INNER JOIN
        `friendship`
    WHERE
        `friendship`.`user1ID` = $userID AND
        `friendship`.`user2ID` = `user`.`userID` OR
        `friendship`.`user2ID` = $userID AND
        `friendship`.`user1ID` = `user`.`userID` AND
        `user`.`role` != 3
    ");
}



?>
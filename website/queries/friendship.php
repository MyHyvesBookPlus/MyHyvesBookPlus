<?php
require("connect.php");

function selectAllFriends($db, $userID) {
    $stmt = $db->prepare("
        SELECT
            `username`,
            IFNULL(
                `profilepicture`,
                'img/notbad.png'
            ) AS profilepicture,
            `onlinestatus`,
            `role`
        FROM
            `user`
        INNER JOIN
            `friendship`
        WHERE
            (`friendship`.`user1ID` = :userID AND
            `friendship`.`user2ID` = `user`.`userID` OR 
            `friendship`.`user2ID` = :userID AND
            `friendship`.`user1ID` = `user`.`userID`) AND
            `role` != 5 AND
            `status` = 1
    ");

    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt;
}
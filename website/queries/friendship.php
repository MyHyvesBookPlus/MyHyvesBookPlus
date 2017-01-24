<?php

function selectAllFriends($userID) {
    $stmt = $GLOBALS["db"]->prepare("
        SELECT
            `userID`,
            `username`,
            IFNULL(
                `profilepicture`,
                '../img/avatar-standard.png'
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
            `user`.`role` != 'banned' AND
            `friendship`.`status` = 'confirmed'
    ");

    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt;
}

function selectAllFriendRequests() {
    $stmt = $GLOBALS["db"]->prepare("
        SELECT
            `userID`,
            `username`,
            IFNULL(
                `profilepicture`,
                '../img/avatar-standard.png'
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
            `user`.`role` != 5 AND
            `friendship`.`status` = 'requested'
    ");

    $stmt->bindParam(':userID', $_SESSION["userID"], PDO::PARAM_INT);
    $stmt->execute();

    return json_encode($stmt->fetchAll());
}
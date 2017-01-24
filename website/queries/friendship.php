<?php

function selectAllFriends($userID) {
    $stmt = $GLOBALS["db"]->prepare("
        SELECT
            `userID`,
            `username`,
            LEFT(CONCAT(`user`.`fname`, ' ', `user`.`lname`), 20) as `name`,
            IFNULL(
                `profilepicture`,
                '../img/notbad.jpg'
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
            LEFT(CONCAT(`user`.`fname`, ' ', `user`.`lname`), 20) as `name`,
            IFNULL(
                `profilepicture`,
                '../img/notbad.jpg'
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


function setLastVisited($friend) {
    $stmt = $GLOBALS["db"]->prepare("
        UPDATE
          `friendship`
        SET `friendship`.chatLastVisted1=(
            CASE `user1ID` = :sessionUser
                WHEN TRUE THEN NOW()
                WHEN FALSE THEN `chatLastVisted1`
            END
        ),
          `friendship`.`chatLastVisted2`=(
            CASE `user2ID` = :sessionUser
                WHEN TRUE THEN NOW()
                WHEN FALSE THEN `chatLastVisted2`
            END
        )
        WHERE
        `user1ID` = :sessionUser AND
        `user2ID` = :friend OR
        `user2ID` = :sessionUser AND
        `user1ID` = :friend;
    ");

    $stmt->bindParam(':sessionUser', $_SESSION["userID"], PDO::PARAM_INT);
    $stmt->bindParam(':friend', $friend, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt;
}
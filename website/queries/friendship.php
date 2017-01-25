<?php

require("connect.php");

function selectAllFriends($userID) {
    $stmt = $GLOBALS["db"]->prepare("
        SELECT
            `userID`,
            `username`,
            LEFT(CONCAT(`user`.`fname`, ' ', `user`.`lname`), 15) as `name`,
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
            CASE `status` IS NULL
              WHEN TRUE THEN 0
              WHEN FALSE THEN
                CASE `status` = 'confirmed'
                WHEN TRUE THEN
                  1
                WHEN FALSE THEN
                  CASE `user1ID` = :userID
                  WHEN TRUE THEN
                    2
                  WHEN FALSE THEN
                    3
                  END
                END
            END AS `friend_state`,
            LEFT(CONCAT(`user`.`fname`, ' ', `user`.`lname`), 15) as `name`,
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

function getFriendshipStatus($userID) {
    $stmt = $GLOBALS["db"]->prepare("
    SELECT
      CASE `status` IS NULL
      WHEN TRUE THEN 0
      WHEN FALSE THEN
        CASE `status` = 'confirmed'
        WHEN TRUE THEN
          1
        WHEN FALSE THEN
          CASE `user1ID` = :me AND `user2ID` = :other
          WHEN TRUE THEN
            2
          WHEN FALSE THEN
            3
          END
        END
      END AS `friend_state`
    FROM
      `friendship`
    WHERE
      `user1ID` = :other AND `user2ID` = :me OR
      `user1ID` = :me AND `user2ID` = :other
    ");

    $stmt->bindParam(':me', $_SESSION["userID"], PDO::PARAM_INT);
    $stmt->bindParam(':other', $userID, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch()["friend_state"];
}

function requestFriendship($userID) {
    $stmt = $GLOBALS["db"]->prepare("
        INSERT INTO `friendship` (user1ID, user2ID)
        VALUES (:user1, :user2)
    ");

    $stmt->bindParam(':user1', $_SESSION["userID"], PDO::PARAM_INT);
    $stmt->bindParam(':user2', $userID, PDO::PARAM_INT);
    $stmt->execute();
}

function removeFriendship($userID) {
    $stmt = $GLOBALS["db"]->prepare("
        DELETE FROM `friendship`
        WHERE
          `user1ID` = :user1 AND
          `user2ID` = :user2 OR
          `user1ID` = :user2 AND
          `user2ID` = :user1
    ");

    $stmt->bindParam(':user1', $_SESSION["userID"], PDO::PARAM_INT);
    $stmt->bindParam(':user2', $userID, PDO::PARAM_INT);
    $stmt->execute();
}

function acceptFriendship($userID) {
    $stmt = $GLOBALS["db"]->prepare("
        UPDATE `friendship`
        SET `status`='confirmed'
        WHERE 
          `user1ID` = :user1 AND
          `user2ID` = :user2
        LIMIT 1
    ");

    $stmt->bindParam(':user1', $userID, PDO::PARAM_INT);
    $stmt->bindParam(':user2', $_SESSION["userID"], PDO::PARAM_INT);
    $stmt->execute();
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
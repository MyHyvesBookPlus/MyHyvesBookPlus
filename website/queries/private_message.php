<?php

function getOldChatMessages($user2ID) {
    require_once ("friendship.php");
    $user1ID = $_SESSION["userID"];
    if (getFriendshipStatus($user2ID) == 1) {
        $stmt = prepareQuery("
        SELECT
            *
        FROM
            `private_message`
        WHERE
            `origin` = :user1 AND 
            `destination` = :user2 OR 
            `origin` = :user2 AND
            `destination` = :user1
        ORDER BY
            `messageID` ASC
        ");

        $stmt->bindParam(":user1", $user1ID);
        $stmt->bindParam(":user2", $user2ID);

        $stmt->execute();

        return json_encode($stmt->fetchAll());
    } else {
        return "[]";
    }
}

function sendMessage($destination, $content) {
    require_once("friendship.php");
    if (getFriendshipStatus($destination) == 1) {
        $stmt = prepareQuery("
        INSERT INTO
            `private_message`
        (
            `origin`,
            `destination`,
            `content`
        )
        VALUES
        (
            :origin,
            :destination,
            :content
        )
        ");

        return $stmt->execute(array(
            "origin" => $_SESSION["userID"],
            "destination" => $destination,
            "content" => $content
        ));
    } else {
        return false;
    }
}

function getNewChatMessages($lastID, $destination) {
    require_once("friendship.php");
    if (getFriendshipStatus($destination) == 1) {
        $stmt = prepareQuery("
        SELECT
            *
        FROM
            `private_message`
        WHERE
            (
            `origin` = :user1 AND 
            `destination` = :user2 OR 
            `origin` = :user2 AND
            `destination` = :user1) AND
            `messageID` > :lastID
        ORDER BY
            `messageID` ASC
        ");

        $stmt->bindParam(':user1', $_SESSION["userID"]);
        $stmt->bindParam(':user2', $destination);
        $stmt->bindParam(':lastID', $lastID);

        $stmt->execute();

        return json_encode($stmt->fetchAll());
    } else {
        return "[]";
    }
}


function selectAllUnreadChat() {
    $stmt = prepareQuery("
    SELECT
      LEFT(CONCAT(`user`.`fname`, ' ', `user`.`lname`), 15) AS `fullname`,
      `user`.`userID`,
      IFNULL(
          `profilepicture`,
          '../img/avatar-standard.png'
      ) AS profilepicture,
      LEFT(`private_message`.`content`, 15) AS `content`
    FROM
      `private_message`,
      `friendship`,
      `user`
    WHERE
      (`friendship`.user2ID = `private_message`.`origin` AND
       `friendship`.user1ID = `private_message`.`destination` AND
       (`friendship`.chatLastVisted1 < `private_message`.`creationdate` OR
       `friendship`.chatLastVisted1 IS NULL) OR
       `friendship`.user1ID = `private_message`.`origin` AND
       `friendship`.user2ID = `private_message`.`destination` AND
       (`friendship`.chatLastVisted2 < `private_message`.`creationdate` OR
       `friendship`.chatLastVisted2 IS NULL)) AND
      `private_message`.`origin` = `user`.`userID` AND
      `private_message`.`destination` = :userID AND
      `user`.`role` != 'banned' AND
      `friendship`.`status` = 'confirmed'
    
    GROUP BY `user`.`userID`

    ");

    $stmt->bindParam(':userID', $_SESSION["userID"]);

    $stmt->execute();

    return json_encode($stmt->fetchAll());
}
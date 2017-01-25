<?php

function getOldChatMessages($user2ID) {
    $user1ID = $_SESSION["userID"];

    $stmt = $GLOBALS["db"]->prepare("
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
}

function sendMessage($destination, $content) {
    $stmt = $GLOBALS["db"]->prepare("
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
}

function getNewChatMessages($lastID, $destination) {
    $stmt = $GLOBALS["db"]->prepare("
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
}


function selectAllUnreadChat() {
    $stmt = $GLOBALS["db"]->prepare("
    SELECT
      LEFT(CONCAT(`user`.`fname`, ' ', `user`.`lname`), 15) as `name`,
      `user`.`userID`,
      IFNULL(
        `profilepicture`,
        '../img/notbad.jpg'
      ) AS profilepicture,
      LEFT(`private_message`.`content`, 15) as `content`
    FROM
      `private_message`,
      `friendship`,
      `user`
    WHERE
      (`friendship`.user2ID = `private_message`.`origin` AND
       `friendship`.user1ID = `private_message`.`destination` AND
       `friendship`.chatLastVisted1 < `private_message`.`creationdate` OR
       `friendship`.user1ID = `private_message`.`origin` AND
      `friendship`.user2ID = `private_message`.`destination` AND
       `friendship`.chatLastVisted2 < `private_message`.`creationdate`) AND
      `private_message`.`origin` = `user`.`userID` AND
      `private_message`.`destination` = :userID AND
      `user`.`role` != 'banned'
    
    GROUP BY `user`.`userID`
    ");

    $stmt->bindParam(':userID', $_SESSION["userID"]);

    $stmt->execute();

    return json_encode($stmt->fetchAll());
}
<?php

include_once("connect.php");

session_start();

function getOldChatMessages($user2ID) {
    $db = $GLOBALS["db"];
    $user1ID = $_SESSION["userID"];

    $stmt = $db->prepare("
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
    $db = $GLOBALS["db"];
    $stmt = $db->prepare("
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
    $db = $GLOBALS["db"];
    $origin = $_SESSION["userID"];

    $stmt = $db->prepare("
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

    $stmt->bindParam(':user1', $origin);
    $stmt->bindParam(':user2', $destination);
    $stmt->bindParam(':lastID', $lastID);

    $stmt->execute();

    return json_encode($stmt->fetchAll());
}
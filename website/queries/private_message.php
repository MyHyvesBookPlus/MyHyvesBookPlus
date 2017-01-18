<?php

function get100ChatMessagesFromN($n, $user1ID, $user2ID) {
    $db = $GLOBALS["db"];
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
        `creationdate` DESC 
    LIMIT 
        :n, 100
    ");

    $stmt->bindParam(":user1", $user1ID);
    $stmt->bindParam(":user2", $user2ID);
    $stmt->bindParam(":n", $n);

    return $stmt->execute();
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
        "origin" => 2,
        "destination" => $destination,
        "content" => $content
    ));
}
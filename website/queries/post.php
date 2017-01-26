<?php

function selectPostById($postID) {
    $stmt = $GLOBALS["db"]->prepare("
        SELECT
            `user`.`fname`,
            `user`.`lname`,
            `user`.`username`,
            `post`.`groupID`,
            `post`.`title`,
            `post`.`content`,
            `post`.`creationdate`
        FROM
            `post`
        INNER JOIN
            `user`
        ON
            `post`.`author` = `user`. `userID`
        WHERE
            `post`.`postID` = :postID
    ");

    $stmt->bindParam(':postID', $postID);
    $stmt->execute();
    return $stmt;
}

function selectCommentsByPostId($postID) {
    $stmt = $GLOBALS["db"]->prepare("
        SELECT
            `comment`.`commentID`,
            `comment`.`postID`,
            `comment`.`author`,
            `comment`.`content`,
            `comment`.`creationdate`,
            `user`.`fname`,
            `user`.`lname`,
            `user`.`username`
        FROM
            `comment`
        INNER JOIN
            `user`
        ON
            `comment`.`author` = `user`.`userID`
        WHERE
            `comment`.`postID` = :postID
    ");

    $stmt->bindParam(':postID', $postID);
    $stmt->execute();
    return $stmt;
}

function makePost($userID, $groupID, $title, $content) {
    $stmt = $GLOBALS["db"]->prepare("
        INSERT INTO
            `post` (
                `author`,
                `groupID`,
                `title`,
                `content`
            )
            VALUES (
                :userID,
                :groupID,
                :title,
                :content
            )
    ");

    $stmt->bindParam(':userID', $userID);
    $stmt->bindParam(':groupID', $groupID);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':content', $content);
    $stmt->execute();
}

function makeComment($postID, $userID, $content) : int {
    $stmt = $GLOBALS["db"]->prepare("
        INSERT INTO
            `comment` (
                `postID`, 
                `author`, 
                `content`
            ) 
            VALUES (
                :postID,
                :userID,
                :content
            )
    ");

    $stmt->bindParam(':postID', $postID);
    $stmt->bindParam(':userID', $userID);
    $stmt->bindParam(':content', $content);
    $stmt->execute();
    return $stmt->rowCount();
}

function makeNietSlecht(int $postID, int $userID) : int {
    if (checkNietSlecht($postID, $userID)) {
        return deleteNietSlecht(postID, $userID);
    } else {
        return addNietSlecht($postID, $userID);
    }
}

function checkNietSlecht(int $postID, int $userID) {
    $stmt = $GLOBALS["db"]->prepare("
    SELECT
        *
    FROM
        `niet_slecht`
    WHERE
        `userID` = :userID AND 
        `postID` = :postID
    ");
    $stmt->bindParam(":userID", $userID);
    $stmt->bindParam(":postID", $postID);
    $stmt->execute();
    return $stmt->rowCount();
}

function addNietSlecht(int $postID, int $userID) {
    $stmt = $GLOBALS["db"]->prepare("
    INSERT INTO
        `niet_slecht` (`userID`, `postID`)
        VALUES (:userID, :postID)
    ");
    $stmt->bindParam(":userID", $userID);
    $stmt->bindParam(":postID", $postID);
    $stmt->execute();
    return $stmt->rowCount();
}

function deleteNietSlecht(int $postID, int $userID) {
    $stmt = $GLOBALS["db"]->prepare("
    DELETE FROM
        `niet_slecht`
    WHERE
        `userID` = :userID AND 
        `postID` = :postID
    ");
    $stmt->bindParam(":userID", $userID);
    $stmt->bindParam(":postID", $postID);
    $stmt->execute();
    return $stmt->rowCount();
}

<?php

require_once("connect.php");

function selectAllPosts($userID, $groupID) {
    $stmt = prepareQuery("
        SELECT
          `post`.`postID`,
          `post`.`author`,
          `title`,
          CASE LENGTH(`post`.`content`) >= 150 AND `post`.`content` NOT LIKE '<img%'
          WHEN TRUE THEN
            CONCAT(LEFT(`post`.`content`, 150), '...')
          WHEN FALSE THEN
            `post`.`content`
          END
                                        AS `content`,
          `post`.`creationdate`,
          COUNT(DISTINCT `commentID`) AS `comments`,
          COUNT(DISTINCT `niet_slecht`.`postID`) AS `niet_slechts`
        FROM
          `post`
          LEFT JOIN
          `niet_slecht`
            ON
              `post`.`postID` = `niet_slecht`.`postID`
          LEFT JOIN
          `comment`
            ON
              `post`.`postID` = `comment`.`postID`
        WHERE
          `post`.`author` = :userID AND
          `groupID` IS NULL OR
          `groupID` = :groupID
        GROUP BY
          `post`.`postID`
        ORDER BY
          `post`.`creationdate` DESC
    ");
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->bindParam(':groupID', $groupID , PDO::PARAM_INT);
    if(!$stmt->execute()) {
        return False;
    }
    return $stmt;

}

function selectPostById($postID) {
    $stmt = prepareQuery("
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
    $stmt = prepareQuery("
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

function makePost($userID, $title, $content, $groupID = null) {
    $picturePath = null;
    print_r($_FILES);
    if (array_key_exists("picture", $_FILES)) {
        $picturePath = uploadPostPicture($userID);
    }
    echo "Hallo!";
    $stmt = prepareQuery("
        INSERT INTO
            `post` (
                `author`,
                `groupID`,
                `title`,
                `content`,
                `image`
            )
            VALUES (
                :userID,
                :groupID,
                :title,
                :content,
                :image
            )
    ");

    $stmt->bindParam(':userID', $userID);
    $stmt->bindParam(':groupID', $groupID);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':content', $content);
    $stmt->bindParam(':image', $picturePath);
    $stmt->execute();
}

function makeComment($postID, $userID, $content) : int {
    $stmt = prepareQuery("
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
        return deleteNietSlecht($postID, $userID);
    } else {
        return addNietSlecht($postID, $userID);
    }
}

function checkNietSlecht(int $postID, int $userID) {
    $stmt = prepareQuery("
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
    $stmt = prepareQuery("
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
    $stmt = prepareQuery("
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

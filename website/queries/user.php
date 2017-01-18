<?php
require("connect.php");

function getUserID($db, $username) {
    $stmt = $db->prepare("
        SELECT
            `userID`
        FROM
            `user`
        WHERE
            LOWER(`username`) = LOWER(:username)
    ");

    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch()["userID"];
}

function selectUser($db, $userID) {
    $stmt = $db->prepare("
        SELECT
            `username`,
            IFNULL(
                `profilepicture`,
                'img/notbad.png'
            ) AS profilepicture,
            `bio`,
            `role`,
            `onlinestatus`,
            `loggedin`,
            `fname`,
            `lname`
        FROM
            `user`
        WHERE
            `userID` = :userID
    ");

    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch();
}

function selectAllUserGroups($db, $userID) {
    $stmt = $db->prepare("
        SELECT
            `group_page`.`groupID`,
            `name`,
            `picture`,
            `userID`
        FROM
            `group_page`
        INNER JOIN
            `group_member`
        ON
            `group_page`.`groupID` = `group_member`.`groupID`
        WHERE
            `userID` = :userID AND
            `role` = 1
    ");

    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt;
}

function selectAllUserPosts($db, $userID) {
    $stmt = $db->prepare("
        SELECT
            `postID`,
            `author`,
            `title`,
            `content`,
            `creationdate`
        FROM
             `post`
        WHERE
            `author` = :userID AND
            `groupID` IS NULL
        ORDER BY
            `creationdate` DESC
    ");

    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt;
}
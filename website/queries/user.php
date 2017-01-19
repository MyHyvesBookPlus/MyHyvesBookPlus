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
                '../img/notbad.jpg'
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
    $stmt = $GLOBALS["db"]->prepare("
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
    $stmt = $GLOBALS["db"]->prepare("
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

function select20UsersFromN($db, $n) {
    return $db->query("
    SELECT
        `userID`,
        `username`,
        `role`,
        `bancomment`
    FROM
        `user`
    ORDER BY
        `role`,
        `username`
    LIMIT
        $n, 20
    ");
}

function search20UsersFromN($db, $n, $keyword) {
    $q = $db->prepare("
    SELECT
        `userID`,
        `username`,
        `role`,
        `bancomment`
    FROM
        `user`
    WHERE
        `username` LIKE :keyword
    ORDER BY
        `username`
    LIMIT
        :n, 20
    ");

    $keyword = "%$keyword%";
    $q->bindParam(':keyword', $keyword);
    $q->bindParam(':n', $n, PDO::PARAM_INT);
    $q->execute();
    return $q;
}

function search20UsersFromNByStatus($db, $n, $keyword, $status) {
    $q = $db->prepare("
    SELECT
        `userID`,
        `username`,
        `role`,
        `bancomment`
    FROM
        `user`
    WHERE
        `username` LIKE :keyword AND
        FIND_IN_SET (`role`, :statuses)
    ORDER BY
        `role`,
        `username`
    LIMIT
        :n, 20
    ");

    $keyword = "%$keyword%";
    $q->bindParam(':keyword', $keyword);
    $q->bindParam(':n', $n, PDO::PARAM_INT);
    $statuses = implode(',', $status);
    $q->bindParam(':statuses', $statuses);
    $q->execute();
    return $q;
}

function changeUserStatusByID($db, $id, $status) {
    $q = $db->query("
    UPDATE
        `user`
    SET
        `role` = $status
    WHERE
        `userID` = $id
    ");

    return $q;
}


?>

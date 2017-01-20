<?php
require("connect.php");

function getUserID($username) {
    $stmt = $GLOBALS["db"]->prepare("
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

function selectUser($userID) {
    $stmt = $GLOBALS["db"]->prepare("
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

function selectAllUserGroups($userID) {
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

function selectAllUserPosts($userID) {
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

function select20UsersFromN($n) {
    return $GLOBALS["db"]->query("
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

function search20UsersFromN($n, $keyword) {
    $q = $GLOBALS["db"]->prepare("
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

function search20UsersFromNByStatus($n, $keyword, $status) {
    $q = $GLOBALS["db"]->prepare("
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

function changeUserStatusByID($id, $status) {
    $q = $GLOBALS["db"]->query("
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
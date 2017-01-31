<?php

require_once ("connect.php");

function getUserID($username) {
    $stmt = prepareQuery("
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

function getUsername($userID) {
    $stmt = prepareQuery("
        SELECT
            `username`
        FROM
            `user`
        WHERE
            `userID` = :userID
    ");

    $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch()["username"];
}

function selectUser($me, $other) {
    $stmt = prepareQuery("
        SELECT
          `userID`,
          `username`,
          `birthdate`,
          `location`,
          IFNULL(
                `profilepicture`,
                '../img/avatar-standard.png'
            ) AS profilepicture,
          `bio`,
          `user`.`creationdate`,
          CASE `lastactivity` >= DATE_SUB(NOW(),INTERVAL 15 MINUTE)
            WHEN TRUE THEN 'online'
            WHEN FALSE THEN 'offline'
          END AS `onlinestatus`,
          `role`,
          `fname`,
          `lname`,
          CASE `status` IS NULL
            WHEN TRUE THEN 0
            WHEN FALSE THEN
              CASE `status` = 'confirmed'
              WHEN TRUE THEN
                1
              WHEN FALSE THEN
                CASE `user1ID` = `userID` AND `user2ID` = :me
                  WHEN TRUE THEN
                    2
                  WHEN FALSE THEN
                    3
                  END
              END
          END AS `friend_status`
        FROM
          `user`
        LEFT JOIN
          `friendship`
        ON
          `user1ID` = `userID` AND `user2ID` = :me OR
          `user1ID` = :me AND `user2ID` = `userID`
        WHERE
          `user`.`userID` = :other
    ");

    $stmt->bindParam(':me', $me, PDO::PARAM_INT);
    $stmt->bindParam(':other', $other, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch();
}

function selectAllUserGroups($userID) {
    $stmt = prepareQuery("
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
            `role` = 'member'
    ");

    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt;
}

function selectAllUserPosts($userID) {
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
          COUNT(`commentID`) AS `comments`,
          COUNT(`niet_slecht`.`postID`) AS `niet_slechts`
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
          `groupID` IS NULL
        GROUP BY
          `post`.`postID`
        ORDER BY
          `post`.`creationdate` DESC
    ");

    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    if(!$stmt->execute()) {
        return False;
    }
    return $stmt;
}

function select20UsersFromN($n) {
    $q = prepareQuery("
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
        :n, 20
    ");

    $q->bindParam(':n', $n);
    $q->execute();
    return $q;
}

function search20UsersFromN($n, $keyword) {
    $q = prepareQuery("
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
    $q = prepareQuery("
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

function searchSomeUsersByStatus($n, $m, $keyword, $status) {
    $q = prepareQuery("
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
        :n, :m
    ");

    $keyword = "%$keyword%";
    $q->bindParam(':keyword', $keyword);
    $q->bindParam(':n', $n, PDO::PARAM_INT);
    $q->bindParam(':m', $m, PDO::PARAM_INT);
    $statuses = implode(',', $status);
    $q->bindParam(':statuses', $statuses);
    $q->execute();
    return $q;
}

function countSomeUsersByStatus($keyword, $status) {
    $q = prepareQuery("
    SELECT
        COUNT(*)
    FROM
        `user`
    WHERE
        `username` LIKE :keyword AND
        FIND_IN_SET (`role`, :statuses)
    ORDER BY
        `role`,
        `username`
    ");

    $keyword = "%$keyword%";
    $q->bindParam(':keyword', $keyword);
    $statuses = implode(',', $status);
    $q->bindParam(':statuses', $statuses);
    $q->execute();
    return $q;
}


function changeUserStatusByID($id, $status) {
    $q = prepareQuery("
    UPDATE
        `user`
    SET
        `role` = :status
    WHERE
        `userID` = :id
    ");

    $q->bindParam(':status', $status);
    $q->bindParam(':id', $id);
    $q->execute();
    return $q;
}

function changeMultipleUserStatusByID($ids, $status) {
    $q = prepareQuery("
    UPDATE
        `user`
    SET
        `role` = :status
    WHERE
        FIND_IN_SET (`userID`, :ids)
    ");

    $ids = implode(',', $ids);
    $q->bindParam(':ids', $ids);
    $q->bindParam(':status', $status);
    $q->execute();
    return $q;
}

function changeMultipleUserStatusByIDAdmin($ids, $status) {
    $q = prepareQuery("
    UPDATE
        `user`
    SET
        `role` = :status
    WHERE
        FIND_IN_SET (`userID`, :ids)
        AND NOT `role` = 'admin'
        AND NOT `role` = 'owner'
    ");

    $ids = implode(',', $ids);
    $q->bindParam(':ids', $ids);
    $q->bindParam(':status', $status);
    $q->execute();
    return $q;
}

function selectRandomNotFriendUser($userID) {
    $stmt = prepareQuery("
    SELECT
        `user`.`username`
    FROM
        `user`
    WHERE
        `userID` NOT IN (SELECT
                            `user1ID`
                         FROM
                            `friendship`
                         WHERE `user1ID` = :userID) OR
        `userID` NOT IN (SELECT
                            `user2ID`
                         FROM
                            `friendship`
                         WHERE `user2ID` = :userID)
    ORDER BY
        RAND()
    LIMIT
        1
    ");

    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch();
}

function searchSomeUsers($n, $m, $search) {
    $stmt = prepareQuery("
    SELECT
        `userID`,
        `username`,
        IFNULL(
            `profilepicture`,
            '../img/avatar-standard.png'
        ) AS profilepicture,
        LEFT(CONCAT(`user`.`fname`, ' ', `user`.`lname`), 15) as `fullname`
    FROM
      `user`
    WHERE
        (`username` LIKE :keyword OR 
        `fname` LIKE :keyword OR 
        `lname` LIKE :keyword) AND
        `role` != 'banned'
    ORDER BY 
        `fname`, 
        `lname`, 
        `username`
    LIMIT 
        :n, :m
    ");

    $search = "%$search%";
    $stmt->bindParam(':keyword', $search);
    $stmt->bindParam(':n', $n, PDO::PARAM_INT);
    $stmt->bindParam(':m', $m, PDO::PARAM_INT);

    $stmt->execute();

    return json_encode($stmt->fetchAll());
}

function countSomeUsers($search) {
    $q = prepareQuery("
    SELECT
        COUNT(*)
    FROM
        `user`
    WHERE
        `username` LIKE :keyword OR 
        `fname` LIKE :keyword OR 
        `lname` LIKE :keyword
    ORDER BY 
        `fname`, 
        `lname`, 
        `username`
    ");

        $search = "%$search%";
        $q->bindParam(':keyword', $search);
        $q->execute();
        return $q;
}

function getRoleByID($userID) {
    $stmt = prepareQuery("
        SELECT
            `role`
        FROM
            `user`
        WHERE
            `userID` = :userID
    ");

    $stmt->bindParam(':userID', $userID);
    $stmt->execute();
    return $stmt;
}

function editBanCommentByID($userID, $comment) {
    $stmt = prepareQuery("
        UPDATE
            `user`
        SET
            `bancomment` = :comment
        WHERE
            `userID` = :userID
    ");

    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->bindParam(':comment', $comment);
    $stmt->execute();
}
<?php

require_once ("connect.php");

/**
 * This sets the last activity of the session user to now.
 * @return bool, true is it ran correctly
 */
function updateLastActivity() {
    $stmt = prepareQuery("
      UPDATE
        `user`
      SET
        `lastactivity` = NOW()
      WHERE
        `userID` = :userID
    ");
    $stmt->bindParam(":userID", $_SESSION["userID"]);
    return $stmt->execute();
}

/**
 * This gets the userID from a username
 * @param $username
 * @return mixed
 */
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

/**
 * This gets the username from a userID
 * @param $userID
 * @return mixed
 */
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

/**
 * This selects the information about the other user and the connection between the two.
 * @param $me
 * @param $other
 * @return bool|mixed
 */
function selectUser($me, $other) {
    $stmt = prepareQuery("
        SELECT
          `userID`,
          `username`,
          `birthdate`,
          `location`,
          `showBday`,
          `showEmail`,
          `showProfile`,
          `email`,
          IFNULL(
                `profilepicture`,
                '../img/avatar-standard.png'
            ) AS profilepicture,
          `bio`,
          `user`.`creationdate`,
          CASE `lastactivity` >= DATE_SUB(NOW(),INTERVAL 5 MINUTE)
            WHEN TRUE THEN 'online'
            WHEN FALSE THEN 'offline'
          END AS `onlinestatus`,
          `role`,
          `fname`,
          `lname`,
          `showBday`,
          `showEmail`,
          `showProfile`,
          `status`,
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
    if(!$stmt->execute() || $stmt->rowCount() == 0) {
        return False;
    }
    return $stmt->fetch();
}

/**
 * Select all the users from a group.
 * @param $userID
 * @return PDOStatement
 */
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
            `role` IN ('member', 'mod', 'admin')
    ");

    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt;
}

/**
 * Selects 20 users from a given point in the table, ordered by role and name
 * @param $n
 * @return PDOStatement
 */
function select20UsersFromN($n) {
    $q = prepareQuery("
    SELECT
        `userID`,
        `username`,
        `role`,
        `bancomment`,
        CASE `lastactivity` >= DATE_SUB(NOW(),INTERVAL 5 MINUTE)
          WHEN TRUE THEN 'online'
          WHEN FALSE THEN 'offline'
        END AS `onlinestatus`
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

/**
 * Search 20 users from a given point in the table, ordered by role and name
 * @param $n
 * @param $keyword
 * @return PDOStatement
 */
function search20UsersFromN($n, $keyword) {
    $q = prepareQuery("
    SELECT
        `userID`,
        `username`,
        `role`,
        `bancomment`,
        CASE `lastactivity` >= DATE_SUB(NOW(),INTERVAL 5 MINUTE)
          WHEN TRUE THEN 'online'
          WHEN FALSE THEN 'offline'
        END AS `onlinestatus`
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

/**
 * Search 20 users from a given point in the database where the status @param $status
 * @param $n
 * @param $keyword
 * @param $status
 * @return PDOStatement
 */
function search20UsersFromNByStatus($n, $keyword, $status) {
    $q = prepareQuery("
    SELECT
        `userID`,
        `username`,
        `role`,
        `bancomment`,
        CASE `lastactivity` >= DATE_SUB(NOW(),INTERVAL 5 MINUTE)
          WHEN TRUE THEN 'online'
          WHEN FALSE THEN 'offline'
        END AS `onlinestatus`
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

/**
 * Search users from a given point in the database where the status @param $status
 * @param $n
 * @param $m
 * @param $search
 * @param $status
 * @return PDOStatement
 */
function searchSomeUsersByStatus($n, $m, $search, $status) {
//    parentheses not needed in where clause, for clarity as
//      role search should override status filter.
    $q = prepareQuery("
    SELECT
        `userID`,
        `username`,
        `role`,
        `bancomment`,
        CASE `lastactivity` >= DATE_SUB(NOW(),INTERVAL 5 MINUTE)
          WHEN TRUE THEN 'online'
          WHEN FALSE THEN 'offline'
        END AS `onlinestatus`
    FROM
        `user`
    WHERE
        (`username` LIKE :keyword AND
        FIND_IN_SET (`role`, :statuses)) OR 
        `role` = :search
    ORDER BY
        `role`,
        `username`
    LIMIT
        :n, :m
    ");

    $keyword = "%$search%";
    $q->bindParam(':keyword', $keyword);
    $q->bindParam(':search', $search);
    $q->bindParam(':n', $n, PDO::PARAM_INT);
    $q->bindParam(':m', $m, PDO::PARAM_INT);
    $statuses = implode(',', $status);
    $q->bindParam(':statuses', $statuses);
    $q->execute();
    return $q;
}

/**
 * Count the users with a name like $search and a $status
 * @param $search
 * @param $status
 * @return PDOStatement
 */
function countSomeUsersByStatus($search, $status) {
    $q = prepareQuery("
    SELECT
        COUNT(*)
    FROM
        `user`
    WHERE
        (`username` LIKE :keyword AND
        FIND_IN_SET (`role`, :statuses)) OR 
        `role` = :search
    ORDER BY
        `role`,
        `username`
    ");

    $keyword = "%$search%";
    $q->bindParam(':keyword', $keyword);
    $q->bindParam(':search', $search);
    $statuses = implode(',', $status);
    $q->bindParam(':statuses', $statuses);
    $q->execute();
    return $q;
}

/**
 * Change the user status
 * @param $id
 * @param $status
 * @return PDOStatement
 */
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

/**
 * Change multiple user statuses by an id array.
 * @param $ids
 * @param $status
 * @return PDOStatement
 */
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

/**
 * Change multiple user statuses by an id array.
 * This excludes that admins and owners statuses can be changed.
 * @param $ids
 * @param $status
 * @return PDOStatement
 */
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

/**
 * Select a random user that is nog your friend.
 * @param $userID
 * @return mixed
 */
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

/**
 * Search users.
 * @param $n
 * @param $m
 * @param $search
 * @return string
 */
function searchSomeUsers($n, $m, $search) {
    $stmt = prepareQuery("
    SELECT
        `userID`,
        LEFT(`username`, 12) as `usernameshort`,
        `username`,
        IFNULL(
            `profilepicture`,
            '../img/avatar-standard.png'
        ) AS profilepicture,
        LEFT(CONCAT(`user`.`fname`, ' ', `user`.`lname`), 12) as `fullname`,
        CASE `lastactivity` >= DATE_SUB(NOW(),INTERVAL 5 MINUTE)
          WHEN TRUE THEN 'online'
          WHEN FALSE THEN 'offline'
        END AS `onlinestatus`
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

/**
 * Count the users that you get searching for a user with a keyword.
 * @param $search
 * @return PDOStatement
 */
function countSomeUsers($search) {
    $q = prepareQuery("
    SELECT
        COUNT(*)
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
    ");

        $search = "%$search%";
        $q->bindParam(':keyword', $search);
        $q->execute();
        return $q;
}

/**
 * Get the role of a user by userID.
 * @param $userID
 * @return mixed
 */
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
    return $stmt->fetch()["role"];
}

/**
 * Edit the ban comment.
 * @param $userID
 * @param $comment
 */
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
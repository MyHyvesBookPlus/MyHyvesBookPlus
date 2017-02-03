<?php

require_once ("connect.php");

/**
 * Selects all friends of a user.
 * @param $userID
 * @return string
 */
function selectFriends($userID) {
    return selectLimitedFriends($userID, 9999);
}

/**
 * Returns a limited amount of friends of a user.
 * @param $userID
 * @param $limit
 * @return string
 */
function selectLimitedFriends($userID, $limit) {
    $stmt = prepareQuery("
        SELECT
            `userID`,
            LEFT(`username`, 12) as `usernameshort`,
            `username`,
            LEFT(CONCAT(`user`.`fname`, ' ', `user`.`lname`), 12) as `fullname`,
            IFNULL(
                `profilepicture`,
                '../img/avatar-standard.png'
            ) AS profilepicture,
            CASE `lastactivity` >= DATE_SUB(NOW(),INTERVAL 5 MINUTE)
              WHEN TRUE THEN 'online'
              WHEN FALSE THEN 'offline'
            END AS `onlinestatus`,
            `role`
        FROM
            `user`
        INNER JOIN
            `friendship`
        WHERE
            (`friendship`.`user1ID` = :userID AND
            `friendship`.`user2ID` = `user`.`userID` OR 
            `friendship`.`user2ID` = :userID AND
            `friendship`.`user1ID` = `user`.`userID`) AND
            `user`.`role` != 'banned' AND
            `friendship`.`status` = 'confirmed'
        ORDER BY
            `user`.`lastactivity`
            DESC
        LIMIT :limitCount
    ");

    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->bindParam(':limitCount', $limit, PDO::PARAM_INT);
    $stmt->execute();

    return json_encode($stmt->fetchAll());
}

/**
 * Selects all friends of a user.
 * @param $userID
 * @return PDOStatement
 */
function selectAllFriends($userID) {
    $stmt = prepareQuery("
        SELECT
            `userID`,
            LEFT(`username`, 12) as `usernameshort`,
            `username`,
            LEFT(CONCAT(`user`.`fname`, ' ', `user`.`lname`), 12) as `fullname`,
            IFNULL(
                `profilepicture`,
                '../img/avatar-standard.png'
            ) AS profilepicture,
            CASE `lastactivity` >= DATE_SUB(NOW(),INTERVAL 5 MINUTE)
              WHEN TRUE THEN 'online'
              WHEN FALSE THEN 'offline'
            END AS `onlinestatus`,
            `role`
        FROM
            `user`
        INNER JOIN
            `friendship`
            
        WHERE
            (`friendship`.`user1ID` = :userID AND
            `friendship`.`user2ID` = `user`.`userID` OR 
            `friendship`.`user2ID` = :userID AND
            `friendship`.`user1ID` = `user`.`userID`) AND
            `user`.`role` != 'banned' AND
            `friendship`.`status` = 'confirmed'
    ");

    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt;
}

/**
 * Returns all friend requests of the current user.
 * @return string
 */
function selectAllFriendRequests() {
    $stmt = prepareQuery("
        SELECT
            `userID`,
            LEFT(`username`, 12) as `usernameshort`,
            `username`,
            LEFT(CONCAT(`user`.`fname`, ' ', `user`.`lname`), 12) as `fullname`,
            IFNULL(
                `profilepicture`,
                '../img/avatar-standard.png'
            ) AS profilepicture,
            CASE `lastactivity` >= DATE_SUB(NOW(),INTERVAL 5 MINUTE)
              WHEN TRUE THEN 'online'
              WHEN FALSE THEN 'offline'
            END AS `onlinestatus`,
            `role`
        FROM
            `user`
        INNER JOIN
            `friendship`
            
        WHERE
            (`friendship`.`user1ID` = :userID AND
            `friendship`.`user2ID` = `user`.`userID` OR 
            `friendship`.`user2ID` = :userID AND
            `friendship`.`user1ID` = `user`.`userID`) AND
            `user`.`role` != 'banned' AND
            `friendship`.`status` = 'requested'
    ");

    $stmt->bindParam(':userID', $_SESSION["userID"], PDO::PARAM_INT);
    $stmt->execute();

    return json_encode($stmt->fetchAll());
}

/**
 * Gets the friendship status from current user and userID.
 * @param $userID
 * @return int
 */
function getFriendshipStatus($userID) {
    # -2: Query failed.
    # -1: user1 and 2 are the same user
    # 0 : no record found
    # 1 : confirmed
    # 2 : user1 sent request (you)
    # 3 : user2 sent request (other)
    if($_SESSION["userID"] == $userID) {
        return -1;
    }

    $stmt = prepareQuery("
    SELECT
      CASE `status` IS NULL
      WHEN TRUE THEN 0
      WHEN FALSE THEN
        CASE `status` = 'confirmed'
        WHEN TRUE THEN
          1
        WHEN FALSE THEN
          CASE `user1ID` = :me AND `user2ID` = :other
          WHEN TRUE THEN
            2
          WHEN FALSE THEN
            3
          END
        END
      END AS `friend_state`
    FROM
      `friendship`
    WHERE
      `user1ID` = :other AND `user2ID` = :me OR
      `user1ID` = :me AND `user2ID` = :other
    ");

    $stmt->bindParam(':me', $_SESSION["userID"], PDO::PARAM_INT);
    $stmt->bindParam(':other', $userID, PDO::PARAM_INT);
    if(!$stmt->execute()) {
        return -2;
    }
    return intval($stmt->fetch()["friend_state"]);
}

/**
 * Request friendship from current user to target user.
 * @param $userID
 * @return bool
 */
function requestFriendship($userID) {
    $stmt = prepareQuery("
        INSERT INTO `friendship` (user1ID, user2ID)
        VALUES (:user1, :user2)
    ");

    $stmt->bindParam(':user1', $_SESSION["userID"], PDO::PARAM_INT);
    $stmt->bindParam(':user2', $userID, PDO::PARAM_INT);
    return $stmt->execute();
}

/**
 * Removes friendship between current and target user.
 * @param $userID
 * @return bool
 */
function removeFriendship($userID) {
    $stmt = prepareQuery("
        DELETE FROM `friendship`
        WHERE
          `user1ID` = :user1 AND
          `user2ID` = :user2 OR
          `user1ID` = :user2 AND
          `user2ID` = :user1
        LIMIT 1
    ");

    $stmt->bindParam(':user1', $_SESSION["userID"], PDO::PARAM_INT);
    $stmt->bindParam(':user2', $userID, PDO::PARAM_INT);
    return $stmt->execute();
}

/**
 * Sets the friendship between current and target user to accepted.
 * @param $userID
 * @return bool
 */
function acceptFriendship($userID) {
    $stmt = prepareQuery("
        UPDATE `friendship`
        SET `status`='confirmed'
        WHERE 
          `user1ID` = :user1 AND
          `user2ID` = :user2
        LIMIT 1
    ");

    $stmt->bindParam(':user1', $userID, PDO::PARAM_INT);
    $stmt->bindParam(':user2', $_SESSION["userID"], PDO::PARAM_INT);
    return $stmt->execute();
}

/**
 * Sets the last time the user visited the chat with specified friend.
 * @param $friend
 * @return PDOStatement
 */
function setLastVisited($friend) {
    $stmt = prepareQuery("
        UPDATE
          `friendship`
        SET `friendship`.chatLastVisted1=(
            CASE `user1ID` = :sessionUser
                WHEN TRUE THEN NOW()
                WHEN FALSE THEN `chatLastVisted1`
            END
        ),
          `friendship`.`chatLastVisted2`=(
            CASE `user2ID` = :sessionUser
                WHEN TRUE THEN NOW()
                WHEN FALSE THEN `chatLastVisted2`
            END
        )
        WHERE
        `user1ID` = :sessionUser AND
        `user2ID` = :friend OR
        `user2ID` = :sessionUser AND
        `user1ID` = :friend;
    ");

    $stmt->bindParam(':sessionUser', $_SESSION["userID"], PDO::PARAM_INT);
    $stmt->bindParam(':friend', $friend, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt;
}

/**
 * Searches m friends from n filtered by search.
 * @param $n
 * @param $m
 * @param $search
 * @return string
 */
function searchSomeFriends($n, $m, $search) {
    $stmt = prepareQuery("
    SELECT
            `userID`,
            LEFT(`username`, 12) as `usernameshort`,
            `username`,
            LEFT(CONCAT(`user`.`fname`, ' ', `user`.`lname`), 12) as `fullname`,
            IFNULL(
                `profilepicture`,
                '../img/avatar-standard.png'
            ) AS profilepicture,
            CASE `lastactivity` >= DATE_SUB(NOW(),INTERVAL 5 MINUTE)
              WHEN TRUE THEN 'online'
              WHEN FALSE THEN 'offline'
            END AS `onlinestatus`,
            `role`
        FROM
            `user`
        INNER JOIN
            `friendship`
        WHERE
            ((`friendship`.`user1ID` = :userID AND
            `friendship`.`user2ID` = `user`.`userID` OR 
            `friendship`.`user2ID` = :userID AND
            `friendship`.`user1ID` = `user`.`userID`) AND
            `user`.`role` != 'banned' AND
            `friendship`.`status` = 'confirmed') AND
            (`username` LIKE :keyword OR
             `fname` LIKE :keyword OR
             `lname` LIKE :keyword)
    ORDER BY
      `fname`,
      `lname`,
      `username`
    LIMIT
      :n, :m
    ");

    $search = "%$search%";
    $stmt->bindParam(':keyword', $search);
    $stmt->bindParam(':userID', $_SESSION["userID"], PDO::PARAM_INT);
    $stmt->bindParam(':n', $n, PDO::PARAM_INT);
    $stmt->bindParam(':m', $m, PDO::PARAM_INT);
    $stmt->execute();
    return json_encode($stmt->fetchAll());
}

/**
 * Counts all friends of current user filtered by search.
 * @param $search
 * @return string
 */
function countSomeFriends($search) {
    $stmt = prepareQuery("
    SELECT
            COUNT(*)
        FROM
            `user`
        INNER JOIN
            `friendship`
        WHERE
            ((`friendship`.`user1ID` = :userID AND
            `friendship`.`user2ID` = `user`.`userID` OR 
            `friendship`.`user2ID` = :userID AND
            `friendship`.`user1ID` = `user`.`userID`) AND
            `user`.`role` != 'banned' AND
            `friendship`.`status` = 'confirmed') AND
            (`username` LIKE :keyword OR
             `fname` LIKE :keyword OR
             `lname` LIKE :keyword)
    ORDER BY
      `fname`,
      `lname`,
      `username`
    ");

    $search = "%$search%";
    $stmt->bindParam(':keyword', $search);
    $stmt->bindParam(':userID', $_SESSION["userID"], PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn();
}
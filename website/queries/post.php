<?php

require_once("connect.php");

/**
 * Select all posts on a user.
 * @param $userID
 * @param $groupID
 * @return bool|PDOStatement
 */
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

/**
 * Select $limit posts from $offset from a user or group.
 * @param $userID
 * @param $groupID
 * @param $offset
 * @param $limit
 * @return bool|PDOStatement
 */
function selectSomePosts($userID, $groupID, $offset, $limit) {
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
        LIMIT 
          :offset, :limit
    ");
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->bindParam(':groupID', $groupID , PDO::PARAM_INT);
    $stmt->bindParam(':offset', intval($offset), PDO::PARAM_INT);
    $stmt->bindParam(':limit', intval($limit), PDO::PARAM_INT);
    if(!$stmt->execute()) {
        return False;
    }
    if($stmt->rowCount() == 0) {
        return False;
    }
    return $stmt;
}

/**
 * Select all the post information from an postID.
 * @param $postID
 * @return PDOStatement
 */
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

/**
 * Get all the comments from a post.
 * @param $postID
 * @return PDOStatement
 */
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

/**
 * Insert a post to a group or user
 * @param $userID
 * @param $groupID
 * @param $title
 * @param $content
 */
function makePost($userID, $groupID, $title, $content) {
    $stmt = prepareQuery("
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

/**
 * Insert a comment by a post.
 * @param $postID
 * @param $userID
 * @param $content
 * @return int
 */
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

/**
 * If a post already is niet slechted.
 * @param int $postID
 * @param int $userID
 * @return int
 */
function makeNietSlecht(int $postID, int $userID) : int {
    if (checkNietSlecht($postID, $userID)) {
        return deleteNietSlecht($postID, $userID);
    } else {
        return addNietSlecht($postID, $userID);
    }
}

/**
 * Toggle a niet slecht of a post.
 * @param int $postID
 * @param int $userID
 * @return int
 */
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

/**
 * Add a niet slecht to a post.
 * @param int $postID
 * @param int $userID
 * @return int
 */
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

/**
 * Delete a niet slecht.
 * @param int $postID
 * @param int $userID
 * @return int
 */
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

/**
 * Delete a post
 * @param int $postID
 * @param int $userID
 */
function deletePost(int $postID, int $userID) {
    if (checkPermissionOnPost($postID, $userID)) {
        $stmt = prepareQuery("
        DELETE FROM
            `post`
        WHERE
            `postID` = :postID
        ");
        $stmt->bindParam(":postID", $postID);
        $stmt->execute();
    }
}

/**
 * Check if a user has premissions to delete a post.
 * @param int $postID
 * @param int $userID
 * @return bool
 */
function checkPermissionOnPost(int $postID, int $userID) : bool {
    $getGroupID = prepareQuery("
    SELECT
        `author`,
        `groupID`
    FROM
        `post`
    WHERE
        `postID` = :postID
    ");
    $getGroupID->bindParam(":postID", $postID);
    $getGroupID->execute();
    $postinfo = $getGroupID->fetch();

    if ($postinfo["groupID"] == null) {
        // User post
        return ($userID == $postinfo["author"]);
    } else {
        // Group post
        $roleInGroup = getRoleInGroup($userID, $postinfo["groupID"]);
        return ($roleInGroup == "mod" or $roleInGroup == "admin");
    }
}

/**
 * Returns role of a user.
 * @param int $userID
 * @param int $groupID
 * @return mixed role of a user.
 */
function getRoleInGroup(int $userID, int $groupID) {
    $stmt = prepareQuery("
    SELECT
        `role`
    FROM
        `group_member`
    WHERE
      `userID` = :userID AND
      `groupID` = :groupID
    ");
    $stmt->bindParam(":userID", $userID);
    $stmt->bindParam(":groupID", $groupID);
    $stmt->execute();
    return $stmt->fetch()["role"];
}

<?php

session_start();
require_once ("../queries/connect.php");
require_once ("../queries/checkInput.php");

function getNietSlechtCountForPost(int $postID) : int {
    $stmt = $GLOBALS["db"]->prepare("
    SELECT 
        `userID`
    FROM 
        `niet_slecht`
    WHERE
        `postID` = :postID
    ");
    $stmt->bindParam(":postID", $postID);
    $stmt->execute();
    return $stmt->rowCount();
}

function getNietSlechtUsersForPost(int $postID) {
    $stmt = $GLOBALS["db"]->prepare("
    SELECT
      `fname`,
      `lname`,
      CONCAT(`user`.`fname`, ' ', `user`.`lname`) as `fullname`
    FROM
      `user`
    INNER JOIN
      `niet_slecht`
    WHERE
      `user`.`userID` = `niet_slecht`.`userID` AND
        `niet_slecht`.`postID` = :postID
    ");
    $stmt->bindParam(":postID", $postID);
    $stmt->execute();
    $rows = $stmt->fetchAll();
    foreach ($rows as $row) {
        print($row["fullname"]);
    }
}
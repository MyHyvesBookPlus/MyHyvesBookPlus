<?php
function getHeaderInfo() {
    $stmt = $GLOBALS["db"]->prepare("
    SELECT
      `fname`,
      `lname`,
      `profilepicture`
    FROM
      `user`
    WHERE
      `userID` = :userID
    ");
    $stmt->bindParam(":userID", $_SESSION["userID"]);
    $stmt->execute();
    return $stmt->fetch();

}
<?php
function getHeaderInfo() {
    $stmt = $GLOBALS["db"]->prepare("
    SELECT
        `fname`,
        `lname`,
        IFNULL(
            `profilepicture`,
            'img/avatar-standard.png'
        ) AS profilepicture
    FROM
        `user`
    WHERE
        `userID` = :userID
    ");

    $stmt->bindParam(":userID", $_SESSION["userID"]);
    $stmt->execute();

    return $stmt->fetch();
}

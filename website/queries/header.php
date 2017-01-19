<?php
function getHeaderInfo() {
    $stmt = $GLOBALS["db"]->prepare("
    SELECT
        `fname`,
        `lname`,
        IFNULL(
            `profilepicture`,
            'img/notbad.jpg'
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

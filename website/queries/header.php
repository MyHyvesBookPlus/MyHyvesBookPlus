<?php
function getHeaderInfo() {
    $stmt = prepareQuery("
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

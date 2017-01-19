<?php

function getUser() {
    $stmt = $GLOBALS["db"]->prepare("
    SELECT
      `password`,
      `userID`
    FROM
      `user`
    WHERE
      `username` LIKE :username
    ");

    $stmt->bindParam(":username", $_POST["uname"]);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

?>

<?php

function hashPassword() {
    $stmt = $GLOBALS["db"]->prepare("
    SELECT
      `password`
    FROM
      `user`
    WHERE
      `username` = :username
    ");

    $stmt->bindParam(":username", $_POST["uname"]);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

?>

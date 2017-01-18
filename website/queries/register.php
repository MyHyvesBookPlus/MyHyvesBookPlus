<?php

function getExistingUsername() {
    $stmt = $GLOBALS["db"]->prepare("
    SELECT
      `username`
    FROM
      `user`
    WHERE
      `username` LIKE :username
    ");

    $stmt->bindParam(":username", $_POST["username"]);
    $stmt->execute();
    return $stmt->rowCount();

}

function getExistingEmail() {
    $stmt = $GLOBALS["db"]->prepare("
    SELECT
      `email`
    FROM
      `user`
    WHERE
      `email` LIKE :email
    ");

    $stmt->bindParam(":email", $_POST["email"]);
    $stmt->execute();
    return $stmt->rowCount();

}

function registerAccount() {
    $stmt = $GLOBALS["db"]->prepare("
    INSERT INTO
      `user`(fname,
             lname,
             birthdate,
             username,
             password,
             location,
             email)
    VALUES(
      :fname,
      :lname,
      :bday,
      :username,
      :password,
      :location,
      :email
    )");

    $hash=password_hash($_POST["password"].(strtolower($_POST["username"])), PASSWORD_DEFAULT);

    $stmt->bindParam(":fname", $_POST["name"]);
    $stmt->bindParam(":lname", $_POST["surname"]);
    $stmt->bindParam(":bday", $_POST["bday"]);
    $stmt->bindParam(":username", $_POST["username"]);
    $stmt->bindParam(":password", $hash);
    $stmt->bindParam(":location", $_POST["location"]);
    $stmt->bindParam(":email", (strtolower($_POST["email"])));

    $stmt->execute();
    $stmt->rowCount();
}
?>

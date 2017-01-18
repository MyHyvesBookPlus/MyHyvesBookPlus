<?php

function getExistingUser() {
    $stmt = $GLOBALS["db"]->prepare("
    SELECT * FROM `user` WHERE `username` = :username
    ");

    $stmt->bindParam(":username", $_POST["username"]);
    $stmt->execute();
    return $stmt->rowCount();

}

function getExistingEmail() {
    $stmt = $GLOBALS["db"]->prepare("
    SELECT * FROM `user` WHERE `email` = :email
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

    $hash=password_hash($_POST["password"], PASSWORD_DEFAULT);

    $stmt->bindParam(":fname", $_POST["name"]);
    $stmt->bindParam(":lname", $_POST["surname"]);
    $stmt->bindParam(":bday", $_POST["bday"]);
    $stmt->bindParam(":username", $_POST["username"]);
    $stmt->bindParam(":password", $hash);
    $stmt->bindParam(":location", $_POST["location"]);
    $stmt->bindParam(":email", $_POST["email"]);

    print("execute".$stmt->execute());
    print("count".$stmt->rowCount());
}
?>

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

    $stmt->bindValue(":username", test_input($_POST["username"]));
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

    $stmt->bindValue(":email", test_input($_POST["email"]));
    $stmt->execute();
    return $stmt->rowCount();

}

function getResetEmail() {
    $stmt = $GLOBALS["db"]->prepare("
    SELECT
      `email`
    FROM
      `user`
    WHERE
      `email` LIKE :email
    ");

    $stmt->bindValue(":email", test_input($_POST["forgotEmail"]));
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

    $stmt->bindValue(":fname", test_input($_POST["name"]));
    $stmt->bindValue(":lname", test_input($_POST["surname"]));
    $stmt->bindValue(":bday", test_input($_POST["bday"]));
    $stmt->bindValue(":username", test_input($_POST["username"]));
    $stmt->bindValue(":password", test_input($hash));
    $stmt->bindValue(":location", test_input($_POST["location"]));
    $stmt->bindValue(":email", test_input(strtolower($_POST["email"])));

    $stmt->execute();
    $stmt->rowCount();
}

function submitselect($date, $value){
    if ($date == $value){
        echo "selected";
    }
}
?>

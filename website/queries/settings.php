<?php

function getSettings() {
    $stmt = $GLOBALS["db"]->prepare("
    SELECT
      `fname`,
      `lname`,
      `email`,
      `location`,
      `birthdate`,
      `bio`,
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

function getPasswordHash() {
    $stmt = $GLOBALS["db"]->prepare("
    SELECT
      `password`
    FROM
      `user`
    WHERE
      `userID` = :userID
    ");
    $stmt->bindParam(":userID", $_SESSION["userID"]);
    $stmt->execute();
    return $stmt->fetch();
}

function updateSettings() {
    $stmt = $GLOBALS["db"]->prepare("
    UPDATE
      `user`
    SET
      `fname` = :fname,
      `lname` = :lname,
      `location` = :location,
      `birthdate` = :bday,
      `bio` = :bio
    WHERE
      `userID` = :userID
    ");

    $stmt->bindParam(":fname", $_POST["fname"]);
    $stmt->bindParam(":lname", $_POST["lname"]);
    $stmt->bindParam(":location", $_POST["location"]);
    $stmt->bindParam(":bday", $_POST["bday"]);
    $stmt->bindParam(":bio", $_POST["bio"]);
    $stmt->bindParam(":userID", $_SESSION["userID"]);

    $stmt->execute();
}

function updatePassword() {
    if (password_verify($_POST["password-old"], getPasswordHash()["password"])) {
        if ($_POST["password-new"] == $_POST["password-confirm"]) {
            changePassword();
        }
    } else {
        print("Did not match");
    }
}

function changePassword() {
    $stmt =$GLOBALS["db"]->prepare("
    UPDATE
      `user`
    SET
      `password` = :new_password
    WHERE
      `userID` = :userID
    ");

    $hashed_password = password_hash($_POST["password-new"], PASSWORD_DEFAULT);
    $stmt->bindParam(":new_password", $hashed_password);
    $stmt->bindParam(":userID", $_SESSION["userID"]);
    $stmt->execute();
}
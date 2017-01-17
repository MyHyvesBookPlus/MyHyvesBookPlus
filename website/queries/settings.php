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
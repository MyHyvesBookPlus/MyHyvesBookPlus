<?php

function sendConfirmEmailUsername(string $username) {
    $stmt = prepareQuery("
    SELECT
        `userID`
    FROM
        `user`
    WHERE
        `username` = :username
    ");
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    $userID = $stmt->fetch()["username"];
    sendConfirmEmail($userID);
}

function sendConfirmEmail(int $userID) {
    $stmt = prepareQuery("
    SELECT 
        `email`,
        `fname`
    FROM 
        `user`
    WHERE
        `userID` = :userID
    ");

    $stmt->bindParam(":userID", $userID);
    $stmt->execute();
    $user = $stmt->fetch();

    $email = $user["email"];
    $fname = $user["fname"];
    $hash = password_hash($email, PASSWORD_DEFAULT);
    $confirmLink = "https://myhyvesbookplus.nl/emailconfirm.php?u=$userID&h=$hash";

    $subject = "Bevestig uw emailadres";
    $body = "Hallo $fname,\r\n\r\nKlik op de onderstaande link om uw emailadres te bevestigen.\r\n\r\n$confirmLink\r\n\r\nGroeten MyHyvesbook+";
    $header = "From: MyHyvesbook+ <noreply@myhyvesbookplus.nl>";
    mail($email, $subject, $body, $header);
}
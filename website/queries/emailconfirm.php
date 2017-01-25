<?php

function sendConfirmEmailUsername(string $username) {
    $stmt = $GLOBALS["db"]->prepare("
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
    $stmt = $GLOBALS["db"]->prepare("
    SELECT 
        `email`,
        `fname`
    FROM 
        `user`
    WHERE
        `userID` = :userID
    ");
    $stmt->bindParam(":userID", $userID);
    $user = $stmt->fetch();

    $email = $user["email"];
    $fname = $user["fname"];
    $hash = password_hash($email, PASSWORD_DEFAULT);
    $confirmLink = "https://myhyvesbookplus.nl/emailconfirm.php?u=$userID&h=$hash";

    $subject = "Bevestig uw emailadres";
    $body = "Hallo $fname,\r\n\r\n 
             Klik op de onderstaande link om uw emailadres te bevestigen.\r\n\r\n
             $confirmLink\r\n\r\n
             Groeten MyHyvesbook+";
    $header = "From: MyHyvesbook+ <noreply@myhyvesbookplus.nl>";
    mail($email, $subject, $body, $header);
}
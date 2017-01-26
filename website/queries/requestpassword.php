<?php
include_once "../queries/connect.php";

function sendPasswordRecovery(string $email) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $GLOBALS["db"]->prepare("
        SELECT 
            `userID`,
            `username`
        FROM 
            `user`
        WHERE 
            `email` = :email
        ");
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        if (!$stmt->rowCount()) {
            return;
        }
        $result = $stmt->fetch();
        $userID = $result["userID"];
        $username = $result["username"];
        $hash = md5(random_int(0, 1000000));
        $hashedHash = password_hash($hash, PASSWORD_DEFAULT);
        setHashToDatabase($userID, $hash);
        doSendPasswordRecovery($userID, $email, $username, $hashedHash);
    } else {
        // TODO: Be angry!
    }
}

function doSendPasswordRecovery(int $userID, string $email, string $username, string $hash) {
    $resetLink = "https://myhyvesbookplus.nl/resetpassword.php?u=$userID&h=$hash";

    $subject = "Reset uw wachtwoord";
    $body = "Hallo $username,\r\n\r\nKlik op de onderstaande link om uw wachtwoord te resetten.\r\n\r\n$resetLink\r\n\r\nGroeten MyHyvesbook+";
    $header = "From: MyHyvesbook+ <noreply@myhyvesbookplus.nl>";
    mail($email, $subject, $body, $header);
}

function setHashToDatabase(int $userID, string $hash) {
    $stmt = $GLOBALS["db"]->prepare("
    UPDATE
        `user`
    SET
        `password` = :hash
    WHERE
        `userID` = :userID
    ");
    $stmt->bindParam(":hash", $hash);
    $stmt->bindParam(":userID", $userID);
    $stmt->execute();
    return $stmt->rowCount();
}
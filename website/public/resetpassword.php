<?php
include_once("../queries/connect.php");
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (array_key_exists("u", $_GET) and array_key_exists("h", $_GET)) {
        if (verifyLink($_GET["u"], $_GET["h"])) {
            include "../views/resetpassword.php";
        } else {
            echo "Ongeldige link.";
        }
    } else {
        echo "Ongeldige link.";
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (verifyLink($_POST["u"], $_POST["h"])) {
        if ($_POST["password"] == $_POST["password-confirm"]) {
            changePassword();
            echo "Wachtwoord is veranderd";
        } else {
            echo "Wachtwoorden zijn niet hetzelfde";
        }
    }
} else {
    echo "Ongeldige link.";
}

function changePassword() {
    $stmt = $GLOBALS["db"]->prepare("
        UPDATE
            `user`
        SET
            `password` = :password
        WHERE
            `userID` = :userID
    ");
    $stmt->bindValue(":password", password_hash($_POST["password"], PASSWORD_DEFAULT));
    $stmt->bindParam(":userID", $_POST["u"]);
    $stmt->execute();
}

function verifyLink(int $userID, string $hash) {
    $stmt = $GLOBALS["db"]->prepare("
        SELECT
            `password`
        FROM 
            `user`
        WHERE
            `userID` = :userID
        ");
    $stmt->bindParam(":userID", $userID);
    $stmt->execute();
    $password = $stmt->fetch()["password"];
    return password_verify($password, $hash);
}
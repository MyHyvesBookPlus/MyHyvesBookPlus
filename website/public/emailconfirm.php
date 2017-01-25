<?php
include_once("../queries/connect.php");
if (array_key_exists("u", $_GET) and array_key_exists("h", $_GET)) {
   $checkHash = $GLOBALS["db"]->prepare("
   SELECT
      `email`,
      `role`
   FROM
      `user`
   WHERE
      `userID` = :userID
   ");
   $checkHash->bindParam(":userID", $_GET["u"]);
   $checkHash->execute();
   $result = $checkHash->fetch();
   $email = $result["email"];
   $role = $result["role"];
   if ($role == "unconfirmed") {
       doActivate($email);
   } else {
       echo "Ongeldige link.";
   }

} else {
    echo "Ongeldige link.";
}

function doActivate(string $email) {
    if (password_verify($email, $_GET["h"])) {
        $confirmUser = $GLOBALS["db"]->prepare("
        UPDATE
            `user`
        SET
            `role` = :role
        WHERE
            `userID` = :userID
        ");
        $confirmUser->bindValue(":role", "user");
        $confirmUser->bindParam(":userID", $_GET["u"]);
        $confirmUser->execute();
        if ($confirmUser->rowCount()) {
            echo "Email bevestigd <br />
            <a href='index.php'>U wordt automatisch doorgestuurd naar de login pagina over 5 seconden.</a> ";
            header("refresh:5;url=login.php");
        }
    } else {
        echo "Ongeldige link.";
    }
}
<?php
include_once("../queries/connect.php");
include_once("../views/messagepage.php");
if (array_key_exists("u", $_GET) and array_key_exists("h", $_GET)) {
   $checkHash = prepareQuery("
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
        messagePage("Ongeldige link.");
   }

} else {
    messagePage("Ongeldige link.");
}

function doActivate(string $email) {
    if (password_verify($email, $_GET["h"])) {
        $confirmUser = prepareQuery("
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
            messagePage("Email bevestigd <br />
            <a href='index.php'>Klik hier om terug te gaan naar de login pagina.</a>");
        }
    } else {
        messagePage("Ongeldige link.");
    }
}
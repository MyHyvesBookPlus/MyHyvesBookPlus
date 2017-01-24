<?php
abstract class AlertMessage extends Exception {
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    abstract public function getClass();
}

class HappyAlert extends AlertMessage {

    public function __construct($message = "Gelukt!", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function getClass() {
        return "settings-message-happy";
    }
}

class AngryAlert extends AlertMessage {
    public function __construct($message = "Er is iets fout gegaan.", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function getClass() {
        return "settings-message-angry";
    }
}

/**
 * Gets the settings form the database.
 * @return mixed Setting as an array.
 */
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
      `password`,
      `username`
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

    $stmt->bindValue(":fname", test_input($_POST["fname"]));
    $stmt->bindValue(":lname", test_input($_POST["lname"]));
    $stmt->bindValue(":location", test_input($_POST["location"]));
    $stmt->bindValue(":bday", test_input($_POST["bday"]));
    $stmt->bindValue(":bio", test_input($_POST["bio"]));
    $stmt->bindValue(":userID", $_SESSION["userID"]);
    $stmt->execute();
    throw new HappyAlert("Instellingen zijn opgeslagen.");
}

function changePassword() {
    $user = getPasswordHash();
    if (password_verify($_POST["password-old"], $user["password"])) {
        if ($_POST["password-new"] == $_POST["password-confirm"] && (strlen($_POST["password-new"]) >= 8)) {
            doChangePassword();
        } else {
            throw new AngryAlert("Wachtwoorden komen niet overeen.");
        }
    } else {
        throw new AngryAlert("Oud wachtwoord niet correct.");
    }
}

function doChangePassword() {
    $stmt = $GLOBALS["db"]->prepare("
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

    if ($stmt->rowCount()) {
        throw new HappyAlert("Wachtwoord gewijzigd.");
    } else {
        throw new AngryAlert();
    }
}

function changeEmail() {

    if ($_POST["email"] == $_POST["email-confirm"]) {
        $email = strtolower($_POST["email"]);
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            //check if email exists
            emailIsAvailableInDatabase($email);
            doChangeEmail($email);
        } else {
            throw new AngryAlert("Geef een geldig emailadres");
        }
    } else {
        throw new AngryAlert("Emailadressen komen niet overeen.");
    }
}

function emailIsAvailableInDatabase($email) {
    $stmt = $GLOBALS["db"]->prepare("
    SELECT
        `email`
    FROM
        `user`
    WHERE 
      `email` = :email
    ");

    $stmt->bindParam(":email", $email);
    $stmt->execute();
    if ($stmt->rowCount()) {
        throw new AngryAlert("Emailadres wordt al gebruikt.");
    }
}

function doChangeEmail($email) {
    $stmt = $GLOBALS["db"]->prepare("
    UPDATE
        `user`
    SET
      `email` = :email
    WHERE
      `userID` = :userID
    ");
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":userID", $_SESSION["userID"]);
    $stmt->execute();
//    return $stmt->rowCount();

    if ($stmt->rowCount()) {
        throw new HappyAlert("Emailadres is veranderd.");
    } else {
        throw new AngryAlert();
    }
}

function updateAvatar() {
    $profilePictureDir = "/var/www/html/public/";
    $relativePath = "uploads/profilepictures/" . $_SESSION["userID"] . "_avatar.png";

    checkAvatarSize($_FILES["pp"]["tmp_name"]);
    $scaledImg = scaleAvatar($_FILES["pp"]["tmp_name"]);
    removeOldAvatar();
    imagepng($scaledImg, $profilePictureDir . $relativePath);
    setAvatarToDatabase("../" . $relativePath);
    throw new HappyAlert("Profielfoto veranderd.");
}

function removeOldAvatar() {
    $stmt = $GLOBALS["db"]->prepare("
    SELECT
        `profilepicture`
     FROM 
        `user`
    WHERE 
        `userID` = :userID
    ");
    $stmt->bindParam(":userID", $_SESSION["userID"]);
    $stmt->execute();
    $old_avatar = $stmt->fetch()["profilepicture"];
    if ($old_avatar != NULL) {
        unlink("/var/www/html/public/uploads/" . $old_avatar);
    }
}

function setAvatarToDatabase(string $url) {
    $stmt = $GLOBALS["db"]->prepare("
    UPDATE
        `user`
    SET
        `profilepicture` = :avatar
    WHERE
        `userID` = :userID
    ");

    $stmt->bindParam(":avatar", $url);
    $stmt->bindParam(":userID", $_SESSION["userID"]);
    $stmt->execute();
}

function checkAvatarSize(string $img) {
    $minResolution = 200;
    $imgSize = getimagesize($img);
    if ($imgSize[0] < $minResolution or $imgSize[1] < $minResolution) {
        throw new AngryAlert("Afbeelding te klein, minimaal 200x200 pixels.");
    }
}

function scaleAvatar(string $imgLink, int $newWidth = 600) {
    $img = imagecreatefromstring(file_get_contents($imgLink));
    if ($img) {
        return imagescale($img, $newWidth);
    } else {
        throw new AngryAlert("Afbeelding wordt niet ondersteund.");
    }
}
<?php

class settingsMessage {
    private $class;
    private $message;

    /**
     * settingsMessage constructor.
     * @param string $type Happy or angry
     * @param string $message The message to display
     */
    public function __construct($type, $message) {
        $this->message = $message;
        switch ($type) {
            case "happy":
                $this->class = "settings-message-happy";
                break;
            case "angry":
                $this->class = "settings-message-angry";
                break;
            default:
                $this->class = "settings-message";
                break;
        }
    }

    public function getClass() {
        return $this->class;
    }

    public function getMessage() {
        return $this->message;
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

    return new settingsMessage("happy", "Instellingen zijn opgeslagen.");
}

function changePassword() {
    $user = getPasswordHash();
    if (password_verify($_POST["password-old"], $user["password"])) {
        if ($_POST["password-new"] == $_POST["password-confirm"] && (strlen($_POST["password-new"]) >= 8)) {
            if (doChangePassword()) {
                return new settingsMessage("happy", "Wachtwoord gewijzigd.");
            } else {
                return new settingsMessage("angry", "Er is iets mis gegaan.");
            }
        } else {
            return new settingsMessage("angry", "Wachtwoorden komen niet oveen.");
        }
    } else {
        return new settingsMessage("angry", "Oud wachtwoord niet correct.");
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
    return $stmt->rowCount();
}

function changeEmail() {

    if ($_POST["email"] == $_POST["email-confirm"]) {
        $email = strtolower($_POST["email"]);
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            //check if email exists
            if (emailIsAvailableInDatabase($email)) {
                if (doChangeEmail($email)) {
                    return new settingsMessage("happy", "Emailadres is veranderd.");
                } else {
                    return new settingsMessage("angry", "Er is iets mis gegaan.");
                }
            } else {
                return new settingsMessage("angry", "Emailadres bestaat al.");
            }
        } else {
            return new settingsMessage("angry", "Geef een geldig emailadres.");
        }
    } else {
        return new settingsMessage("angry", "Emailadressen komen niet overeen.");
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
    return !$stmt->rowCount();
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
    return $stmt->rowCount();
}

function updateProfilePicture() {
    $profilePictureDir = "/var/www/html/public/";
    $relativePath = "uploads/profilepictures/" . $_SESSION["userID"] . "_" . basename($_FILES["pp"]["name"]);
//    removeOldProfilePicture();
    move_uploaded_file($_FILES['pp']['tmp_name'], $profilePictureDir . $relativePath);
    setProfilePictureToDatabase("../" . $relativePath);
}

//function removeOldProfilePicture() {
//
//    unlink("/var/www/html/public/uploads/profilepictures/" . $_SESSION["userID"] . "_*");
//}

function setProfilePictureToDatabase($url) {
    $stmt = $GLOBALS["db"]->prepare("
    UPDATE
        `user`
    SET
        `profilepicture` = :profilePicture
    WHERE
        `userID` = :userID
    ");

    $stmt->bindParam(":profilePicture", $url);
    $stmt->bindParam(":userID", $_SESSION["userID"]);
    $stmt->execute();
}
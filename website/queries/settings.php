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

    $stmt->bindParam(":fname", $_POST["fname"]);
    $stmt->bindParam(":lname", $_POST["lname"]);
    $stmt->bindParam(":location", $_POST["location"]);
    $stmt->bindParam(":bday", $_POST["bday"]);
    $stmt->bindParam(":bio", $_POST["bio"]);
    $stmt->bindParam(":userID", $_SESSION["userID"]);

    $stmt->execute();

    return new settingsMessage("happy", "Instellingen zijn opgeslagen.");
}

function updatePassword() {
    $user = getPasswordHash();
    if (password_verify($_POST["password-old"], $user["password"])) {
        if ($_POST["password-new"] == $_POST["password-confirm"] && (strlen($_POST["password-new"]) >= 8)) {
            if (changePassword()) {
                return new settingsMessage("happy", "Wachtwoord gewijzigd.");
            } else {
                return new settingsMessage("settings-message-angry", "Er is iets mis gegaan.");
            }
        } else {
            return new settingsMessage("settings-message-angry", "Wachtwoorden komen niet oveeen.");
        }
    } else {
        return new settingsMessage("settings-message-angry", "Oud wachtwoord niet correct.");
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
    return $stmt->rowCount();
}
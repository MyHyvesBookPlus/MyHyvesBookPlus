<?php
include_once "../queries/emailconfirm.php";
include_once "../queries/picture.php";
include_once "../queries/alerts.php";

/**
 * Gets the settings form the database.
 * @return mixed Setting as an array.
 */
function getSettings() {
    $stmt = prepareQuery("
    SELECT
      `fname`,
      `lname`,
      `email`,
      `location`,
      `birthdate`,
      `bio`,
      `profilepicture`,
      `showBday`,
      `showEmail`
    FROM
      `user`
    WHERE
      `userID` = :userID
      ");

    $stmt->bindParam(":userID", $_SESSION["userID"]);
    $stmt->execute();
    return $stmt->fetch();
}

/**
 * Gets the passwordHas form the database
 * @return mixed passwordhash
 */
function getPasswordHash() {
    $stmt = prepareQuery("
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

/**
 * Changes the setting from post.
 * @throws HappyAlert
 */
function updateSettings() {
    $stmt = prepareQuery("
    UPDATE
      `user`
    SET
      `fname` = :fname,
      `lname` = :lname,
      `location` = :location,
      `birthdate` = :bday,
      `bio` = :bio,
      `showEmail` = :showEmail,
      `showBday` = :showBday
    WHERE
      `userID` = :userID
    ");
    $bday = new DateTime();
    $bday->setDate(test_input($_POST["year"]), test_input($_POST["month"]), test_input($_POST["day"]));
    checkBday($bday);

    $stmt->bindValue(":fname", test_input($_POST["fname"]));
    $stmt->bindValue(":lname", test_input($_POST["lname"]));
    $stmt->bindValue(":location", test_input($_POST["location"]));
    $stmt->bindValue(":bday", $bday->format("Ymd"));
    $stmt->bindValue(":bio", test_input($_POST["bio"]));
    $stmt->bindValue(":showEmail", (array_key_exists("showEmail", $_POST) ? "1" : "0"));
    $stmt->bindValue(":showBday", (array_key_exists("showBday", $_POST) ? "1" : "0"));

    $stmt->bindValue(":userID", $_SESSION["userID"]);
    $stmt->execute();
    throw new HappyAlert("Instellingen zijn opgeslagen.");
}

function checkBday(DateTime $bday) {
    $today = new DateTime();
    if ($bday >= $today) {
        throw new AngryAlert("Jij bent vast niet in de toekomst geboren toch? ;)");
    }
}


/**
 * Change
 * @throws AngryAlert
 */
function changePassword() {
    $user = getPasswordHash();
    if (password_verify($_POST["password-old"], test_input($user["password"]))) {
        if (test_input($_POST["password-new"]) == test_input($_POST["password-confirm"]) && (strlen(test_input($_POST["password-new"])) >= 8)) {
            doChangePassword();
        } else {
            throw new AngryAlert("Wachtwoorden komen niet overeen.");
        }
    } else {
        throw new AngryAlert("Oud wachtwoord niet correct.");
    }
}

/**
 * @throws AngryAlert
 * @throws HappyAlert
 */
function doChangePassword() {
    $stmt = prepareQuery("
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

    if (test_input($_POST["email"]) == test_input($_POST["email-confirm"])) {
        $email = strtolower(test_input($_POST["email"]));
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
    $stmt = prepareQuery("
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
    $stmt = prepareQuery("
    UPDATE
        `user`
    SET
      `email` = :email,
      `role` = 'unconfirmed'
    WHERE
      `userID` = :userID
    ");
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":userID", $_SESSION["userID"]);
    $stmt->execute();

    if ($stmt->rowCount()) {
        sendConfirmEmail($_SESSION["userID"]);
        session_destroy();
        throw new HappyAlert("Emailadres is veranderd.");
    } else {
        throw new AngryAlert();
    }
}
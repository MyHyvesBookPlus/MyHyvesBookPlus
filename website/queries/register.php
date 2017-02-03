<?php

/**
 * Returns 1 if an username exists with the filled in username.
 * @return int
 */
function getExistingUsername() {
    $stmt = prepareQuery("
    SELECT
      `username`
    FROM
      `user`
    WHERE
      `username` LIKE :username
    ");

    $stmt->bindValue(":username", test_input($_POST["username"]));
    $stmt->execute();
    return $stmt->rowCount();

}

/**
 * Returns 1 if an username exists with facebooklogin
 * @return int
 */
function getExistingFBUsername() {
    $stmt = prepareQuery("
    SELECT
      `username`
    FROM
      `user`
    WHERE
      `username` LIKE :username
    ");

    $stmt->bindValue(":username", test_input($_POST["fbUsername"]));
    $stmt->execute();
    return $stmt->rowCount();

}

/**
 * Returns 1 if an email exists with the filled in email.
 * @return int
 */
function getExistingEmail() {
    $stmt = prepareQuery("
    SELECT
      `email`
    FROM
      `user`
    WHERE
      `email` LIKE :email
    ");

    $stmt->bindValue(":email", test_input($_POST["email"]));
    $stmt->execute();
    return $stmt->rowCount();

}

/**
 * Returns 1 if an email exists with facebook register
 * @return int
 */
function getExistingFBEmail() {
    $stmt = prepareQuery("
    SELECT
      `email`,
      `userID`
    FROM
      `user`
    WHERE
      `email` LIKE :email
    ");

    $stmt->bindValue(":email", test_input($_POST["fbEmail"]));
    $stmt->execute();
    return $stmt->rowCount();

}

/**
 * Returns 1 if an email exists with the forgot email input
 * @return int
 */
function getResetEmail() {
    $stmt = prepareQuery("
    SELECT
      `email`
    FROM
      `user`
    WHERE
      `email` LIKE :email
    ");

    $stmt->bindValue(":email", test_input($_POST["forgotEmail"]));
    $stmt->execute();
    return $stmt->rowCount();

}

/**
 * Registers a new account in the database
 */
function registerAccount() {
    $stmt = prepareQuery("
    INSERT INTO
      `user`(fname,
             lname,
             birthdate,
             username,
             password,
             location,
             email)
    VALUES(
      :fname,
      :lname,
      :bday,
      :username,
      :password,
      :location,
      :email
    )");
    $day_date = test_input(($_POST["day_date"]));
    $month_date = test_input(($_POST["month_date"]));
    $year_date = test_input(($_POST["year_date"]));
    $bday = $year_date . "-" . $month_date . "-" . $day_date;

    $hash=password_hash($_POST["password"], PASSWORD_DEFAULT);

    $stmt->bindValue(":fname", test_input($_POST["name"]));
    $stmt->bindValue(":lname", test_input($_POST["surname"]));
    $stmt->bindValue(":bday", test_input($bday));
    $stmt->bindValue(":username", test_input($_POST["username"]));
    $stmt->bindValue(":password", test_input($hash));
    $stmt->bindValue(":location", test_input($_POST["location"]));
    $stmt->bindValue(":email", test_input(strtolower($_POST["email"])));

    $stmt->execute();
    $stmt->rowCount();
}

/**
 * Registers a new account with facebook register
 */
function fbRegisterAccount() {
    $stmt = prepareQuery("
    INSERT INTO
      `user`(fname,
             lname,
             birthdate,
             username,
             password,
             email,
             facebookID,
             role)
    VALUES(
      :fname,
      :lname,
      :bday,
      :username,
      :password,
      :email,
      :facebookID,
      'user'
    )");
    $fbDay_date = test_input(($_POST["fbDay_date"]));
    $fbMonth_date = test_input(($_POST["fbMonth_date"]));
    $fbYear_date = test_input(($_POST["fbYear_date"]));
    $fbBday = $fbYear_date . "-" . $fbMonth_date . "-" . $fbDay_date;

    $hash=password_hash($_POST["fbPassword"], PASSWORD_DEFAULT);

    $stmt->bindValue(":fname", test_input($_POST["fbName"]));
    $stmt->bindValue(":lname", test_input($_POST["fbSurname"]));
    $stmt->bindValue(":bday", test_input($fbBday));
    $stmt->bindValue(":username", test_input($_POST["fbUsername"]));
    $stmt->bindValue(":facebookID", test_input($_POST["fbUserID"]));
    $stmt->bindValue(":password", test_input($hash));
    $stmt->bindValue(":email", test_input(strtolower($_POST["fbEmail"])));

    return $stmt->execute();
}

/**
 * Checks which dates need to be selected when there is an invalid registration.
 * @param $date
 * @param $value
 */
function submitselect($date, $value){
    if ($date == $value){
        echo "selected";
    }
}
?>

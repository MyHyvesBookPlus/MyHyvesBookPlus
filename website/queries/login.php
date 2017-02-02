<?php

function getUser() {
    $stmt = prepareQuery("
    SELECT
      `password`,
      `userID`,
      `role`
    FROM
      `user`
    WHERE
      `username` LIKE :username OR 
      `email` LIKE :username
    ");

    $stmt->bindValue(":username", test_input($_POST["user"]));
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getUserID() {
    $stmt = prepareQuery("
    SELECT
      `userID`
    FROM
      `user`
    WHERE
      `username` LIKE :username
    ");

    $stmt->bindValue(":username", test_input($_POST["username"]));
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function validateLogin($username, $password, $url){
    // Empty username or password field
    if (empty($username) || empty($password)) {
        throw new loginException("Inloggegevens zijn niet ingevuld");
    }
    else {
        $psw = test_input($password);
        $hash = getUser()["password"];
        $userID = getUser()["userID"];
        $role = getUser()["role"];

        // If there's an account, go to the profile page
        if(password_verify($psw, $hash)) {
            if ($role == "banned"){
                echo "<script>
                         window.onload=bannedAlert();
                    </script>";

            } else if ($role == "frozen") {
                $_SESSION["userID"] = $userID;
                if (!isset($url) or $url = "") {
                echo "<script>
                         window.onload=frozenAlert();
                         window.location.href= 'profile.php';
                    </script>";
                } else {
                    echo "<script>
                         window.onload=frozenAlert();
                         window.location.href= $url;
                    </script>";
                }

            } else if ($role == "unconfirmed"){
                sendConfirmEmail(getUser()["userID"]);
                echo "<script>
                         window.onload=emailNotConfirmed();
                    </script>";

            } else {
                $_SESSION["userID"] = $userID;
                if(!isset($url) or $url == "") {
                    header("location: profile.php");
                } else{
                    header("location: $url");
                }

            }
        } else {
            throw new loginException("Inloggevens zijn niet correct");
        }

    }
}

function fbLogin($fbID) {
    $stmt = prepareQuery("
    SELECT
      `email`,
      `userID`,
      `role`
    FROM
      `user`
    WHERE
      `facebookID` LIKE :facebookID
    ");

    $stmt->bindValue(":facebookID", $fbID);
    $stmt->execute();
    return $stmt->rowCount();

}

function getfbUserID($fbID) {
    $stmt = prepareQuery("
    SELECT
      `userID`,
      `role`
    FROM
      `user`
    WHERE
      `facebookID` LIKE :facebookID
    ");

    $stmt->bindValue(":facebookID", $fbID);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

class loginException extends Exception
{
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}


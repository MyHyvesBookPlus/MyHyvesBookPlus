<?php

function getUser() {
    $stmt = $GLOBALS["db"]->prepare("
    SELECT
      `password`,
      `userID`,
      `role`
    FROM
      `user`
    WHERE
      `username` LIKE :username
    ");

    $stmt->bindParam(":username", $_POST["uname"]);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function validateLogin($username, $password){
    // Empty username or password field
    if (empty($username) || empty($password)) {
        throw new loginException("Gebruikersnaam of wachtwoord is niet ingevuld");
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
            } else {
                $_SESSION["userID"] = $userID;
                header("location: profile.php");
            }
        } else {
            throw new loginException("Inloggevens zijn niet correct");
        }

    }
}

class loginException extends Exception
{
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
?>
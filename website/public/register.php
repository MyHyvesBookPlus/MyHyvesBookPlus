<!DOCTYPE html>
<html>
<?php
    include("../views/login_head.php");
    require_once("../queries/connect.php");
    include_once("../queries/register.php");

?>
<body>
<?php
    session_start();

    // define variables and set to empty values
    $name = $surname = $bday = $username = $password = $confirmpassword = $location = $housenumber = $email = "";
    $genericErr = $nameErr = $surnameErr = $bdayErr = $usernameErr = $passwordErr = $confirmpasswordErr = $locationErr = $housenumberErr = $emailErr = "";
    $correct = true;

    // Trying to register an account
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["name"])) {
            $nameErr = "Naam is verplicht!";
            $correct = false;

        } else {
            $name = test_input($_POST["name"]);
            if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
                $nameErr = "Alleen letters en spaties zijn toegestaan!";
                $correct = false;

            }
        }

        if (empty($_POST["surname"])) {
            $surnameErr = "Achternaam is verplicht!";
            $correct = false;

        } else {
            $surname = test_input($_POST["surname"]);
            if (!preg_match("/^[a-zA-Z ]*$/",$surname)) {
                $surnameErr = "Alleen letters en spaties zijn toegestaan!";
                $correct = false;

            }
        }
        if (empty($_POST["bday"])) {
            $bdayErr = "Geboortedatum is verplicht!";
            $correct = false;

        }

        if (empty($_POST["username"])) {
            $usernameErr = "Gebruikersnaam is verplicht!";
            $correct = false;

        } else {
            $username = test_input($_POST["username"]);
            if (strlen($username) < 6) {
                $usernameErr = "Gebruikersnaam moet minstens 6 karakters bevatten";
                $correct = false;

            } else if (getExistingUsername() == 1){
                $usernameErr = "Gebruikersnaam bestaat al";
                $correct = false;

            }
        }

        if (empty($_POST["password"])) {
            $passwordErr = "Wachtwoord is verplicht!";
            $correct = false;

        } else {
            $password = test_input($_POST["password"]);
            if (strlen($password) < 8) {
                $passwordErr = "Wachtwoord moet minstens 8 karakters bevatten";
                $correct = false;

            }
        }

        if (empty($_POST["confirmpassword"])) {
            $confirmpasswordErr = "Herhaal wachtwoord!";
            $correct = false;

        }

        if ($_POST["password"] != $_POST["confirmpassword"]) {
            $confirmpasswordErr = "Wachtwoorden matchen niet";
            $correct = false;

        }

        if (empty($_POST["location"])) {
            $locationErr = "Straatnaam is verplicht!";
            $correct = false;

        } else {
            $location = test_input($_POST["location"]);
            if (!preg_match("/^[a-zA-Z ]*$/",$location)) {
                $locationErr = "Alleen letters en spaties zijn toegestaan!";
                $correct = false;

            }
        }

        if (empty($_POST["email"])) {
            $emailErr = "Email is verplicht!";
            $correct = false;

        } else {
            $email = test_input($_POST["email"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Geldige email invullen!";
                $correct = false;

            } else if (getExistingEmail() == 1){
                $emailErr = "Email bestaat al";
                $correct = false;

            }
        }

        // Checks if everything is filled in correctly
        if ($correct == false){
            $genericErr = "Bepaalde velden zijn verkeerd of niet ingevuld!";

        } else {
            registerAccount();
            header("location: login.php");

        }
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

/* This view adds register view */
include("../views/register-view.php");
?>
</body>
</html>

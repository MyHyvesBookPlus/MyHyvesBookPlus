<!DOCTYPE html>
<html>
<?php
    include("../views/login_head.php");
    include_once("../queries/connect.php");

?>
<body>
<?php
    session_start();

    // define variables and set to empty values
    $name = $surname = $bday = $username = $password = $confirmpassword = $streetname = $housenumber = $email = "";
    $genericErr = $nameErr = $surnameErr = $bdayErr = $usernameErr = $passwordErr = $confirmpasswordErr = $streetnameErr = $housenumberErr = $emailErr = "";
    $correct = true;

    // Saves information of filling in the form
    if (isset($_POST["name"])) {
        $name = $_POST["name"];
    }

    if (isset($_POST["surname"])) {
        $surname = $_POST["surname"];
    }

    if (isset($_POST["bday"])) {
        $bday = $_POST["bday"];
    }

    if (isset($_POST["username"])) {
        $username = $_POST["username"];
    }

    if (isset($_POST["password"])) {
        $password = $_POST["password"];
    }

    if (isset($_POST["streetname"])) {
        $streetname = $_POST["streetname"];
    }

    if (isset($_POST["housenumber"])) {
        $housenumber = $_POST["housenumber"];
    }

    if (isset($_POST["email"])) {
        $email = $_POST["email"];
    }

    // Trying to register an account
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["name"])) {
            $nameErr = "Naam is verplicht!";
            $correct = false;

        } else {
            if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
                $nameErr = "Alleen letters en spaties zijn toegestaan!";
                $correct = false;

            }
        }

        if (empty($_POST["surname"])) {
            $surnameErr = "Achternaam is verplicht!";
            $correct = false;

        } else {
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
            if (strlen($username) < 6) {
                $usernameErr = "Gebruikersnaam moet minstens 6 karakters bevatten";
                $correct = false;

            }
        }

        if (empty($_POST["password"])) {
            $passwordErr = "Wachtwoord is verplicht!";
            $correct = false;

        } else {
            if (strlen($password) < 8) {
                $passwordErr = "Wachtwoord moet minstens 8 karakters bevatten";
                $correct = false;

            }
        }

        if (empty($_POST["confirmpassword"])) {
            $confirmpasswordErr = "Herhaal wachtwoord!";
            $correct = false;

        }

        if ($_POST["password"]!= $_POST["confirmpassword"]) {
            $confirmpasswordErr = "Wachtwoorden matchen niet";
            $correct = false;

        }

        if (empty($_POST["streetname"])) {
            $streetnameErr = "Straatnaam is verplicht!";
            $correct = false;

        } else {
            if (!preg_match("/^[a-zA-Z ]*$/",$streetname)) {
                $streetnameErr = "Alleen letters en spaties zijn toegestaan!";
                $correct = false;

            }
        }

        if (empty($_POST["housenumber"])) {
            $housenumberErr = "Huisnummer is verplicht!";
            $correct = false;

        }

        if (empty($_POST["email"])) {
            $emailErr = "Email is verplicht!";
            $correct = false;

        } else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Geldige email invullen!";
                $correct = false;
            }
        }

        // Checks if everything is filled in correctly
        if ($correct == false){
            $genericErr = "Bepaalde velden zijn verkeerd of niet ingevuld!";

        } else {
            $servername = "agile136.science.uva.nl";
            $username = "mhbp";
            $password = "qdtboXhCHJyL2szC";

            // Creates connection
            $conn = new mysqli($servername, $username, $password);

            // Checks connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Query for inserting all the data in the database
            $sql = "INSERT INTO
            VALUES ($name, $surname, $bday, $username, $password,
                    $confirmpassword, $streetname, $housenumber, $email)";

            // Checks if able to insert into database
            if (mysqli_query($conn, $sql)) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }



            <?php
                /* Execute a prepared statement by binding PHP variables */
                $calories = 150;
                $colour = 'red';
                $sth = $dbh->prepare('SELECT name, colour, calories
                    FROM fruit
                    WHERE calories < :calories AND colour = :colour');
                $sth->bindParam(':calories', $calories, PDO::PARAM_INT);
                $sth->bindParam(':colour', $colour, PDO::PARAM_STR, 12);
                $sth->execute();
            ?>



            // Closing connection
            mysql_close($connection);
        }
    }

/* This view adds register view */
include("../views/register-view.php");
?>
</body>
</html>
